<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookshelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // query builder
        DB::table("bookshelves")->insert ({
            [
                'code' => 'RAKOA' ,
                'name' => 'manga',
            ],
            [
                'code' => 'RAKI1B',
                'name' => 'novel',
                
            ]

        });

    }
}
