<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Coordinator;
use App\Models\Crew;
use App\Models\Secretariat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Secretariat::create([
            'id' => 1,
            'category' => 'MARKAS',
            'type' => 'KOTA',
            'name' => 'MARKAS KOTA LHOKSEUMAWE',
            'address' => 'Jl. Ramli Ridwan, Desa Mongeudong, Kecamatan Banda Sakti Kota Lhokseumawe',
            'email' => 'pmilhokseumawe@gmail.com',
            'phone' => '082273455717',
            'administrative_area_level_1' => '11',
            'administrative_area_level_2' => '11.73',
        ]);

        User::create([
            'id' => '1',
            'member_id' => '127113100321002',
            'name' => 'Fajar Rivaldi Chan',
            'email' => 'fajar.200170188@mhs.unimal.ac.id',
            'gender_id' => 1,
            'religion_id' => 1,
            'blood_type_id' => 5,
            'phone_number' => '0895611024559',
            'birth_place' => 'Medan',
            'birth_date' => '2002-05-06',
            'password' => Hash::make('password'),
            'secretariat_id' => 1,
            'member_type_id' => 2,
        ]);

        Admin::create([
            'user_id' => 1,
        ]);

        Crew::create([
            'user_id' => 1,
        ]);

        Coordinator::created([
            'user_id' => 1,
            'contingent_id' => 26
        ]);
    }
}
