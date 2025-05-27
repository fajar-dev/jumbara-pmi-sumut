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
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.01', 'name' => 'PMI Kabupaten Tapanuli Tengah'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.02', 'name' => 'PMI Kabupaten Tapanuli Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.03', 'name' => 'PMI Kabupaten Tapanuli Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.04', 'name' => 'PMI Kabupaten Nias'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.05', 'name' => 'PMI Kabupaten Langkat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.06', 'name' => 'PMI Kabupaten Karo'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.07', 'name' => 'PMI Kabupaten Deli Serdang'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.08', 'name' => 'PMI Kabupaten Simalungun'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.09', 'name' => 'PMI Kabupaten Asahan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.10', 'name' => 'PMI Kabupaten Labuhanbatu'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.11', 'name' => 'PMI Kabupaten Dairi'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.12', 'name' => 'PMI Kabupaten Toba Samosir'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.13', 'name' => 'PMI Kabupaten Mandailing Natal'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.14', 'name' => 'PMI Kabupaten Nias Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.15', 'name' => 'PMI Kabupaten Pakpak Bharat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.16', 'name' => 'PMI Kabupaten Humbang Hasundutan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.17', 'name' => 'PMI Kabupaten Samosir'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.18', 'name' => 'PMI Kabupaten Serdang Bedagai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.19', 'name' => 'PMI Kabupaten Batu Bara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.20', 'name' => 'PMI Kabupaten Padang Lawas Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.21', 'name' => 'PMI Kabupaten Padang Lawas'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.22', 'name' => 'PMI Kabupaten Labuhanbatu Selatan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.23', 'name' => 'PMI Kabupaten Labuhanbatu Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.24', 'name' => 'PMI Kabupaten Nias Utara'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.25', 'name' => 'PMI Kabupaten Nias Barat'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.71', 'name' => 'PMI Kota Medan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.72', 'name' => 'PMI Kota Pematang Siantar'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.73', 'name' => 'PMI Kota Sibolga'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.74', 'name' => 'PMI Kota Tanjung Balai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.75', 'name' => 'PMI Kota Binjai'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.76', 'name' => 'PMI Kota Tebing Tinggi'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.77', 'name' => 'PMI Kota Padangsidimpuan'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.78', 'name' => 'PMI Kota Gunungsitoli'],
            ['administrative_area_level_1' => 12, 'administrative_area_level_2' => '12.41', 'name' => 'PMI Kabupaten Tarutung'],
            ['administrative_area_level_1' => 11, 'administrative_area_level_2' => '11.73', 'name' => 'PMI Kota Lhokseumawe'],
            ['administrative_area_level_1' => 21, 'administrative_area_level_2' => '21.21', 'name' => 'PMI Kota Batam'],
        ];
        DB::table('contingents')->insert($contingents);
    }
}
