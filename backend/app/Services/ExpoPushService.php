<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExpoPushService
{
    public function send(?string $token, string $title, string $body, array $data = []): bool
    {
        if (! $token) {
            return false;
        }

        Log::info('Sending Expo push', [
            'to' => $token,
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ]);

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
