<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\InstitutionalUnit;
use App\Models\Link;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com', // You can choose an appropriate email
            'password' => Hash::make('admin'), // Hash the password
            'contact_number' => '1234567890', // You can customize the contact number
            'role' => 'Superadmin',
            'isActive' => true,
        ]);

        Affiliate::create([
            'name' => 'Mother',
            'contact_person' => 'aff0',
            'email' => 'dummypingul@gmail.com',
            'username' => 'aff0',
            'password' => Hash::make('aff0'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Mother2',
            'contact_person' => 'moth',
            'email' => 'dummypingul2@gmail.com',
            'username' => 'moth',
            'password' => Hash::make('moth'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'OVP1',
            'contact_person' => 'aff1',
            'email' => 'janjanpingul@gmail.com',
            'username' => 'aff1',
            'password' => Hash::make('aff1'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Vice President of Finance',
            'contact_person' => 'aff2',
            'email' => 'jankth17@gmail.com',
            'username' => 'aff2',
            'password' => Hash::make('aff2'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Vice President of Research',
            'contact_person' => 'aff3',
            'email' => 'janjanpingulstorage@gmail.com',
            'username' => 'aff3',
            'password' => Hash::make('aff3'),
            'must_change_password' => false
        ]);

        InstitutionalUnit::create([
            'name' => 'College, Mother 1',
            'contact_person' => 'qwer',
            'email' => 'college@example.com',
            'username' => 'qwer',
            'password' => Hash::make('qwer'),
            'must_change_password' => false,
            'mother_affiliate_id' => 1
        ]);

        InstitutionalUnit::create([
            'name' => 'College, Mother 2',
            'contact_person' => 'qwert',
            'email' => 'college1@example.com',
            'username' => 'qwert',
            'password' => Hash::make('qwert'),
            'must_change_password' => false,
            'mother_affiliate_id' => 2
        ]);

        Link::create([
            'name' => 'TestLink',
            'link' => 'abc',
            'password' => Hash::make('abc'),
            'isActive' => true
        ]);
    }
}
