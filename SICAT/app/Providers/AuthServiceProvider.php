<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('rolesUser', function ($user, ...$args) {
            $permissoes = DB::table('permissions');
            if (is_array($args)) {
                $permissoes->select(['permissions.id', 'permissions.key', 'role_permissions.role_id', 'role_permissions.permission_id', 'user_roles.*'])
                    ->leftJoin('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                    ->leftJoin('user_roles', 'role_permissions.role_id', '=', 'user_roles.role_id')
                    ->where('user_id', '=', $user->id)
                    ->whereIn('key', $args);
            } else {
                $permissoes->select(['permissions.id', 'permissions.key', 'role_permissions.role_id', 'role_permissions.permission_id', 'user_roles.*'])
                    ->leftJoin('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                    ->leftJoin('user_roles', 'role_permissions.role_id', '=', 'user_roles.role_id')
                    ->where('user_id', '=', $user->id)
                    ->where('key', '=', $args);
            }

            $permissoes = $permissoes->get();

            return count($permissoes) > 0;
        });

        Gate::define('rolesCategory', function ($user, $args) {

            $permissoes = DB::table('permissions')
                ->select(['permissions.id', 'permissions.key', 'role_permissions.role_id', 'role_permissions.permission_id', 'user_roles.*'])
                ->leftJoin('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                ->leftJoin('user_roles', 'role_permissions.role_id', '=', 'user_roles.role_id')
                ->where('user_id', '=', $user->id)
                ->where('key', 'LIKE', $args . '%')
                ->get();


            return count($permissoes) > 0;
        });
    }
}
