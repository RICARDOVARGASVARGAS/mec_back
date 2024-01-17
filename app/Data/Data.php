<?php
namespace App\Data;
class Data
{

    public static $permissions = [
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
}