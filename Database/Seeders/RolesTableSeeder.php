<?php

namespace Modules\Pengguna\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->truncate();
        \DB::table('roles')->insert([
            [
                'id' => 1, 
                'uuid' => uuid(), 
                'name' => 'Super Admin', 
                'permissions' => '["Agenda", "Berita", "Core", "Galeri", "Inbox", "Laman", "Pegawai", "Pengguna", "Penghargaan", "Pengumuman", "Plugin", "Slider", "Tautan", "Template", "Tools", "Setting"]'
            ],
            [
                'id' => 2, 
                'uuid' => uuid(), 
                'name' => 'Operator', 
                'permissions' => '["Agenda", "Berita", "Galeri", "Inbox", "Pegawai", "Penghargaan", "Pengumuman", "Slider", "Tautan"]'
            ]
        ]);
    }
}
