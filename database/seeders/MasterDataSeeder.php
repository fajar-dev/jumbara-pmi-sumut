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
                'name' => 'Pimpinan Kontingen',
                'description' => 'Pimpinan Kontingen',
            ],
            [
                'id' => 2, 
                'name' => 'peserta',
                'description' => 'Peserta',
            ],
            [
                'id' => 3, 
                'name' => 'Peninjau',
                'description' => 'Peninjau',
            ],
            [
                'id' => 4, 
                'name' => 'Pendamping',
                'description' => 'Pendamping',
            ],
            [
                'id' => 5, 
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

        $religion = [
            [
                'id' => 1, 
                'name' => 'Islam',
                'description' => 'Agama Islam',
            ],
            [
                'id' => 2, 
                'name' => 'Kristen',
                'description' => 'Agama Kristen',
            ],
            [
                'id' => 3, 
                'name' => 'Katolik',
                'description' => 'Agama Katolik',
            ],
            [
                'id' => 4, 
                'name' => 'Hindu',
                'description' => 'Agama Hindu',
            ],
            [
                'id' => 5, 
                'name' => 'Buddha',
                'description' => 'Agama Buddha',
            ],
            [
                'id' => 6, 
                'name' => 'Konghuchu',
                'description' => 'Agama Konghuchu',
            ],
            [
                'id' => 7, 
                'name' => 'Lainnya',
                'description' => 'Agama Lainnya',
            ]
        ];
        DB::table('religions')->insert($religion);

        $gender = [
            [
                'id' => 1, 
                'name' => 'Laki-laki',
                'description' => 'Laki-laki',
            ],
            [
                'id' => 2, 
                'name' => 'Perempuan',
                'description' => 'Perempuan',
            ],
        ];
        DB::table('genders')->insert($gender);

        $bloodType = [
            [
                'id' => 1, 
                'name' => 'A+',
                'description' => 'Golongan Darah A+',
            ],
            [
                'id' => 2, 
                'name' => 'A-',
                'description' => 'Golongan Darah A-',
            ],
            [
                'id' => 3, 
                'name' => 'B+',
                'description' => 'Golongan Darah B+',
            ],
            [
                'id' => 4, 
                'name' => 'B-',
                'description' => 'Golongan Darah B-',
            ],
            [
                'id' => 5, 
                'name' => 'O+',
                'description' => 'Golongan Darah O+',
            ],
            [
                'id' => 6, 
                'name' => 'O-',
                'description' => 'Golongan Darah O-',
            ],
            [
                'id' => 7, 
                'name' => 'AB+',
                'description' => 'Golongan Darah AB+',
            ],
            [
                'id' => 8, 
                'name' => 'AB-',
                'description' => 'Golongan Darah AB-',
            ],
            [
                'id' => 9, 
                'name' => 'A',
                'description' => 'Golongan Darah A',
            ],
            [
                'id' => 10, 
                'name' => 'B',
                'description' => 'Golongan Darah B',
            ],
            [
                'id' => 11, 
                'name' => 'O',
                'description' => 'Golongan Darah O',
            ],
            [
                'id' => 12, 
                'name' => 'AB',
                'description' => 'Golongan Darah AB',
            ],
            [
                'id' => 13, 
                'name' => '-',
                'description' => 'Tidak Diketahui',
            ]
        ];
        DB::table('blood_types')->insert($bloodType);
    }
}
