<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                ['empresa', 'company'],
                [
                    ['editar', 'edit'],
                ],
            ],
            [
                ['usuarios', 'user'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy'],
                    ['permisos', 'permission'],
                    ['perfil', 'profile'],
                    ['restablecer contraseña', 'resetPassword'],
                ],
            ],
            [
                ['productos', 'product'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['servicios', 'service'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['cajas', 'box'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['marcas', 'brand'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['modelos', 'example'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['años', 'year'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['colores', 'color'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['clientes', 'client'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['vehículos', 'car'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
            [
                ['ventas', 'sale'],
                [
                    ['listar', 'index'],
                    ['registrar', 'create'],
                    ['editar', 'edit'],
                    ['eliminar', 'destroy']
                ],
            ],
        ];

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

                foreach ($users as $user) {
                    $user->permissions()->attach($permission->id);
                }
            }
        }
    }
}
