<?php

namespace Database\Seeders;

use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Privilege\Models\Privilege;
use App\Modules\Role\Models\Role;

class PrivilegeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = Menu::where('level', '<>', 0)->get();
        $role_superadmin = Role::where('role', 'Super Admin')->first();
        $role_admin = Role::where('role', 'Admin')->first();
        foreach ($menus as $key => $value) {
            Privilege::create([
                'id_role' => $role_superadmin->id,
                'id_menu' => $value->id,
                'show_menu' => 1,
                'create' => 1,
                'read' => 1,
                'show' => 1,
                'update' => 1,
                'delete' => 1,
            ]);
            Privilege::create([
                'id_role' => $role_admin->id,
                'id_menu' => $value->id,
                'show_menu' => 1,
                'create' => 0,
                'read' => 1,
                'show' => 0,
                'update' => 0,
                'delete' => 0,
            ]);
        }
    }
}
