<?php

namespace App\Http\Controllers;

use App\Locale;
use Illuminate\Http\Request;
use App\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class OrderServiceController extends Controller
{

    function index(Request $request)
    {
        if ($request->ajax()) {
            $serviceOrders = DB::table("order_services")
                ->leftJoin("locales", "order_services.locale_id", "=", "locales.id")
                ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->select(
                    "order_services.id",
                    "order_services.problem",
                    "statuses.name as status",
                    "order_services.problem_type",
                    DB::raw("(SELECT name FROM users WHERE `order_services`.`designated_employee` = `users`.`id`) AS `designated`"),
                    DB::raw("(SELECT name FROM users WHERE `order_services`.`solver_employee` = `users`.`id`) AS `solver`"),
                    "workstations.name as workstation",
                    "locales.name as locale"
                )
                ->get();


            return DataTables::of($serviceOrders)->addColumn('action', function ($data) {

                $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                if (Gate::allows('rolesUser', 'employee_view')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary"  data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-eye"></i>Visualizar</button>';
                }
                if (Gate::allows('rolesUser', 'employee_edit')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-edit"></i>Editar</button>';
                }
                if (Gate::allows('rolesUser', 'employee_disable')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Desabilitar</button>';
                }

                $result .= '</div>';
                return $result;
            })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view("dashboard/order-service/list-service-orders");
        }
    }

    function create()
    {
        $locales = Locale::all()->where("deleted_at", "=", null);
        return view("dashboard/order-service/create-service-orders", ["locales" => $locales]);
    }

    public function store(Request $request)
    {
        //
        /*  $serviceOrders = DB::table("order_services")
        ->leftJoin("locales", "order_services.locale_id", "=", "locales.id")
        ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
        ->select("order_services.*", "workstations.name as workstation", "locales.name as locale")
        ->get();*/
    }

    public function update(Request $request, OrderService $order)
    {
        //
    }

    function show()
    {
        $os = DB::table('order_services')->select(
            'id',
            'problem_type',
            'problem',
            'realized_date',
            'solution_problem',
            'designated_employee'
        )->get();
        return Datatables::of($os)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">
                       <button type="button" id="' . $data->id . '" class="btn btn-secondary"><i class="fas fa-fw fa-edit"></i>Editar</button>
                       <button type="button" id="' . $data->id . '" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i>Excluir</button>
                       </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    function disable($order)
    {
    }
}
