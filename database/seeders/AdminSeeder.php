<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\College;
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
            'name' => 'Jan Pingul',
            'contact_person' => 'aff1',
            'email' => 'janjanpingul@gmail.com',
            'username' => 'aff1',
            'password' => Hash::make('aff1'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Jan Kth',
            'contact_person' => 'aff2',
            'email' => 'jankth17@gmail.com',
            'username' => 'aff2',
            'password' => Hash::make('aff2'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Jan Pingul Storage',
            'contact_person' => 'aff3',
            'email' => 'janjanpingulstorage@gmail.com',
            'username' => 'aff3',
            'password' => Hash::make('aff3'),
            'must_change_password' => false
        ]);

        College::create([
            'name' => 'College',
            'contact_person' => 'qwer',
            'email' => 'college@example.com',
            'username' => 'qwer',
            'password' => Hash::make('qwer'),
            'must_change_password' => false
        ]);

        Link::create([
            'name' => 'TestLink',
            'link' => 'abc',
            'password' => Hash::make('abc'),
            'isActive' => true
        ]);
    }
}
