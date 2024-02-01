<?php

namespace Database\Seeders;

use App\Data\Data;
use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $data = Data::$permissions;

        $users = User::all();
        foreach ($data as $value) {
            $module = Module::create([
                'name' => $value[0][1],
                'show' => $value[0][0],
            ]);

            foreach ($value[1] as $permission) {
                $permission =  Permission::create([
                    'module_id' => $module->id,
                    'name' => $module->name . '.' . $permission[1],
                    'show' => $permission[0] . ' ' . $module->show,
                ]);

                // foreach ($users as $user) {
                //     $user->permissions()->attach($permission->id);
                // }
            }
        }
    }
}
