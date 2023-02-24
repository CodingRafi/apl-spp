<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',
            'import_users',
            'export_users',

            'view_roles',
            'add_roles',
            'edit_roles',

            'view_tahun_ajaran',
            'add_tahun_ajaran',
            'edit_tahun_ajaran',
            'delete_tahun_ajaran',

            'view_sekolah',
            'add_sekolah',
            'edit_sekolah',
            'delete_sekolah',

            'view_kelas',
            'add_kelas',
            'edit_kelas',
            'delete_kelas',

            'view_kompetensi',
            'add_kompetensi',
            'edit_kompetensi',
            'delete_kompetensi',

            'view_agama',
            'add_agama',
            'edit_agama',
            'delete_agama',

            'upgrade_kelas',

            'view_spp',
            'add_spp',
            'edit_spp',
            'delete_spp',
            
            'view_pembayaran',
            'add_pembayaran',
            'delete_pembayaran',
            'export_pembayaran',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
