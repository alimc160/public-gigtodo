<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->updateOrInsert(
            ['name'=>'admin'],
            [
                'id'=>1,
                'name'=>'admin',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        );
        DB::table('roles')->updateOrInsert(
            ['name'=>'buyer'],
            [
                'id'=>2,
                'name'=>'buyer',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        );
        DB::table('roles')->updateOrInsert(
            ['name'=>'seller'],
            [
                'id'=>3,
                'name'=>'seller',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]
        );
    }
}
