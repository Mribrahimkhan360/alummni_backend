<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    public function run(): void
    {
        $notices = [
            [
                'title' => 'Annual Alumni Meet 2026 – Registrations Open',
                'excerpt' => 'Registrations are now open for the grand alumni reunion. Book your spot for a day of networking, memories, and celebration.',
                'full_content' => "The Alumni Association is thrilled to announce that registrations for the Annual Alumni Meet 2026 are officially open. This year's event promises to be the largest gathering yet, bringing together alumni from across the globe for a day of connection, reflection, and celebration.\n\nScheduled to take place on the main campus, the event will feature keynote addresses from distinguished alumni, interactive panel discussions, campus tours, cultural performances, and a gala dinner. Attendees will also have the opportunity to network with industry leaders, reconnect with old friends, and explore new collaboration opportunities.\n\nEarly bird registration is available until July 31st. Group discounts are available for batches registering together.",
                'date' => '15',
                'month' => 'MAR',
                'year' => '2026',
                'category' => 'Event',
                'image' => '/event/event-img-1.jpg',
                'author' => 'Alumni Association',
                'deadline' => 'July 31, 2026',
                'cta_label' => 'Register Now',
                'cta_link' => '/events',
                'is_active' => true,
            ],
            [
                'title' => 'New Alumni Mentorship Program Launched',
                'excerpt' => 'Applications are open for the 2026 mentorship cycle. Connect with industry leaders and accelerate your career growth.',
                'full_content' => "We are excited to launch the 2026 Alumni Mentorship Program, designed to foster meaningful connections between experienced alumni and recent graduates. The program pairs mentors and mentees based on career interests, industry, and professional goals.\n\nOver the course of six months, participants will engage in structured one-on-one sessions, attend exclusive workshops, and gain access to a private networking community. Mentors will receive recognition and invitations to special alumni events.\n\nWhether you are looking to give back or seeking guidance to take the next step in your career, this program offers invaluable opportunities for growth.",
                'date' => '28',
                'month' => 'FEB',
                'year' => '2026',
                'category' => 'General',
                'image' => '/about/about-img-1.jpg',
                'author' => 'Mentorship Committee',
                'deadline' => 'April 15, 2026',
                'cta_label' => 'Apply Now',
                'cta_link' => '#',
                'is_active' => true,
            ],
            [
                'title' => 'Scholarship Application Deadline Extended',
                'excerpt' => 'The deadline for the Alumni Merit Scholarship has been extended to March 15th. Don\'t miss this opportunity.',
                'full_content' => "Good news for prospective applicants — the deadline for the Alumni Merit Scholarship has been extended to March 15, 2026. This extension provides additional time for students to prepare and submit their applications.\n\nThe Alumni Merit Scholarship awards up to \$5,000 to outstanding students who demonstrate academic excellence, leadership potential, and community involvement. Eligible applicants must be currently enrolled students in good standing with a minimum GPA of 3.5.\n\nApplicants are required to submit a completed application form, academic transcripts, two letters of recommendation, and a personal statement outlining their goals and achievements.",
                'date' => '10',
                'month' => 'FEB',
                'year' => '2026',
                'category' => 'Scholarship',
                'image' => '/about/about-img-2.jpg',
                'author' => 'Scholarship Board',
                'deadline' => 'March 15, 2026',
                'cta_label' => 'Apply for Scholarship',
                'cta_link' => '#',
                'is_active' => true,
            ],
            [
                'title' => 'Save the Date – Campus Homecoming 2026',
                'excerpt' => 'Mark your calendars for the annual homecoming event on December 12th. More details coming soon.',
                'full_content' => "The Alumni Association is pleased to announce that the annual Campus Homecoming 2026 will take place on December 12, 2026. This beloved tradition brings together alumni, faculty, and current students for a day of celebration and school spirit.\n\nThe homecoming festivities will include a parade, tailgate party, football game, class reunions, and the traditional homecoming dance. Alumni from all graduating classes are encouraged to attend and show their pride.\n\nDetailed schedules, ticket information, and accommodation options will be released in the coming months. Stay tuned for updates.",
                'date' => '20',
                'month' => 'JAN',
                'year' => '2026',
                'category' => 'Event',
                'image' => '/event/event-img-4.jpg',
                'author' => 'Alumni Association',
                'deadline' => null,
                'cta_label' => 'Get Reminder',
                'cta_link' => '/events',
                'is_active' => true,
            ],
            [
                'title' => 'Alumni Achievement Awards – Nominations Open',
                'excerpt' => 'Nominate a fellow alumnus for the 2026 Alumni Achievement Awards across multiple categories.',
                'full_content' => "The Alumni Achievement Awards recognize graduates who have made significant contributions in their professional fields, communities, and to the university. Nominations are now open across five categories: Professional Excellence, Community Service, Entrepreneurial Leadership, Young Alumni Achievement, and Lifetime Achievement.\n\nAward recipients will be honored at a special ceremony during the Annual Alumni Meet in August. Each recipient will receive a commemorative trophy, a certificate of achievement, and recognition in university publications.\n\nSelf-nominations and third-party nominations are both welcome. The nomination deadline is June 30, 2026.",
                'date' => '05',
                'month' => 'JAN',
                'year' => '2026',
                'category' => 'General',
                'image' => '/about/about-img-3.jpg',
                'author' => 'Awards Committee',
                'deadline' => 'June 30, 2026',
                'cta_label' => 'Submit Nomination',
                'cta_link' => '#',
                'is_active' => true,
            ],
        ];

        foreach ($notices as $notice) {
            Notice::create($notice);
        }
    }
}
