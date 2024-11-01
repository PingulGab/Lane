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
            'name' => 'Legal Counsel',
            'contact_person' => 'aff1',
            'email' => 'janjanpingul@gmail.com',
            'username' => 'aff1',
            'password' => Hash::make('aff1'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Data Protection Officer',
            'contact_person' => 'aff2',
            'email' => 'aff2@gmail.com',
            'username' => 'aff2',
            'password' => Hash::make('aff2'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Registrar',
            'contact_person' => 'aff3',
            'email' => 'aff3@gmail.com',
            'username' => 'aff3',
            'password' => Hash::make('aff3'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Administration',
            'contact_person' => 'aff4',
            'email' => 'jankth17@gmail.com',
            'username' => 'aff4',
            'password' => Hash::make('aff4'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Academic Affairs',
            'contact_person' => 'aff5',
            'email' => 'janjanpingulstorage@gmail.com',
            'username' => 'aff5',
            'password' => Hash::make('aff5'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Finance',
            'contact_person' => 'aff6',
            'email' => 'aff6@gmail.com',
            'username' => 'aff6',
            'password' => Hash::make('aff6'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Research & Innovation',
            'contact_person' => 'aff7',
            'email' => 'aff7@gmail.com',
            'username' => 'aff7',
            'password' => Hash::make('aff7'),
            'must_change_password' => false
        ]);

        InstitutionalUnit::create([
            'name' => 'College, Mother 1',
            'contact_person' => 'qwer',
            'email' => 'college@example.com',
            'username' => 'qwer',
            'password' => Hash::make('qwer'),
            'must_change_password' => false,
            'mother_affiliate_id' => 4
        ]);

        InstitutionalUnit::create([
            'name' => 'College, Mother 2',
            'contact_person' => 'qwert',
            'email' => 'college1@example.com',
            'username' => 'qwert',
            'password' => Hash::make('qwert'),
            'must_change_password' => false,
            'mother_affiliate_id' => 5
        ]);

        Link::create([
            'name' => 'TestLink',
            'link' => 'abc',
            'password' => Hash::make('abc'),
            'isActive' => true
        ]);
    }
}
