<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Chat Pass',
                'slug' => 'chat',
                'photo_limit' => 0,
                'video_limit' => 0,
                'features' => [
                    'Unlimited Direct Chatting',
                    'Access to Online Status',
                ],
                'pricing' => ['1' => 100, '3' => 250, '7' => 600, '15' => 1000, '30' => 1500],
            ],
            [
                'name' => 'Regular',
                'slug' => 'regular',
                'photo_limit' => 4,
                'video_limit' => 0,
                'features' => [
                    'Upload up to 4 Photos',
                    'Direct Chatting: No',
                    'Show Phone Number: Yes',
                    'Top of List: No',
                ],
                'pricing' => ['3' => 450, '7' => 700, '15' => 1300, '30' => 2000],
            ],
            [
                'name' => 'Prime',
                'slug' => 'prime',
                'photo_limit' => 6,
                'video_limit' => 2,
                'features' => [
                    'Upload up to 6 Photos',
                    'Upload up to 2 Videos',
                    'Direct Chatting: No',
                    'Show Phone Number: Yes',
                    'Top of List: No',
                ],
                'pricing' => ['3' => 500, '7' => 950, '15' => 1800, '30' => 3000],
            ],
            [
                'name' => 'Prime VIP',
                'slug' => 'prime-vip',
                'photo_limit' => 8,
                'video_limit' => 4,
                'features' => [
                    'Upload up to 8 Photos',
                    'Upload up to 4 Videos',
                    'Direct Chatting: Yes',
                    'Show Phone Number: Yes',
                    'Top of List: Yes',
                ],
                'pricing' => ['3' => 600, '7' => 1250, '15' => 2400, '30' => 4000],
            ],
            [
                'name' => 'VIP',
                'slug' => 'vip',
                'photo_limit' => 10,
                'video_limit' => 6,
                'features' => [
                    'Upload up to 10 Photos',
                    'Upload up to 6 Videos',
                    'Direct Chatting: Yes',
                    'Show Phone Number: Yes',
                    'Top of List: Yes',
                ],
                'pricing' => ['3' => 950, '7' => 1450, '15' => 2800, '30' => 5000],
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\MembershipPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
