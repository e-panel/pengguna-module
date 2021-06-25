<?php

namespace Modules\Pengguna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OperatorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Modules\Pengguna\Database\Seeders\RolesTableSeeder::class);s
        // $this->call(OperatorsTableSeeder::class);
    }
}
