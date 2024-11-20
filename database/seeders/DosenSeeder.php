<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\DosenModel;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        DosenModel::create([
            'dosen_nama' => 'Fahmi Mardiansyah',
            'nidn' => '87654321',
            'username' => 'fahmi',
            'no_telp' => '08123456789',
            'tugas_id' => 1, 
        ]);
    }
}
