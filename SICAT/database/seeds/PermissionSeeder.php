<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            /* 1 */['key' => 'employee_menu'],
            /* 2 */['key' => 'employee_submenu_create'],
            /* 3 */['key' => 'employee_submenu_list'],
            /* 4 */['key' => 'employee_view'],
            /* 5 */['key' => 'employee_edit'],
            /* 6 */['key' => 'employee_disable'],
            /* 7 */['key' => 'employee_restore'],
            /* 8 */['key' => 'services_category'],
            /* 9 */['key' => 'order_service_menu'],
            /* 10 */['key' => 'order_service_submenu_create'],
            /* 11 */['key' => 'order_service_submenu_list'],
            /* 12 */['key' => 'order_service_view'],
            /* 13 */['key' => 'order_service_edit'],
            /* 14 */['key' => 'order_service_disable'],
            /* 15 */['key' => 'workstation_menu'],
            /* 16 */['key' => 'workstation_submenu_create'],
            /* 17 */['key' => 'workstation_submenu_list'],
            /* 18 */['key' => 'workstation_view'],
            /* 19 */['key' => 'workstation_edit'],
            /* 20 */['key' => 'workstation_disable'],
            /* 21 */['key' => 'borrowing_category'],
            /* 22 */['key' => 'item_menu'],
            /* 23 */['key' => 'item_submenu_create'],
            /* 24 */['key' => 'item_submenu_list'],
            /* 25 */['key' => 'item_view'],
            /* 26 */['key' => 'item_edit'],
            /* 27 */['key' => 'item_disable'],
            /* 28 */['key' => 'borrowing_menu'],
            /* 29 */['key' => 'borrowing_submenu_create'],
            /* 30 */['key' => 'borrowing_submenu_list'],
            /* 31 */['key' => 'borrowing_view'],
            /* 32 */['key' => 'borrowing_edit'],
            /* 33 */['key' => 'borrowing_disable'],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}
