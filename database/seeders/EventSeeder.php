<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title'         => 'Annual Alumni Meet 2026',
                'description'   => 'Join us for the biggest alumni gathering of the year. Network, reminisce, and celebrate our shared heritage.',
                'venue'         => 'ZHSUST Main Campus',
                'image'         => '/event/event-img-1.jpg',
                'event_date'    => '2026-08-15',
                'event_time'    => '10:00 AM – 6:00 PM',
                'countdown_end' => '2026-08-15 23:59:59',
                'is_active'     => true,
            ],
            [
                'title'         => 'Career Fair 2026',
                'description'   => 'Connect with top employers from across the region. Bring your resume and your ambition.',
                'venue'         => 'Student Union Building',
                'image'         => '/event/event-img-2.jpg',
                'event_date'    => '2026-09-10',
                'event_time'    => '9:00 AM – 4:00 PM',
                'countdown_end' => '2026-09-10 23:59:59',
                'is_active'     => true,
            ],
            [
                'title'         => 'Alumni Webinar: AI Trends',
                'description'   => 'Distinguished alumni panel discusses the latest in artificial intelligence and machine learning.',
                'venue'         => 'Online (Zoom)',
                'image'         => '/event/event-img-3.jpg',
                'event_date'    => '2026-07-25',
                'event_time'    => '3:00 PM – 4:30 PM',
                'countdown_end' => '2026-07-25 23:59:59',
                'is_active'     => true,
            ],
            [
                'title'         => 'Homecoming Gala',
                'description'   => 'An elegant evening of dinner, dancing, and awards. Celebrate another year of alumni excellence.',
                'venue'         => 'Grand Ballroom, City Hotel',
                'image'         => '/event/event-img-4.jpg',
                'event_date'    => '2026-12-12',
                'event_time'    => '7:00 PM – 11:00 PM',
                'countdown_end' => '2026-12-12 23:59:59',
                'is_active'     => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
