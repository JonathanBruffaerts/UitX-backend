<?php

namespace App\Console\Commands;

use App\Models\UserEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendEventNotifications extends Command
{
    protected $signature = 'events:send-notifications';

    protected $description = 'Verstuur Expo push-meldingen voor herinneringen, check-ins en ratings';

    public function handle(): int
    {
        $now = now();

        // 1. Herinnering: 1 dag op voorhand (start tussen nu en over 24 uur)
        $dayBeforeEvents = UserEvent::query()
            ->where('is_going', true)
            ->whereNull('day_before_notified_at')
            ->whereHas('user', fn ($q) => $q->whereNotNull('expo_push_token'))
            ->whereHas('event', fn ($q) => $q->whereBetween('start_date', [$now, $now->copy()->addDay()]))
            ->with(['user', 'event'])
            ->get();

        foreach ($dayBeforeEvents as $entry) {
            $sent = $this->sendExpoPush(
                token: $entry->user->expo_push_token,
                title: 'Morgen is het zover!',
                body: "Ga je morgen nog steeds naar {$entry->event->title}?",
                data: ['type' => 'day_before', 'event_id' => $entry->event_id]
            );

            if ($sent) {
                $entry->update(['day_before_notified_at' => $now]);
            }
        }

        // 2. Check-in: op het moment zelf (begonnen in de afgelopen 2 uur)
        $checkInEvents = UserEvent::query()
            ->where('is_going', true)
            ->where('checked_in', false)
            ->whereNull('checkin_notified_at')
            ->whereHas('user', fn ($q) => $q->whereNotNull('expo_push_token'))
            ->whereHas('event', fn ($q) => $q->whereBetween('start_date', [$now->copy()->subHours(2), $now]))
            ->with(['user', 'event'])
            ->get();

        foreach ($checkInEvents as $entry) {
            $sent = $this->sendExpoPush(
                token: $entry->user->expo_push_token,
                title: 'Ben je er al?',
                body: "Check in bij {$entry->event->title} zodat je vrienden zien dat je er bent!",
                data: ['type' => 'check_in', 'event_id' => $entry->event_id]
            );

            if ($sent) {
                $entry->update(['checkin_notified_at' => $now]);
            }
        }

        // 3. Rating: 1 dag erna (tussen 24 en 72 uur geleden begonnen)
        $reviewEvents = UserEvent::query()
            ->where('is_going', true)
            ->whereNull('rating')
            ->whereNull('review_notified_at')
            ->whereHas('user', fn ($q) => $q->whereNotNull('expo_push_token'))
            ->whereHas('event', fn ($q) => $q->whereBetween('start_date', [$now->copy()->subDays(3), $now->copy()->subDay()]))
            ->with(['user', 'event'])
            ->get();

        foreach ($reviewEvents as $entry) {
            $sent = $this->sendExpoPush(
                token: $entry->user->expo_push_token,
                title: 'Hoe was het?',
                body: "Geef {$entry->event->title} een score van 0 tot 5 sterren.",
                data: ['type' => 'rate', 'event_id' => $entry->event_id]
            );

            if ($sent) {
                $entry->update(['review_notified_at' => $now]);
            }
        }

        $this->info('Push-meldingen verwerkt.');

        return self::SUCCESS;
    }

    private function sendExpoPush(string $token, string $title, string $body, array $data = []): bool
    {
        $response = Http::acceptJson()->post('https://exp.host/--/api/v2/push/send', [
            'to' => $token,
            'sound' => 'default',
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ]);

        return $response->successful();
    }
}
