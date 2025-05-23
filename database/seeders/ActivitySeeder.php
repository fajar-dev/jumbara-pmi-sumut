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
            ],
            [
                'id' => 2,
                'name' => 'Talkshow Edukatif 1: Pendidikan Kesehatan Reproduksi Seksual',
                'description' => '
                    <ul>
                        <li>Menghadirkan narasumber yang akan membahas tentang Kesehatan Reproduksi Seksual.</li>
                        <li>Menghadirkan public figur yang akan memberikan pengalaman di dunia keartisan.</li>
                        <li>Peserta: 1 Mula, 2 Madya, 3 Wira, 1 Fasilitator dan 1 Pembina.</li>
                        <li>Narasumber: Rudgers, Pembina PMR Langkat</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-18 13:30:00',
                'end' => '2025-06-18 15:30:00',
            ],
            [
                'id' => 3,
                'name' => 'Talkshow Edukatif 2: Pendidikan Gizi Remaja',
                'description' => '
                    <ul>
                        <li>Menghadirkan narasumber yang akan membahas tentang Gizi.</li>
                        <li>Menghadirkan public figur yang akan memberikan pengalaman di dunia Gizi.</li>
                        <li>Peserta: 1 Mula, 2 Madya, 3 Wira, 1 Fasilitator dan 1 Pembina.</li>
                        <li>Narasumber: PMI, PT. NAF Indonesia, Praktisi Gizi</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-18 13:30:00',
                'end' => '2025-06-18 15:30:00',
            ],
            [
                'id' => 4,
                'name' => 'Diskusi Kelompok Tema I: Tantangan dan Solusi dalam Perubahan Iklim',
                'description' => '
                    <ul>
                        <li>Peserta dibagi dalam kelompok kecil untuk mendiskusikan isu Perubahan Iklim, seperti:</li>
                        <li>Kesiapsiagaan bencana di sekolah.</li>
                        <li>Peran PMR dalam mitigasi perubahan iklim.</li>
                        <li>Strategi meningkatkan keterlibatan generasi muda dalam Perubahan Iklim.</li>
                        <li>Peserta: 1 Mula, 2 Madya, 3 Wira, 1 Fasilitator dan 1 Pembina.</li>
                        <li>Narasumber: Amcross, BPBD, PMI</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-19 08:00:00',
                'end' => '2025-06-19 10:00:00',
            ],
            [
                'id' => 5,
                'name' => 'Diskusi Kelompok Tema II: Tantangan dan Solusi Pendidikan Remaja Sebaya',
                'description' => '
                    <ul>
                        <li>Kesiapan PMR dalam menghadapi isu Kesehatan Reproduksi Seksual.</li>
                        <li>Peran PMR dalam menghadapi isu Kesehatan Reproduksi Seksual.</li>
                        <li>Strategi mendorong PMR menjadi Peer Educator.</li>
                        <li>Peserta: 1 Mula, 2 Madya, 3 Wira, 1 Fasilitator dan 1 Pembina.</li>
                        <li>Narasumber: Rudgers, Pembina PMR Langkat</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-19 08:00:00',
                'end' => '2025-06-19 10:00:00',
            ],
            [
                'id' => 6,
                'name' => 'Lomba Cerdas Cermat Kepalangmerahan (LOMBA)',
                'description' => '
                    <ul>
                        <li>Kuis interaktif atau game berbasis aplikasi.</li>
                        <li>Peserta: 1 orang Mula dan/atau 1 orang Madya dan/atau Wira.</li>
                        <li>Lomba berdasarkan tingkatan.</li>
                        <li>Peserta menyediakan: SmartPhone, Paket Data dan Power Bank (tentative).</li>
                    </ul>
                ',
                'activity_type_id' => 1,
                'start' => '2025-06-19 10:00:00',
                'end' => '2025-06-19 12:00:00',
            ],
            [
                'id' => 7,
                'name' => 'Aksi Donor Darah Massal',
                'description' => '
                    <ul>
                        <li>Melibatkan peserta yang sudah memenuhi syarat donor darah.</li>
                        <li>Tujuan: Edukasi tentang manfaat donor darah dan pentingnya stok darah di Masyarakat.</li>
                        <li>Peserta: 5 orang yang memenuhi syarat sebagai pendonor.</li>
                    </ul>
                ',
                'activity_type_id' => 2,
                'start' => '2025-06-17 08:00:00',
                'end' => '2025-06-22 10:00:00',
            ],
            [
                'id' => 8,
                'name' => 'Bakti Sosial ke Panti Asuhan dan Lansia',
                'description' => '
                    <ul>
                        <li>Mengunjungi panti asuhan atau panti jompo untuk melakukan perawatan dan berbagi kebahagiaan.</li>
                        <li>Memberikan bingkisan berupa alat tulis, mainan, sembako dan melakukan permainan bersama.</li>
                        <li>Peserta: 2 Madya dan 2 Wira dan 2 Fasilitator.</li>
                    </ul>
                ',
                'activity_type_id' => 2,
                'start' => '2025-06-21 08:00:00',
                'end' => '2025-06-21 12:00:00',
            ],
            [
                'id' => 9,
                'name' => 'Green Action: Penanaman Pohon & Kampanye Lingkungan',
                'description' => '
                    <ul>
                        <li>Menanam pohon di area yang membutuhkan penghijauan / yang ditentukan oleh panitia.</li>
                        <li>Aksi bersih lingkungan dan edukasi pengelolaan sampah.</li>
                        <li>Peserta: 2 Mula, 2 Madya, 2 Wira, 2 Fasilitator dan 2 Pembina.</li>
                        <li>Kontingen membawa peralatan kebersihan dan penanaman pohon (Sapu, Cangkul, Plastik sampah dll).</li>
                        <li>Tanaman disiapkan oleh Panitia.</li>
                    </ul>
                ',
                'activity_type_id' => 2,
                'start' => '2025-06-20 10:00:00',
                'end' => '2025-06-20 12:00:00',
            ],
            [
                'id' => 10,
                'name' => 'Penyuluhan Remaja Sebaya di Sekolah',
                'description' => '
                    <ul>
                        <li>Peserta PMR memberikan PRS tentang perubahan iklim.</li>
                        <li>Peserta PMR memberikan PRS tentang pendidikan remaja sebaya.</li>
                        <li>Peserta PMR memberikan PRS tentang gizi remaja.</li>
                        <li>Peserta PMR memberikan PRS tentang kesehatan reproduksi.</li>
                        <li>Kegiatan PRS dilaksanakan di sekolah-sekolah yang sudah ditentukan oleh panitia.</li>
                    </ul>
                ',
                'activity_type_id' => 2,
                'start' => '2025-06-21 08:00:00',
                'end' => '2025-06-21 12:00:00',
            ],
            [
                'id' => 11,
                'name' => 'Amazing Race PMR (Lomba)',
                'description' => '
                    <ul>
                        <li>Perlombaan berbasis pos dengan tantangan kepalangmerahan seperti:</li>
                        <li>Estafet tandu darurat.</li>
                        <li>Menolong korban dengan teknik PP.</li>
                        <li>Peserta: 6 Wira dan 6 Madya.</li>
                        <li>Peralatan disediakan panitia.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-20 08:00:00',
                'end' => '2025-06-12 15:30:00',
            ],
            [
                'id' => 12,
                'name' => 'Flashmob PMR (Lomba)',
                'description' => '
                    <ul>
                        <li>Setiap kelompok menciptakan Flashmob dengan koreografi bertema kepalangmerahan.</li>
                        <li>Dilakukan bersama di area yang ditentukan panitia.</li>
                        <li>Jumlah Peserta: Bebas.</li>
                        <li>Kontingen Menyiapkan koreografi, kostum dan peralatan pendukung.</li>
                        <li>Durasi: Maksimal 5 menit.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-18 19:30:00',
                'end' => '2025-06-20 22:00:00',
            ],
            [
                'id' => 13,
                'name' => 'Drama Tematik (Lomba)',
                'description' => '
                    <ul>
                        <li>Setiap kelompok menampilkan drama.</li>
                        <li>Tema: Perubahan Iklim, Pertolongan Pertama, Ayo Siaga Bencana, Gizi Remaja, atau Kesehatan Reproduksi Remaja.</li>
                        <li>Peserta: Disesuaikan Kebutuhan.</li>
                        <li>Kontingen menyiapkan property masing-masing.</li>
                        <li>Durasi: Maksimal 20 menit.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-18 19:30:00',
                'end' => '2025-06-20 22:00:00',
            ],
            [
                'id' => 14,
                'name' => 'Panggung Seni Kemanusiaan',
                'description' => '
                    <ul>
                        <li>Setiap kelompok menampilkan seni musik, tari, sulap, stand-up comedy, musik teaterikal, monolog, dan seni lainnya.</li>
                        <li>Peserta: Disesuaikan Kebutuhan.</li>
                        <li>Kontingen menyiapkan property masing-masing.</li>
                        <li>Durasi: Maksimal 10 menit.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-18 19:30:00',
                'end' => '2025-06-20 22:00:00',
            ],
            [
                'id' => 15,
                'name' => 'Games and Fun Sport PMR',
                'description' => '
                    <ul>
                        <li>Permainan outdoor yang melibatkan kerja sama tim.</li>
                        <li>Peserta: Anggota PMR, Pembina, Fasilitator, Pimpinan Kontingen.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-18 15:30:00',
                'end' => '2025-06-21 17:30:00',
            ],
            [
                'id' => 16,
                'name' => 'Parade Budaya',
                'description' => '
                    <ul>
                        <li>Kegiatan berbentuk parade di Upacara Pembukaan Jumbara PMR PMI V Provinsi Sumatera Utara.</li>
                        <li>Peserta: Anggota PMR, Pembina, Fasilitator, Pimpinan Kontingen.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-17 08:00:00',
                'end' => '2025-06-22 10:00:00',
            ],
            [
                'id' => 17,
                'name' => 'Parade Budaya Gapura dan Pameran Mini',
                'description' => '
                    <ul>
                        <li>Setiap kontingen merancang Gapura dengan menonjolkan unsur kedaerahan dan edukatif.</li>
                        <li>Peserta: Anggota PMR, Pembina, Fasilitator, Pimpinan Kontingen.</li>
                    </ul>
                ',
                'activity_type_id' => 3,
                'start' => '2025-06-17 08:00:00',
                'end' => '2025-06-22 10:00:00',
            ],
        ];
        DB::table('activities')->insert($activity);

        $activityParticipation = [
            [
                'id' => 1, 
                'activity_id' => 1,
                'participant_type_id' => 2,
                'member_type_id' => null,
                'max_participant' => 1
            ],
            [
                'id' => 2, 
                'activity_id' => 1,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 3, 
                'activity_id' => 1,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
            [
                'id' => 4, 
                'activity_id' => 1,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 1
            ],
            [
                'id' => 5, 
                'activity_id' => 1,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 1
            ],
            [
                'id' => 6, 
                'activity_id' => 2,
                'member_type_id' => null,
                'participant_type_id' => 2,
                'max_participant' => 1
            ],
            [
                'id' => 7, 
                'activity_id' => 2,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 8, 
                'activity_id' => 2,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
            [
                'id' => 9, 
                'activity_id' => 2,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 1
            ],
            [
                'id' => 10, 
                'activity_id' => 2,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 1
            ],
            [
                'id' => 11, 
                'activity_id' => 3,
                'member_type_id' => null,
                'participant_type_id' => 2,
                'max_participant' => 1
            ],
            [
                'id' => 12, 
                'activity_id' => 3,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 13, 
                'activity_id' => 3,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
            [
                'id' => 14, 
                'activity_id' => 3,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 1
            ],
            [
                'id' => 15, 
                'activity_id' => 3,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 1
            ],
            [
                'id' => 16, 
                'activity_id' => 4,
                'member_type_id' => null,
                'participant_type_id' => 2,
                'max_participant' => 1
            ],
            [
                'id' => 17, 
                'activity_id' => 4,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 18, 
                'activity_id' => 4,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
            [
                'id' => 19, 
                'activity_id' => 4,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 1
            ],
            [
                'id' => 20, 
                'activity_id' => 4,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 1
            ],
            [
                'id' => 21, 
                'activity_id' => 5,
                'member_type_id' => null,
                'participant_type_id' => 2,
                'max_participant' => 1
            ],
            [
                'id' => 22, 
                'activity_id' => 5,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 23, 
                'activity_id' => 5,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 3
            ],
            [
                'id' => 24, 
                'activity_id' => 5,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 1
            ],
            [
                'id' => 25, 
                'activity_id' => 5,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 1
            ],
            [
                'id' => 26, 
                'activity_id' => 6,
                'member_type_id' => 1,
                'participant_type_id' => null,
                'max_participant' => 1
            ],
            [
                'id' => 27, 
                'activity_id' => 7,
                'member_type_id' => null,
                'participant_type_id' => null,
                'max_participant' => 5
            ],
            [
                'id' => 28, 
                'activity_id' => 8,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 29, 
                'activity_id' => 8,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 2
            ],
            [
                'id' => 30, 
                'activity_id' => 8,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 2
            ],
            [
                'id' => 31, 
                'activity_id' => 9,
                'member_type_id' => null,
                'participant_type_id' => 2,
                'max_participant' => 2
            ],
            [
                'id' => 32, 
                'activity_id' => 9,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 2
            ],
            [
                'id' => 33, 
                'activity_id' => 9,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 2
            ],
            [
                'id' => 34, 
                'activity_id' => 9,
                'member_type_id' => null,
                'participant_type_id' => 5,
                'max_participant' => 2
            ],
            [
                'id' => 35, 
                'activity_id' => 9,
                'member_type_id' => null,
                'participant_type_id' => 7,
                'max_participant' => 2
            ],
            [
                'id' => 36, 
                'activity_id' => 11,
                'member_type_id' => null,
                'participant_type_id' => 3,
                'max_participant' => 6
            ],
            [
                'id' => 37, 
                'activity_id' => 11,
                'member_type_id' => null,
                'participant_type_id' => 4,
                'max_participant' => 6
            ],
        ];
        DB::table('acticity_participations')->insert($activityParticipation);
    }
}
