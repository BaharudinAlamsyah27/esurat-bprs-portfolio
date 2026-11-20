<?php

namespace Database\Seeders;

use App\Enums\UserLevel;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Data Instansi Demo (kosong/contoh, tanpa data surat agar pengunjung bisa mencoba dari nol)
        Institution::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'PT BPRS Sragen (Demo)',
                'address' => 'Jl. Raya Sukowati No. 123, Sragen',
                'phone' => '(0271) 891-000',
                'email' => 'sekretariat@demo-esurat.test',
                'city' => 'Sragen',
                'leader_name' => 'Direktur Utama (Demo)',
                'leader_position' => 'Direktur Utama',
            ],
        );

        // 3 Akun Demo untuk tombol 1-Klik Login
        User::query()->updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Superadmin Demo',
                'position_title' => 'IT & Pengelola Sistem',
                'email' => 'superadmin@demo-esurat.test',
                'level' => UserLevel::SuperAdmin,
                'is_active' => true,
                'push_enabled' => false,
                'password' => 'DemoEsurat123',
            ],
        );

        User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin Persuratan Demo',
                'position_title' => 'Sekretariat',
                'email' => 'admin@demo-esurat.test',
                'level' => UserLevel::Admin,
                'is_active' => true,
                'push_enabled' => false,
                'password' => 'DemoEsurat123',
            ],
        );

        User::query()->updateOrCreate(
            ['username' => 'pegawai'],
            [
                'name' => 'Pegawai Demo',
                'position_title' => 'Staf Operasional',
                'email' => 'pegawai@demo-esurat.test',
                'level' => UserLevel::User,
                'is_active' => true,
                'push_enabled' => false,
                'password' => 'DemoEsurat123',
            ],
        );
    }
}
