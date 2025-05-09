<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContingentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contingents = [
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.01', 'name' => 'Tapanuli Tengah'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.02', 'name' => 'Tapanuli Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.03', 'name' => 'Tapanuli Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.04', 'name' => 'Nias'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.05', 'name' => 'Langkat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.06', 'name' => 'Karo'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.07', 'name' => 'Deli Serdang'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.08', 'name' => 'Simalungun'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.09', 'name' => 'Asahan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.10', 'name' => 'Labuhanbatu'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.11', 'name' => 'Dairi'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.12', 'name' => 'Toba Samosir'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.13', 'name' => 'Mandailing Natal'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.14', 'name' => 'Nias Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.15', 'name' => 'Pakpak Bharat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.16', 'name' => 'Humbang Hasundutan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.17', 'name' => 'Samosir'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.18', 'name' => 'Serdang Bedagai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.19', 'name' => 'Batu Bara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.20', 'name' => 'Padang Lawas Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.21', 'name' => 'Padang Lawas'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.22', 'name' => 'Labuhanbatu Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.23', 'name' => 'Labuhanbatu Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.24', 'name' => 'Nias Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.25', 'name' => 'Nias Barat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.71', 'name' => 'Kota Medan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.72', 'name' => 'Kota Pematang Siantar'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.73', 'name' => 'Kota Sibolga'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.74', 'name' => 'Kota Tanjung Balai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.75', 'name' => 'Kota Binjai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.76', 'name' => 'Kota Tebing Tinggi'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.77', 'name' => 'Kota Padangsidimpuan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.78', 'name' => 'Kota Gunungsitoli'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.41', 'name' => 'Tarutung'],
            ['administrative_area_level_1' => 11, 'administrative_area_level_2' => '11.73', 'name' => 'Kota Lhokseumawe'],
            ['administrative_area_level_1' => 21, 'administrative_area_level_2' => '21.21', 'name' => 'Kota Batam'],
        ];
        DB::table('contingents')->insert($contingents);
    }
}
