<?php

namespace Modules\Pengguna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OperatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('operator')->truncate();
        // \DB::table('operator')->insert([
        //     [
        //         'uuid' => uuid(), 
        //         'role_id' => 1, 
        //         'avatar' => null, 
        //         'nama' => 'Enterwind', 
        //         'email' => 'ew@btekno.id', 
        //         'password' => bcrypt('adminsss'), 
        //         'plain' => 'adminsss', 
        //         'status' => 1, 
        //         'last_login' => null, 
        //         'last_ip_address' => null
        //     ],
        //     [
        //         'uuid' => uuid(), 
        //         'role_id' => 1, 
        //         'avatar' => null, 
        //         'nama' => 'Administrator', 
        //         'email' => 'admin@btekno.id', 
        //         'password' => bcrypt('adminsss'), 
        //         'plain' => 'adminsss', 
        //         'status' => 1, 
        //         'last_login' => null, 
        //         'last_ip_address' => null
        //     ],
        //     [
        //         'uuid' => uuid(), 
        //         'role_id' => 2, 
        //         'avatar' => null, 
        //         'nama' => 'Operator', 
        //         'email' => 'operator@btekno.id', 
        //         'password' => bcrypt('adminsss'), 
        //         'plain' => 'adminsss', 
        //         'status' => 1, 
        //         'last_login' => null, 
        //         'last_ip_address' => null
        //     ]
        // ]);
    }
}
