<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact',
                'content' => '<p>Contact our support team for assistance.</p>',
                'phone' => '+254700000000',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'terms'],
            [
                'title' => 'Terms of Service',
                'content' => '<p>Please read these Terms of Service carefully before using Baddies Club.</p>',
                'phone' => null,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'privacy'],
            [
                'title' => 'Privacy Policy',
                'content' => '<p>Your privacy is important to us. This Privacy Policy explains how your information is handled.</p>',
                'phone' => null,
            ]
        );
    }
}
