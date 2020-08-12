<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrador',
                'description' => 'Função que contém todas as permissões'
            ],
            [
                'name' => 'Funcionário',
                'description' => 'Função que contém quase todas as permissões, exceto as de criar, editar e desabilitar funcionários'
            ],
            [
                'name' => 'Estagiário',
                'description' => 'Função que contém apenas funções de visualização'
            ],
        ];

        foreach ($roles as $role)
        {
            Role::create($role);
        }
    }
}
