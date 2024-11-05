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
            'name' => 'OGR Director',
            'username' => 'admin',
            'email' => 'lane.ogr.auf@gmail.com', // You can choose an appropriate email
            'password' => Hash::make('admin'), // Hash the password
            'contact_number' => '1234567890', // You can customize the contact number
            'role' => 'Superadmin',
            'isActive' => true,
        ]);

        Affiliate::create([
            'name' => 'Legal Counsel',
            'contact_person' => 'aff1',
            'email' => 'dummypingul@gmail.com',
            'username' => 'legal',
            'password' => Hash::make('legal'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Data Protection Officer',
            'contact_person' => 'dataprotection',
            'email' => 'janjanjanpingul@gmail.com',
            'username' => 'dpo1',
            'password' => Hash::make('dpo1'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Registrar',
            'contact_person' => 'aff3',
            'email' => 'aff3@example.com',
            'username' => 'aff3',
            'password' => Hash::make('aff3'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Administration',
            'contact_person' => 'aff4',
            'email' => 'aff4@example.com',
            'username' => 'aff4',
            'password' => Hash::make('aff4'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Academic Affairs',
            'contact_person' => 'aff5',
            'email' => 'sia.sanguyo.niel@gmail.com',
            'username' => 'ovpaa',
            'password' => Hash::make('ovpaa'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Finance',
            'contact_person' => 'aff6',
            'email' => 'aff6@example.com',
            'username' => 'aff6',
            'password' => Hash::make('aff6'),
            'must_change_password' => false
        ]);

        Affiliate::create([
            'name' => 'Office of the Vice President for Research & Innovation',
            'contact_person' => 'aff7',
            'email' => 'janjanpingulstorage@gmail.com',
            'username' => 'ovpri',
            'password' => Hash::make('ovpri'),
            'must_change_password' => false
        ]);

        InstitutionalUnit::create([
            'name' => 'CED',
            'contact_person' => 'qwer',
            'email' => 'janjanpingul@gmail.com',
            'username' => 'ced1',
            'password' => Hash::make('ced1'),
            'must_change_password' => false,
            'mother_affiliate_id' => 5
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
