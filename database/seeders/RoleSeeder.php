<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pustakawan
        role::create([
            'name' => 'pustakawan'
        ]);
        Permission::created([
            'name' => "kelola_buku"
    ]);
        //member
        role::create([
            'name' => 'member'
        ]);
        Permission::create([

            'name' => 'lihat_buku'
        ]);
    }
}
