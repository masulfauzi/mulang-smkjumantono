<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Role\Models\Role;
use App\Modules\Users\Models\Users;
use App\Modules\UserRole\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'id_user' => Users::where('email', 'superadmin@mail.com')->first()->id,
            'id_role' => Role::where('role', 'Super Admin')->first()->id
        ]);
        UserRole::create([
            'id_user' => Users::where('email', 'superadmin@mail.com')->first()->id,
            'id_role' => Role::where('role', 'Admin')->first()->id
        ]);
    }
}
