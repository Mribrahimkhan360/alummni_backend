<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JobProfile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Achivement;
use App\Models\Connect;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'student_id' => 'ADMIN001',
                'passing_year' => 2020,
                'department' => 'Administration',
                'gender' => 'male',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('Super Admin');

        $student = User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student',
                'student_id' => 'STU001',
                'passing_year' => 2024,
                'department' => 'Computer Science',
                'gender' => 'male',
                'password' => Hash::make('password'),
            ]
        );
        $student->assignRole('Student');

        $alumniList = [
            [
                'name' => 'Sarah Rahman',
                'email' => 'sarah@example.com',
                'student_id' => 'ALU001',
                'passing_year' => 2010,
                'department' => 'Computer Engineering',
                'gender' => 'female',
                'bio' => 'Sarah is a visionary engineering leader with over 14 years of experience building scalable systems. She leads a team of 200+ engineers at Solara Inc., driving innovation in cloud infrastructure and developer tools. A passionate advocate for women in tech, she mentors young professionals and speaks at global conferences.',
                'job_title' => 'VP of Engineering',
                'company_name' => 'Solara Inc.',
                'education' => [
                    ['degree' => 'M.Sc. in Computer Science', 'institution' => 'Stanford University', 'start_year' => 2010, 'end_year' => 2012],
                    ['degree' => 'B.Sc. in Computer Engineering', 'institution' => 'ZHSUST', 'start_year' => 2006, 'end_year' => 2010],
                ],
                'experience' => [
                    ['job_title' => 'VP of Engineering', 'company' => 'Solara Inc.', 'start_year' => 2018, 'end_year' => null, 'currently_working' => true, 'description' => 'Leading engineering org across 12 teams. Grew headcount from 40 to 200+. Delivered cloud platform used by 5M+ users.'],
                    ['job_title' => 'Senior Engineering Manager', 'company' => 'DataBridge Co.', 'start_year' => 2015, 'end_year' => 2018, 'currently_working' => false, 'description' => 'Managed distributed systems team. Reduced infrastructure costs by 40% while improving uptime to 99.99%.'],
                    ['job_title' => 'Software Engineer', 'company' => 'TechStart Inc.', 'start_year' => 2012, 'end_year' => 2015, 'currently_working' => false, 'description' => 'Built core backend services handling 1M+ daily requests. Promoted twice for technical leadership.'],
                ],
                'achievements' => [
                    'Forbes 40 Under 40 – Tech (2024)',
                    'Women in Engineering Leadership Award (2023)',
                    'Published 6 peer-reviewed papers on distributed systems',
                    'Patent holder for real-time data pipeline optimization',
                ],
                'connect' => [
                    'email' => 'sarah.rahman@example.com',
                    'phone' => '+1-555-0101',
                    'instagram' => 'sarahrahman',
                    'facebook' => 'sarah.rahman',
                ],
            ],
            [
                'name' => 'Marcus Chen',
                'email' => 'marcus@example.com',
                'student_id' => 'ALU002',
                'passing_year' => 2012,
                'department' => 'Architecture',
                'gender' => 'male',
                'bio' => 'Marcus is an award-winning architect who blends sustainable design with cutting-edge technology. He has led landmark projects across three continents and believes architecture should inspire communities, not just house them.',
                'job_title' => 'Lead Architect',
                'company_name' => 'DesignWorks Studio',
                'education' => [
                    ['degree' => 'M.Arch in Sustainable Design', 'institution' => 'MIT', 'start_year' => 2012, 'end_year' => 2014],
                    ['degree' => 'B.Arch', 'institution' => 'ZHSUST', 'start_year' => 2008, 'end_year' => 2012],
                ],
                'experience' => [
                    ['job_title' => 'Lead Architect', 'company' => 'DesignWorks Studio', 'start_year' => 2019, 'end_year' => null, 'currently_working' => true, 'description' => 'Leading design for $500M+ portfolio of commercial and residential projects. Studio grew to 80 architects.'],
                    ['job_title' => 'Senior Architect', 'company' => 'GreenBuild Partners', 'start_year' => 2016, 'end_year' => 2019, 'currently_working' => false, 'description' => 'Designed 3 LEED Platinum-certified buildings. Pioneered use of smart materials in high-rises.'],
                    ['job_title' => 'Junior Architect', 'company' => 'Urban Form Inc.', 'start_year' => 2014, 'end_year' => 2016, 'currently_working' => false, 'description' => 'Contributed to award-winning mixed-use development in downtown Boston.'],
                ],
                'achievements' => [
                    'AIANY Design Award – Best Commercial Project (2023)',
                    'LEED Fellow – US Green Building Council',
                    'TEDx Speaker – Designing for Tomorrow',
                    'Published in Architectural Digest (2022)',
                ],
                'connect' => [
                    'email' => 'marcus.chen@example.com',
                    'phone' => '+1-555-0102',
                    'instagram' => 'marcuschen',
                    'facebook' => 'marcus.chen',
                ],
            ],
            [
                'name' => 'Aisha Kabir',
                'email' => 'aisha@example.com',
                'student_id' => 'ALU003',
                'passing_year' => 2015,
                'department' => 'Computer Science',
                'gender' => 'female',
                'bio' => 'Aisha specializes in natural language processing and machine learning. She leads AI research at TechNova, developing models that power conversational agents used by millions. She is deeply committed to ethical AI and regularly advises startups on responsible ML practices.',
                'job_title' => 'Lead Data Scientist',
                'company_name' => 'TechNova AI',
                'education' => [
                    ['degree' => 'Ph.D. in Machine Learning', 'institution' => 'University of Cambridge', 'start_year' => 2016, 'end_year' => 2019],
                    ['degree' => 'M.Sc. in Data Science', 'institution' => 'Imperial College London', 'start_year' => 2015, 'end_year' => 2016],
                    ['degree' => 'B.Sc. in Computer Science', 'institution' => 'ZHSUST', 'start_year' => 2011, 'end_year' => 2015],
                ],
                'experience' => [
                    ['job_title' => 'Lead Data Scientist', 'company' => 'TechNova AI', 'start_year' => 2021, 'end_year' => null, 'currently_working' => true, 'description' => 'Leading NLP research team. Deployed production LLM serving 10M+ users with sub-200ms latency.'],
                    ['job_title' => 'Data Scientist', 'company' => 'FinML Labs', 'start_year' => 2019, 'end_year' => 2021, 'currently_working' => false, 'description' => 'Built fraud detection models saving $15M annually. Published 3 papers at NeurIPS and ICML.'],
                    ['job_title' => 'Research Intern', 'company' => 'Google AI', 'start_year' => 2018, 'end_year' => 2019, 'currently_working' => false, 'description' => 'Contributed to TensorFlow Extended (TFX) pipeline optimization.'],
                ],
                'achievements' => [
                    'Google Ph.D. Fellowship in Machine Learning (2018)',
                    'Best Paper Award – NeurIPS 2020',
                    'Women in AI – Rising Star Award (2022)',
                    'Mentor – ML for Social Good Initiative',
                ],
                'connect' => [
                    'email' => 'aisha.kabir@example.com',
                    'phone' => '+44-555-0103',
                    'instagram' => 'aishakabir',
                    'facebook' => 'aisha.kabir',
                ],
            ],
            [
                'name' => 'David Okonkwo',
                'email' => 'david@example.com',
                'student_id' => 'ALU004',
                'passing_year' => 2008,
                'department' => 'Finance',
                'gender' => 'male',
                'bio' => 'David founded BridgeAfrica Ventures to connect African startups with global capital and mentorship. Under his leadership, the firm has invested in 40+ startups across 12 African countries, creating thousands of jobs. He is a recognised thought leader in African tech entrepreneurship.',
                'job_title' => 'CEO & Founder',
                'company_name' => 'BridgeAfrica Ventures',
                'education' => [
                    ['degree' => 'MBA, Entrepreneurship', 'institution' => 'Harvard Business School', 'start_year' => 2010, 'end_year' => 2012],
                    ['degree' => 'BBA in Finance', 'institution' => 'ZHSUST', 'start_year' => 2004, 'end_year' => 2008],
                ],
                'experience' => [
                    ['job_title' => 'CEO & Founder', 'company' => 'BridgeAfrica Ventures', 'start_year' => 2014, 'end_year' => null, 'currently_working' => true, 'description' => 'Built VC firm from zero to $200M AUM. Portfolio includes 3 unicorns and 12 Series A+ companies.'],
                    ['job_title' => 'Investment Associate', 'company' => 'Goldman Sachs', 'start_year' => 2012, 'end_year' => 2014, 'currently_working' => false, 'description' => 'Analyzed $2B+ in tech deals across EMEA markets. Promoted ahead of schedule.'],
                    ['job_title' => 'Business Analyst', 'company' => 'PwC Nigeria', 'start_year' => 2008, 'end_year' => 2010, 'currently_working' => false, 'description' => 'Led digital transformation consulting for top-tier financial clients.'],
                ],
                'achievements' => [
                    'Forbes Africa 30 Under 30 – Finance (2016)',
                    'African Business Icon Award (2024)',
                    'Young Global Leader – World Economic Forum',
                    'Board Member – African Venture Capital Association',
                ],
                'connect' => [
                    'email' => 'david.okonkwo@example.com',
                    'phone' => '+234-555-0104',
                    'instagram' => 'davidokonkwo',
                    'facebook' => 'david.okonkwo',
                ],
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'student_id' => 'ALU005',
                'passing_year' => 2018,
                'department' => 'Information Technology',
                'gender' => 'female',
                'bio' => 'Priya drives product strategy for Google Workspace, impacting over 3 billion users. She is known for her user-centric approach and ability to ship complex products at global scale. Outside work, she runs a mentorship circle for aspiring PMs from non-traditional backgrounds.',
                'job_title' => 'Product Manager',
                'company_name' => 'Google',
                'education' => [
                    ['degree' => 'MBA in Product Management', 'institution' => 'ISB Hyderabad', 'start_year' => 2018, 'end_year' => 2020],
                    ['degree' => 'B.Tech in Information Technology', 'institution' => 'ZHSUST', 'start_year' => 2014, 'end_year' => 2018],
                ],
                'experience' => [
                    ['job_title' => 'Product Manager', 'company' => 'Google', 'start_year' => 2021, 'end_year' => null, 'currently_working' => true, 'description' => 'Drive roadmap for Google Workspace collaboration features. Shipped 5 major features used by 500M+ users.'],
                    ['job_title' => 'Associate Product Manager', 'company' => 'Microsoft', 'start_year' => 2020, 'end_year' => 2021, 'currently_working' => false, 'description' => 'Launched Teams integration for education sector. Grew MAU by 30% in emerging markets.'],
                ],
                'achievements' => [
                    'Google Platinum Award – Product Excellence (2023)',
                    'ISB Deans List – Top 5% of class',
                    'Speaker – ProductCon 2024',
                    'Founder – Women in Product India (500+ members)',
                ],
                'connect' => [
                    'email' => 'priya.sharma@example.com',
                    'phone' => '+91-555-0105',
                    'instagram' => 'priyasharma',
                    'facebook' => 'priya.sharma',
                ],
            ],
            [
                'name' => 'James O\'Brien',
                'email' => 'james@example.com',
                'student_id' => 'ALU006',
                'passing_year' => 2011,
                'department' => 'Economics',
                'gender' => 'male',
                'bio' => 'James is a tenured professor of economics at MIT Sloan, specialising in behavioural economics and public policy. His research on decision-making frameworks has influenced policy at the Federal Reserve and the World Bank. He is a beloved educator who has taught over 5,000 students.',
                'job_title' => 'Professor',
                'company_name' => 'MIT Sloan',
                'education' => [
                    ['degree' => 'Ph.D. in Economics', 'institution' => 'University of Chicago', 'start_year' => 2011, 'end_year' => 2015],
                    ['degree' => 'M.Sc. in Economics', 'institution' => 'London School of Economics', 'start_year' => 2011, 'end_year' => 2012],
                    ['degree' => 'BBA in Economics', 'institution' => 'ZHSUST', 'start_year' => 2007, 'end_year' => 2011],
                ],
                'experience' => [
                    ['job_title' => 'Professor of Economics', 'company' => 'MIT Sloan', 'start_year' => 2019, 'end_year' => null, 'currently_working' => true, 'description' => 'Tenured faculty. Teach graduate courses in behavioural economics. Published 20+ papers in top journals.'],
                    ['job_title' => 'Associate Professor', 'company' => 'NYU Stern', 'start_year' => 2015, 'end_year' => 2019, 'currently_working' => false, 'description' => 'Received tenure in 3 years. Won teaching excellence award twice.'],
                ],
                'achievements' => [
                    'John Bates Clark Medal Honorable Mention (2022)',
                    'National Science Foundation Grant Recipient',
                    'Published in American Economic Review (x4)',
                    'Advisor – World Bank Policy Lab',
                ],
                'connect' => [
                    'email' => 'james.obrien@example.com',
                    'phone' => '+1-555-0106',
                    'instagram' => 'jamesobrien',
                    'facebook' => 'james.obrien',
                ],
            ],
            [
                'name' => 'Fatima Al-Rashid',
                'email' => 'fatima@example.com',
                'student_id' => 'ALU007',
                'passing_year' => 2017,
                'department' => 'Medicine',
                'gender' => 'female',
                'bio' => 'Dr. Fatima Al-Rashid is a cardiothoracic surgeon at Cleveland Clinic Abu Dhabi, one of the leading heart surgery centres in the Middle East. She has performed over 1,000 successful surgeries and is a pioneer in minimally invasive cardiac procedures.',
                'job_title' => 'Cardiothoracic Surgeon',
                'company_name' => 'Cleveland Clinic Abu Dhabi',
                'education' => [
                    ['degree' => 'M.D. in Medicine', 'institution' => 'Johns Hopkins University', 'start_year' => 2017, 'end_year' => 2021],
                    ['degree' => 'M.B.B.S.', 'institution' => 'ZHSUST Medical College', 'start_year' => 2012, 'end_year' => 2017],
                ],
                'experience' => [
                    ['job_title' => 'Cardiothoracic Surgeon', 'company' => 'Cleveland Clinic Abu Dhabi', 'start_year' => 2024, 'end_year' => null, 'currently_working' => true, 'description' => 'Perform complex cardiac surgeries. Lead research on robotic-assisted procedures.'],
                    ['job_title' => 'Surgical Resident', 'company' => 'Mayo Clinic', 'start_year' => 2021, 'end_year' => 2024, 'currently_working' => false, 'description' => 'Completed rigorous cardiothoracic residency. Authored 8 research papers.'],
                ],
                'achievements' => [
                    'Young Surgeon of the Year – UAE Medical Association (2024)',
                    'Published in The Lancet – Cardiology (2023)',
                    'First female surgeon in UAE to perform robotic heart bypass',
                    'Board Certified – American Board of Thoracic Surgery',
                ],
                'connect' => [
                    'email' => 'fatima.alrashid@example.com',
                    'phone' => '+971-555-0107',
                    'instagram' => 'fatimaalrashid',
                    'facebook' => 'fatima.alrashid',
                ],
            ],
            [
                'name' => 'Carlos Mendez',
                'email' => 'carlos@example.com',
                'student_id' => 'ALU008',
                'passing_year' => 2014,
                'department' => 'Graphic Design',
                'gender' => 'male',
                'bio' => 'Carlos is an award-winning creative director who has shaped brand identities for Fortune 500 companies and celebrated social impact campaigns. His work blends Latin American cultural heritage with modern digital design, earning recognition from Cannes Lions and D&AD.',
                'job_title' => 'Creative Director',
                'company_name' => 'Pixel & Co.',
                'education' => [
                    ['degree' => 'M.A. in Visual Communication', 'institution' => 'Central Saint Martins, London', 'start_year' => 2014, 'end_year' => 2016],
                    ['degree' => 'B.A. in Graphic Design', 'institution' => 'ZHSUST', 'start_year' => 2010, 'end_year' => 2014],
                ],
                'experience' => [
                    ['job_title' => 'Creative Director', 'company' => 'Pixel & Co.', 'start_year' => 2020, 'end_year' => null, 'currently_working' => true, 'description' => 'Lead creative strategy for 30+ global brands. Studio revenue grew 3x under creative leadership.'],
                    ['job_title' => 'Art Director', 'company' => 'BBDO Mexico', 'start_year' => 2016, 'end_year' => 2020, 'currently_working' => false, 'description' => 'Created award-winning campaigns for Coca-Cola, Nike, and Telcel. Led team of 12 designers.'],
                ],
                'achievements' => [
                    'Cannes Lions – Gold in Brand Experience (2023)',
                    'D&AD Pencil – Graphic Design (2022)',
                    'ADC Young Guns Award (2019)',
                    'Speaker – Design Week Mexico 2024',
                ],
                'connect' => [
                    'email' => 'carlos.mendez@example.com',
                    'phone' => '+52-555-0108',
                    'instagram' => 'carlosmendez',
                    'facebook' => 'carlos.mendez',
                ],
            ],
        ];

        foreach ($alumniList as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'student_id' => $data['student_id'],
                    'passing_year' => $data['passing_year'],
                    'department' => $data['department'],
                    'gender' => $data['gender'],
                    'bio' => $data['bio'],
                    'password' => Hash::make('password'),
                ]
            );
            $user->assignRole('Alumni');

            JobProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'job_title' => $data['job_title'],
                    'company_name' => $data['company_name'],
                ]
            );

            foreach ($data['education'] as $edu) {
                Education::updateOrCreate(
                    ['user_id' => $user->id, 'degree' => $edu['degree'], 'institution' => $edu['institution']],
                    $edu
                );
            }

            foreach ($data['experience'] as $exp) {
                Experience::updateOrCreate(
                    ['user_id' => $user->id, 'job_title' => $exp['job_title'], 'company' => $exp['company']],
                    $exp
                );
            }

            foreach ($data['achievements'] as $title) {
                Achivement::updateOrCreate(
                    ['user_id' => $user->id, 'title' => $title],
                    ['title' => $title]
                );
            }

            Connect::updateOrCreate(
                ['user_id' => $user->id],
                $data['connect']
            );
        }

        $this->command->info('Users created with roles successfully.');
    }
}
