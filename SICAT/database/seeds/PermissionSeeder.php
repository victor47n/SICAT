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
            /* 7 */['key' => 'services_category'],
            /* 8 */['key' => 'order_service_menu'],
            /* 9 */['key' => 'order_service_submenu_create'],
            /* 10 */['key' => 'order_service_submenu_list'],
            /* 11 */['key' => 'order_service_view'],
            /* 12 */['key' => 'order_service_edit'],
            /* 13 */['key' => 'order_service_disable'],
            /* 14 */['key' => 'workstation_menu'],
            /* 15 */['key' => 'workstation_submenu_create'],
            /* 16 */['key' => 'workstation_submenu_list'],
            /* 17 */['key' => 'workstation_view'],
            /* 18 */['key' => 'workstation_edit'],
            /* 19 */['key' => 'workstation_disable'],
            /* 20 */['key' => 'borrowing_category'],
            /* 21 */['key' => 'item_menu'],
            /* 22 */['key' => 'item_submenu_create'],
            /* 23 */['key' => 'item_submenu_list'],
            /* 24 */['key' => 'item_view'],
            /* 25 */['key' => 'item_edit'],
            /* 26 */['key' => 'item_disable'],
            /* 27 */['key' => 'borrowing_menu'],
            /* 28 */['key' => 'borrowing_submenu_create'],
            /* 29 */['key' => 'borrowing_submenu_list'],
            /* 30 */['key' => 'borrowing_view'],
            /* 31 */['key' => 'borrowing_edit'],
            /* 32 */['key' => 'borrowing_disable'],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}
