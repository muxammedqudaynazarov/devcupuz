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
            'admin.home',
            'user.home',
            'admin.tournaments.view',
            'admin.tournaments.create',
            'admin.tournaments.edit',
            'admin.tournaments.week.view',
            'admin.tournaments.week.create',
            'admin.tournaments.week.edit',
            'admin.tournaments.week.delete',
            'admin.tournaments.application.view',
            'admin.tournaments.application.accept',
            'admin.tournaments.application.cancel',
            'admin.tournaments.users.ban',
            'admin.tournaments.users.unban',
            'admin.tournaments.programs.view',
            'admin.tournaments.programs.edit',
            'admin.tournaments.university.view',
            'admin.tournaments.university.edit',
            'admin.problems.view',
            'admin.problems.create',
            'admin.problems.edit',
            'admin.problems.delete',
            'admin.users.view',
            'admin.users.edit',
            'admin.prizes.view',
            'admin.prizes.create',
            'admin.prizes.edit',
            'admin.prizes.delete',
            'admin.medals.view',
            'admin.medals.create',
            'admin.medals.edit',
            'admin.medals.delete',
            'admin.programs.view',
            'admin.programs.edit',
            'admin.ratings.view',
            'admin.submissions.view',
            'admin.settings.view',
            'admin.settings.edit',
            'user.tournaments.view',
            'user.tournaments.show',
            'user.tournaments.application.create',
            'user.problems.view',
            'user.problems.show',
            'user.submissions.view',
            'user.ratings.view',
            'user.settings.view',
            'user.settings.edit',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $desc = [
            'super_admin' => 'Super admin',
            'admin' => 'Administrator',
            'organizer' => 'Tashkilotchi',
            'user' => 'Ishtirokchi',
        ];

        $roles = [
            'super_admin' => [
                'admin.home',
                'admin.tournaments.view',
                'admin.tournaments.create',
                'admin.tournaments.edit',
                'admin.tournaments.week.view',
                'admin.tournaments.week.create',
                'admin.tournaments.week.edit',
                'admin.tournaments.week.delete',
                'admin.tournaments.application.view',
                'admin.tournaments.application.accept',
                'admin.tournaments.application.cancel',
                'admin.tournaments.users.ban',
                'admin.tournaments.users.unban',
                'admin.tournaments.programs.view',
                'admin.tournaments.programs.edit',
                'admin.tournaments.university.view',
                'admin.tournaments.university.edit',
                'admin.problems.view',
                'admin.problems.create',
                'admin.problems.edit',
                'admin.problems.delete',
                'admin.users.view',
                'admin.users.edit',
                'admin.prizes.view',
                'admin.prizes.create',
                'admin.prizes.edit',
                'admin.prizes.delete',
                'admin.medals.view',
                'admin.medals.create',
                'admin.medals.edit',
                'admin.medals.delete',
                'admin.programs.view',
                'admin.programs.edit',
                'admin.ratings.view',
                'admin.submissions.view',
                'admin.settings.view',
                'admin.settings.edit',
            ],
            'admin' => [
                'admin.home',
                'admin.tournaments.view',
                'admin.tournaments.create',
                'admin.tournaments.edit',
                'admin.tournaments.week.view',
                'admin.tournaments.week.create',
                'admin.tournaments.week.edit',
                'admin.tournaments.week.delete',
                'admin.tournaments.application.view',
                'admin.tournaments.application.accept',
                'admin.tournaments.application.cancel',
                'admin.tournaments.users.ban',
                'admin.tournaments.users.unban',
                'admin.tournaments.programs.view',
                'admin.tournaments.programs.edit',
                'admin.tournaments.university.view',
                'admin.tournaments.university.edit',
                'admin.problems.view',
                'admin.problems.create',
                'admin.problems.edit',
                'admin.problems.delete',
                'admin.users.view',
                'admin.users.edit',
                'admin.programs.view',
                'admin.ratings.view',
                'admin.submissions.view',
                'admin.settings.view',
                'admin.settings.edit',
            ],
            'organizer' => [
                'admin.home',
                'admin.tournaments.view',
                'admin.tournaments.create',
                'admin.tournaments.edit',
                'admin.tournaments.week.view',
                'admin.tournaments.week.create',
                'admin.tournaments.week.edit',
                'admin.tournaments.week.delete',
                'admin.tournaments.application.view',
                'admin.tournaments.application.accept',
                'admin.tournaments.application.cancel',
                'admin.tournaments.users.ban',
                'admin.tournaments.users.unban',
                'admin.tournaments.programs.view',
                'admin.tournaments.programs.edit',
                'admin.tournaments.university.view',
                'admin.tournaments.university.edit',
                'admin.problems.view',
                'admin.problems.create',
                'admin.problems.edit',
                'admin.problems.delete',
                'admin.ratings.view',
                'admin.submissions.view',
            ],
            'user' => [
                'user.home',
                'user.tournaments.view',
                'user.tournaments.show',
                'user.tournaments.application.create',
                'user.problems.view',
                'user.problems.show',
                'user.submissions.view',
                'user.ratings.view',
                'user.settings.view',
                'user.settings.edit',
            ],
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
