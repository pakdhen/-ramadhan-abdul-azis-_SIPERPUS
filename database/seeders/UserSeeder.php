<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user dengan role pustakawan
        $userPustakawan = User::create([
            'name' => 'pustakawan A',
            'email' => 'pustakawan@gmail.com',
            'password' => Hash::make('pustakawan')
        ]);
        $userPustakawan->assignRole('pustakawan');

        // Membuat user dengan role member
        $userMahasiswa = User::create([
            'name' => 'mahasiswa B',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('mahasiswa')
        ]);
        $userMahasiswa->assignRole('member');
        $userMahasiswa->givePermissionTo('lihat_buku');
    }
}
