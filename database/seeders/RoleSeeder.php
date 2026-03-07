<?php

namespace Database\Seeders;

use App\Models\System\University;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'tournaments.view',
            'tournaments.create',
            'tournaments.edit',
            'tournaments.week.view',
            'tournaments.week.create',
            'tournaments.week.edit',
            'tournaments.week.delete',
            'tournaments.programs.view',
            'tournaments.programs.edit',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $desc = [
            'sv' => 'Super admin',
            'admin' => 'Administrator',
            'student' => 'talaba',
        ];

        $roles = [

        ];

        foreach ($roles as $role => $permissions) {
            $role_n = new Role();
            $role_n->name = $role;
            $role_n->desc = $desc[$role];
            $role_n->save();
            foreach ($permissions as $permission) {
                $role_n->givePermissionTo($permission);
            }
        }
    }
}
