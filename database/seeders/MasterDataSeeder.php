<?php

namespace Database\Seeders;

use App\Models\ParticipantType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $participant = [
            [
                'id' => 1, 
                'name' => 'peserta',
                'description' => 'Peserta',
            ],
            [
                'id' => 2, 
                'name' => 'Peninjau',
                'description' => 'Peninjau',
            ],
            [
                'id' => 3, 
                'name' => 'Pendamping',
                'description' => 'Pendamping',
            ],
            [
                'id' => 3, 
                'name' => 'Panitia Lokal',
                'description' => 'Panitia Lokal',
            ]
        ];
        DB::table('participant_types')->insert($participant);

        $member = [
            [
                'id' => 1, 
                'name' => 'PMR',
                'description' => 'Palang Merah Remaja',
            ],
            [
                'id' => 2, 
                'name' => 'KSR',
                'description' => 'Korps',
            ],
            [
                'id' => 3, 
                'name' => 'TSR',
                'description' => 'Tenaga Sukarela',
            ],
            [
                'id' => 4, 
                'name' => 'Pengurus',
                'description' => 'Pengurus',
            ],
            [
                'id' => 5, 
                'name' => 'Staff',
                'description' => 'Staff',
            ]
        ];
        DB::table('member_types')->insert($member);

        $activity = [
            [
                'id' => 1, 
                'name' => 'Jumpa',
                'description' => 'Kegiatan Jumpa',
            ],
            [
                'id' => 2, 
                'name' => 'Bakti',
                'description' => 'Kegiatan Bakti',
            ],
            [
                'id' => 3, 
                'name' => 'Gembira',
                'description' => 'Kegiatan Gembira',
            ],
        ];
        DB::table('activity_types')->insert($activity);
    }
}
