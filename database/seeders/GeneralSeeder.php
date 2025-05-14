<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $general = [
            [
                'id' => 1, 
                'name' => 'JUMBARA PMR-PMI Provinsi SUMUT',
                'location' => 'Kabupaten Langkat',
                'event_start' => '2025-06-17',
                'event_end' => '2025-06-22',
                'last_registration' => '2025-06-17 00:00:00',
                'email' => 'sumatra_utara@pmi.or.id',
                'phone' => '061 - 5430 198',
                'address' => 'Jl. Perintis Kemerdekaan No.37 Kec. Medan Tim., Kota Medan, Sumatera Utara',
                'instagram' => '#',
                'facebook' => '#',
                'youtube' => '#',
                'tiktok' => '#',
                'website' => 'https://pmisumut.or.id'
            ]
        ];
        DB::table('generals')->insert($general);
    }
}
