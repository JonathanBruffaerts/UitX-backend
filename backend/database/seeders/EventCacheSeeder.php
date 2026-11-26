<?php

namespace Database\Seeders;

use App\Models\EventCache;
use Illuminate\Database\Seeder;

class EventCacheSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'event_id' => '9f1b4c20-8a11-4d3e-9c01-111111111111',
                'title' => 'Club Night: Brussels Bass Collective',
                'location_name' => 'Ancienne Belgique',
                'address' => 'Anspachlaan 110, 1000 Brussel',
                'city' => 'Brussel',
                'start_date' => '2026-12-05 22:00:00',
                'latitude' => 50.84735000,
                'longitude' => 4.34901000,
                'payload' => [
                    '@id' => 'https://io-test.uitdatabank.be/event/9f1b4c20-8a11-4d3e-9c01-111111111111',
                    'name' => ['nl' => 'Club Night: Brussels Bass Collective'],
                    'description' => ['nl' => 'Nacht vol drum & bass, UK garage en lokale Brusselse DJ’s in de AB Club.'],
                    'startDate' => '2026-12-05T22:00:00+01:00',
                    'endDate' => '2026-12-06T04:00:00+01:00',
                    'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1080',
                    'location' => [
                        'name' => ['nl' => 'Ancienne Belgique'],
                        'address' => [
                            'nl' => [
                                'streetAddress' => 'Anspachlaan 110',
                                'postalCode' => '1000',
                                'addressLocality' => 'Brussel',
                            ],
                        ],
                        'geo' => [
                            'latitude' => 50.84735,
                            'longitude' => 4.34901,
                        ],
                    ],
                    'priceInfo' => [
                        ['category' => 'base', 'name' => ['nl' => 'Basistarief'], 'price' => 16.0, 'priceCurrency' => 'EUR'],
                        ['category' => 'tariff', 'name' => ['nl' => '-26 jaar'], 'price' => 12.0, 'priceCurrency' => 'EUR'],
                    ],
                    'bookingInfo' => [
                        'url' => 'https://www.abconcerts.be/nl/agenda',
                        'urlLabel' => ['nl' => 'Koop tickets'],
                    ],
                ],
            ],
            [
                'event_id' => '9f1b4c20-8a11-4d3e-9c02-222222222222',
                'title' => 'Late Night Expo: Digital Mirrors',
                'location_name' => 'Kanal - Centre Pompidou',
                'address' => 'Sainctelettesquare 21, 1000 Brussel',
                'city' => 'Brussel',
                'start_date' => '2026-12-11 19:00:00',
                'latitude' => 50.85891000,
                'longitude' => 4.34848000,
                'payload' => [
                    '@id' => 'https://io-test.uitdatabank.be/event/9f1b4c20-8a11-4d3e-9c02-222222222222',
                    'name' => ['nl' => 'Late Night Expo: Digital Mirrors'],
                    'description' => ['nl' => 'Interactieve licht- en video-installaties met live ambient-sets tot middernacht.'],
                    'startDate' => '2026-12-11T19:00:00+01:00',
                    'endDate' => '2026-12-11T23:59:00+01:00',
                    'image' => 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=1080',
                    'location' => [
                        'name' => ['nl' => 'Kanal - Centre Pompidou'],
                        'address' => [
                            'nl' => [
                                'streetAddress' => 'Sainctelettesquare 21',
                                'postalCode' => '1000',
                                'addressLocality' => 'Brussel',
                            ],
                        ],
                        'geo' => [
                            'latitude' => 50.85891,
                            'longitude' => 4.34848,
                        ],
                    ],
                    'priceInfo' => [
                        ['category' => 'base', 'name' => ['nl' => 'Gratis'], 'price' => 0.0, 'priceCurrency' => 'EUR'],
                    ],
                    'bookingInfo' => [
                        'url' => 'https://kanal.brussels/nl',
                        'urlLabel' => ['nl' => 'Reserveer gratis plek'],
                    ],
                ],
            ],
            [
                'event_id' => '9f1b4c20-8a11-4d3e-9c03-333333333333',
                'title' => 'Open Mic & Comedy Night',
                'location_name' => 'Het Depot',
                'address' => 'Martelarenplein 12, 3000 Leuven',
                'city' => 'Leuven',
                'start_date' => '2026-12-12 20:30:00',
                'latitude' => 50.88196000,
                'longitude' => 4.71451000,
                'payload' => [
                    '@id' => 'https://io-test.uitdatabank.be/event/9f1b4c20-8a11-4d3e-9c03-333333333333',
                    'name' => ['nl' => 'Open Mic & Comedy Night'],
                    'description' => ['nl' => 'Zes opkomende comedians testen nieuw materiaal in de foyer van Het Depot.'],
                    'startDate' => '2026-12-12T20:30:00+01:00',
                    'endDate' => '2026-12-12T23:00:00+01:00',
                    'image' => 'https://images.unsplash.com/photo-1585699324551-f6c309eedeca?w=1080',
                    'location' => [
                        'name' => ['nl' => 'Het Depot'],
                        'address' => [
                            'nl' => [
                                'streetAddress' => 'Martelarenplein 12',
                                'postalCode' => '3000',
                                'addressLocality' => 'Leuven',
                            ],
                        ],
                        'geo' => [
                            'latitude' => 50.88196,
                            'longitude' => 4.71451,
                        ],
                    ],
                    'priceInfo' => [
                        ['category' => 'base', 'name' => ['nl' => 'Basistarief'], 'price' => 10.0, 'priceCurrency' => 'EUR'],
                    ],
                    'bookingInfo' => [
                        'url' => 'https://www.hetdepot.be',
                        'urlLabel' => ['nl' => 'Tickets'],
                    ],
                ],
            ],
            [
                'event_id' => '9f1b4c20-8a11-4d3e-9c04-444444444444',
                'title' => 'Indie Showcase: Winter Sessions',
                'location_name' => 'Trix',
                'address' => 'Noordersingel 28, 2140 Antwerpen',
                'city' => 'Antwerpen',
                'start_date' => '2026-12-18 20:00:00',
                'latitude' => 51.21623000,
                'longitude' => 4.44462000,
                'payload' => [
                    '@id' => 'https://io-test.uitdatabank.be/event/9f1b4c20-8a11-4d3e-9c04-444444444444',
                    'name' => ['nl' => 'Indie Showcase: Winter Sessions'],
                    'description' => ['nl' => 'Drie Belgische indie- en shoegazebands op één avond in Trix Bar.'],
                    'startDate' => '2026-12-18T20:00:00+01:00',
                    'endDate' => '2026-12-19T00:30:00+01:00',
                    'image' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?w=1080',
                    'location' => [
                        'name' => ['nl' => 'Trix'],
                        'address' => [
                            'nl' => [
                                'streetAddress' => 'Noordersingel 28',
                                'postalCode' => '2140',
                                'addressLocality' => 'Antwerpen',
                            ],
                        ],
                        'geo' => [
                            'latitude' => 51.21623,
                            'longitude' => 4.44462,
                        ],
                    ],
                    'priceInfo' => [
                        ['category' => 'base', 'name' => ['nl' => 'Voorverkoop'], 'price' => 14.5, 'priceCurrency' => 'EUR'],
                    ],
                    'bookingInfo' => [
                        'url' => 'https://www.trixonline.be',
                        'urlLabel' => ['nl' => 'Koop tickets'],
                    ],
                ],
            ],
            [
                'event_id' => '9f1b4c20-8a11-4d3e-9c05-555555555555',
                'title' => 'Vintage Market & Vinyl Swap',
                'location_name' => 'Kunstencentrum VIERNULVIER (Vooruit)',
                'address' => 'Sint-Pietersnieuwstraat 23, 9000 Gent',
                'city' => 'Gent',
                'start_date' => '2026-12-20 13:00:00',
                'latitude' => 51.04775000,
                'longitude' => 3.72792000,
                'payload' => [
                    '@id' => 'https://io-test.uitdatabank.be/event/9f1b4c20-8a11-4d3e-9c05-555555555555',
                    'name' => ['nl' => 'Vintage Market & Vinyl Swap'],
                    'description' => ['nl' => 'Tweedehands streetwear, platenbakken en koffie in de balzaal.'],
                    'startDate' => '2026-12-20T13:00:00+01:00',
                    'endDate' => '2026-12-20T19:00:00+01:00',
                    'image' => 'https://images.unsplash.com/photo-1483412033650-1015ddeb83d1?w=1080',
                    'location' => [
                        'name' => ['nl' => 'Kunstencentrum VIERNULVIER'],
                        'address' => [
                            'nl' => [
                                'streetAddress' => 'Sint-Pietersnieuwstraat 23',
                                'postalCode' => '9000',
                                'addressLocality' => 'Gent',
                            ],
                        ],
                        'geo' => [
                            'latitude' => 51.04775,
                            'longitude' => 3.72792,
                        ],
                    ],
                    'priceInfo' => [
                        ['category' => 'base', 'name' => ['nl' => 'Inkom'], 'price' => 3.0, 'priceCurrency' => 'EUR'],
                    ],
                    'bookingInfo' => [
                        'url' => 'https://www.viernulvier.gent',
                        'urlLabel' => ['nl' => 'Meer info'],
                    ],
                ],
            ],
        ];

        foreach ($events as $event) {
            EventCache::updateOrCreate(
                ['event_id' => $event['event_id']],
                [...$event, 'cached_at' => now()]
            );
        }
    }
}