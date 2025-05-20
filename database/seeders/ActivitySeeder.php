<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activity = [
            [
                'id' => 1, 
                'name' => 'Talkshow Inspiratif: Kisah Relawan Kemanusiaan',
                'description' => '
                    <ul>
                        <li>Menghadirkan relawan PMI senior atau penyintas bencana untuk berbagi pengalaman.</li>
                        <li>Tema: "Peran Relawan di Situasi Darurat" atau "Menjadi Agen Perubahan di Komunitas."</li>
                        <li>Peserta: 1 Mula, 2 Madya, 3 Wira, 1 Fasilitator dan 1 Pembina.</li>
                        <li>Narasumber: Relawan Senior, Penyintas Bencana.</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-19 10:00:00',
                'end' => '2025-06-19 12:00:00'
            ]
        ];
        DB::table('activities')->insert($activity);

        $activityParticipation = [
            [
                'id' => 1, 
                'activity_id' => 1,
                'participant_type_id' => 2,
                'max_participant' => 1
            ],
            [
                'id' => 2, 
                'activity_id' => 1,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 3, 
                'activity_id' => 1,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
        ];
        DB::table('acticity_participations')->insert($activityParticipation);
    }
}
