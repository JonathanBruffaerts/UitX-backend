<?php

namespace App\Http\Controllers;

use App\Models\EventCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cacheQuery = fn () => EventCache::query()
            ->when($request->filled('city'), fn ($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%' . $request->string('search')->toString() . '%'))
            ->orderBy('start_date')
            ->paginate(20);

        $cache = $cacheQuery();

        if ($cache->count() > 0) {
            return response()->json($cache);
        }

        $apiKey = config('services.uitdatabank.key');
        if (! $apiKey) {
            return response()->json(['message' => 'UiTdatabank API-key ontbreekt.'], 503);
        }

        $response = Http::acceptJson()
            ->withHeaders(['X-Api-Key' => $apiKey])
            ->get(config('services.uitdatabank.base_url', 'https://search-test.uitdatabank.be'), array_filter([
                'q' => $request->query('search'),
                'city' => $request->query('city'),
                'page' => $request->integer('page'),
            ], fn ($value) => $value !== null));

        if (! $response->successful()) {
            return response()->json(['message' => 'UiTdatabank is momenteel niet beschikbaar.'], 502);
        }

        $this->cachePayload($response->json(), 'member');

        return response()->json($cacheQuery());
    }

    public function show(string $eventId): JsonResponse
    {
        $cached = EventCache::find($eventId);
        if ($cached) {
            return response()->json($cached->payload);
        }

        $apiKey = config('services.uitdatabank.key');
        if (! $apiKey) {
            return response()->json(['message' => 'UiTdatabank API-key ontbreekt.'], 503);
        }

        $baseUrl = rtrim(config('services.uitdatabank.base_url', 'https://search-test.uitdatabank.be'), '/');
        $response = Http::acceptJson()
            ->withHeaders(['X-Api-Key' => $apiKey])
            ->get("{$baseUrl}/{$eventId}");

        if ($response->notFound()) {
            return response()->json(['message' => 'Event niet gevonden.'], 404);
        }

        if (! $response->successful()) {
            return response()->json(['message' => 'UiTdatabank is momenteel niet beschikbaar.'], 502);
        }

        $payload = $response->json();
        $this->cachePayload(['member' => [$payload]], 'member');

        $cached = EventCache::find($eventId);

        return response()->json($cached?->payload ?? $payload);
    }

    private function cachePayload(mixed $payload, string $memberKey): void
    {
        if (! is_array($payload) || ! isset($payload[$memberKey]) || ! is_array($payload[$memberKey])) {
            return;
        }

        foreach ($payload[$memberKey] as $item) {
            if (! is_array($item) || ! isset($item['@id'])) {
                continue;
            }

            $eventId = basename((string) $item['@id']);
            $location = is_array($item['location'] ?? null) ? $item['location'] : [];
            $addressData = $location['address']['nl'] ?? $location['address'] ?? [];
            $fullAddress = is_array($addressData)
                ? trim(implode(', ', array_filter([
                    $addressData['streetAddress'] ?? null,
                    trim(($addressData['postalCode'] ?? '') . ' ' . ($addressData['addressLocality'] ?? '')),
                ])))
                : $addressData;

            EventCache::updateOrCreate(['event_id' => $eventId], [
                'title' => $item['name']['nl'] ?? $item['name']['en'] ?? $item['name'] ?? 'Geen titel',
                'location_name' => $location['name']['nl'] ?? $location['name']['en'] ?? null,
                'address' => $fullAddress ?: null,
                'city' => $location['address']['nl']['addressLocality'] ?? $location['address']['addressLocality'] ?? null,
                'start_date' => $item['startDate'] ?? null,
                'latitude' => $location['geo']['latitude'] ?? null,
                'longitude' => $location['geo']['longitude'] ?? null,
                'payload' => $item,
                'cached_at' => now(),
            ]);
        }
    }
}
