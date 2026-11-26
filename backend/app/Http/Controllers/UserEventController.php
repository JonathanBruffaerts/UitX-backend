<?php

namespace App\Http\Controllers;

use App\Models\UserEvent;
use App\Models\Friendship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $events = $request->user()->userEvents()
            ->where(function ($query) {
                $query->where('is_going', true)
                    ->orWhere('is_saved', true);
            })
            ->with('event')
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($events);
    }

    public function setGoing(Request $request, string $eventId): JsonResponse
    {
        $entry = $this->updateState($request, $eventId, 'is_going', true);

        return response()->json($entry, 201);
    }

    public function unsetGoing(Request $request, string $eventId): JsonResponse
    {
        $entry = $this->updateState($request, $eventId, 'is_going', false);

        return response()->json($entry);
    }

    public function save(Request $request, string $eventId): JsonResponse
    {
        $entry = $this->updateState($request, $eventId, 'is_saved', true);

        return response()->json($entry, 201);
    }

    public function unsave(Request $request, string $eventId): JsonResponse
    {
        $entry = $this->updateState($request, $eventId, 'is_saved', false);

        return response()->json($entry);
    }

    public function friendsEvents(Request $request): JsonResponse
    {
        $userId = $request->user()->getKey();

        $friendIds = Friendship::query()
            ->where('status', 'accepted')
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('addressee_id', $userId);
            })
            ->get()
            ->map(fn (Friendship $friendship) => $friendship->requester_id === $userId
                ? $friendship->addressee_id
                : $friendship->requester_id)
            ->unique()
            ->values();

        $events = UserEvent::query()
            ->whereIn('user_id', $friendIds)
            ->where('is_going', true)
            ->with(['user:id,name,avatar_url', 'event'])
            ->get();

        return response()->json($events);
    }

    private function updateState(Request $request, string $eventId, string $column, bool $value): UserEvent
    {
        $entry = UserEvent::query()->firstOrNew([
            'user_id' => $request->user()->getKey(),
            'event_id' => $eventId,
        ]);

        $entry->{$column} = $value;

        if (! $entry->is_going && ! $entry->is_saved) {
            if ($entry->exists) {
                $entry->delete();
            }

            return $entry;
        }

        $entry->save();

        return $entry->load('event');
    }
}
