<?php

use App\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = [
            ['user_id' => 1, 'role_id' => 1],
        ];

        foreach ($user_roles as $user_role)
        {
            UserRole::create($user_role);
        }
    }
}
