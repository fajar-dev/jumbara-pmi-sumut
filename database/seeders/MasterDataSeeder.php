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
                'id' => 2, 
                'name' => 'PMR Mula',
                'description' => 'berusia 10-12 tahun atau kelas 4-6 SD sederajat',
                'max_participant' => 10,
                'class' => 'badge badge-primary'
            ],
            [
                'id' => 3, 
                'name' => 'PMR Madya',
                'description' => 'berusia 12 – 15 tahun atau SLTP sederajat',
                'max_participant' => 20,
                'class' => 'badge badge-success'
            ],
            [
                'id' => 4, 
                'name' => 'PMR Wira',
                'description' => 'berusia 15 – 17 tahun atau SMU sederajat',
                'max_participant' => 30,
                'class' => 'badge badge-warning'
            ],
            [
                'id' => 5, 
                'name' => 'Pembina pendamping',
                'description' => 'Pembina dari masing-masing tingkatan unit PMR, yang terdiri dari 3 pembina pendamping putra dan 3 pembina pendamping putri',
                'max_participant' => 6,
                'class' => 'badge badge-dark'
            ],
            [
                'id' => 7, 
                'name' => 'Fasilitator PMR',
                'description' => 'Fasilitator PMR yang aktif memfasilitasi kegiatan unit PMR Atau Pelatih Bidang yang aktif memfasilitasi kegiatan unit PMR di sekolah. ',
                'max_participant' => 3,
                'class' => 'badge badge-danger'
            ],
            [
                'id' => 8, 
                'name' => 'Peninjau',
                'description' => 'Pengurus PMI Propinsi maupun Pengurus PMI kab/kota, Kepala Sekolah dan Guru ',
                'max_participant' => 100,
                'class' => 'badge badge-secondary'
            ],
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
                'description' => 'Korps Sukarela',
            ],
            [
                'id' => 3, 
                'name' => 'TSR',
                'description' => 'Tenaga Sukarela',
            ],
            [
                'id' => 4, 
                'name' => 'Pengurus',
                'description' => 'Pengurus PMI',
            ],
            [
                'id' => 5, 
                'name' => 'Staff',
                'description' => 'Staff PMI',
            ],
            [
                'id' => 6, 
                'name' => 'Pembina',
                'description' => 'Pembina PMR',
            ]
        ];
        DB::table('member_types')->insert($member);

        $activity = [
            [
                'id' => 1, 
                'name' => 'Jumpa',
                'description' => 'Kegiatan yang menekankan pada pertemuan, diskusi, dan berbagi pengalaman antar anggota PMR dari berbagai daerah ',
            ],
            [
                'id' => 2, 
                'name' => 'Bakti',
                'description' => 'Kegiatan yang menumbuhkan rasa kepedulian dan aksi nyata untuk masyarakat',
            ],
            [
                'id' => 3, 
                'name' => 'Gembira',
                'description' => 'Kegiatan yang menciptakan suasana menyenangkan, mempererat kebersamaan, dan meningkatkan kreativitas peserta',
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

        $participation = [
            [
                'member_type_id' => 1,
                'participant_type_id' => 2,
            ],
            [
                'member_type_id' => 1,
                'participant_type_id' => 3,
            ],
            [
                'member_type_id' => 1,
                'participant_type_id' => 4,
            ],
            [
                'member_type_id' => 1,
                'participant_type_id' => 8,
            ],
            [
                'member_type_id' => 2,
                'participant_type_id' => 5,
            ],
            [
                'member_type_id' => 2,
                'participant_type_id' => 7,
            ],
            [
                'member_type_id' => 2,
                'participant_type_id' => 8,
            ],
            [
                'member_type_id' => 3,
                'participant_type_id' => 5,
            ],
            [
                'member_type_id' => 3,
                'participant_type_id' => 7,
            ],
            [
                'member_type_id' => 3,
                'participant_type_id' => 8,
            ],
            [
                'member_type_id' => 4,
                'participant_type_id' => 5,
            ],
            [
                'member_type_id' => 4,
                'participant_type_id' => 7,
            ],
            [
                'member_type_id' => 4,
                'participant_type_id' => 8,
            ],
            [
                'member_type_id' => 5,
                'participant_type_id' => 5,
            ],
            [
                'member_type_id' => 5,
                'participant_type_id' => 7,
            ],
            [
                'member_type_id' => 5,
                'participant_type_id' => 8,
            ],
            [
                'member_type_id' => 6,
                'participant_type_id' => 5,
            ],
            [
                'member_type_id' => 6,
                'participant_type_id' => 8,
            ],
        ];
        DB::table('member_participations')->insert($participation);
    }
}
