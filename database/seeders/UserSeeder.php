<?php

namespace Database\Seeders;

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
        User::create([
            'id' => '1',
            'member_id' => '127113100321002',
            'name' => 'Fajar Rivaldi Chan',
            'email' => 'fajar.200170188@mhs.unimal.ac.id',
            'password' => Hash::make('password'),
            'photo_path' => 'https://mis.pmi.or.id/uploads/pmi/anggota/1271130604020003.jpg',
            'role' => 'admin',
        ]);
    }
}
