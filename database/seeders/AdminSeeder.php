<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = Role::first()->id;
        DB::table('users')->updateOrInsert(
            ['email'=>'admin@admin.com'],
            [
                'name'=>'admin',
                'email'=>'admin@admin.com',
                'user_name'=>'admin',
                'password'=>Hash::make('123456'),
                'role_id'=>$roleId,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]
        );
    }
}
