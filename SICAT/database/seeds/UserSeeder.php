<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('senha'),
                'office' => 'Funcionário',
                'status_id' => 1
            ],
            [
                'name' => 'Funcionario',
                'email' => 'funcionario@gmail.com',
                'password' => Hash::make('senha'),
                'office' => 'Funcionário',
                'status_id' => 1
            ],
            [
                'name' => 'Estagiario',
                'email' => 'estagiario@gmail.com',
                'password' => Hash::make('senha'),
                'office' => 'Estagiário',
                'status_id' => 1
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
