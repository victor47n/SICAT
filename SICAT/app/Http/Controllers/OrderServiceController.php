<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderServiceRequest;
use App\Locale;
use Illuminate\Http\Request;
use App\OrderService;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class OrderServiceController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    function index(Request $request)
    {
        if ($request->ajax()) {
            $serviceOrders = DB::table("order_services")
                ->leftJoin("locales", "order_services.locale_id", "=", "locales.id")
                ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->select(
                    "order_services.*",
                    "statuses.name as status",
                    DB::raw("(SELECT name FROM users WHERE `order_services`.`designated_employee` = `users`.`id`) AS `designated`"),
                    DB::raw("(SELECT name FROM users WHERE `order_services`.`solver_employee` = `users`.`id`) AS `solver`"),
                    "workstations.name as workstation",
                    "locales.name as locale"
                );

            if ($request->get('dc_inicio') != null) {
                $serviceOrders->where('order_services.created_at', '>=', $request->get('dc_inicio'));
            }

            if ($request->get('dc_fim') != null) {
                $serviceOrders->where('order_services.created_at', '<=', $request->get('dc_fim'));
            }

            if ($request->get('ds_inicio') != null) {
                $serviceOrders->where('order_services.realized_date', '>=', $request->get('ds_inicio'));
            }

            if ($request->get('ds_fim') != null) {
                $serviceOrders->where('order_services.realized_date', '<=', $request->get('ds_fim'));
            }

            $serviceOrders = $serviceOrders->get();

            return DataTables::of($serviceOrders)
                ->addColumn('action', function ($data) {

                $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                if (Gate::allows('rolesUser', 'order_service_view')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary"  data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '"><i class="fas fa-fw fa-eye"></i>Visualizar</button>';
                }
                if (Gate::allows('rolesUser', 'order_service_edit') && $data->deleted_at == null && $data->status != 'Finalizado') {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="' . $data->id . '"><i class="fas fa-fw fa-edit"></i>Editar</button>';
                }
                if (Gate::allows('rolesUser', 'order_service_disable') && $data->deleted_at == null && $data->status != 'Finalizado') {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Cancelar</button>';
                }

                    $result .= '</div>';
                    return $result;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $employee = User::all()->where("deleted_at", "=", null);
            $statuses = DB::table('statuses')->select('id', 'name')
                ->where('name', '=', 'Pendente')
                ->orWhere('name', '=', 'Finalizado')
                ->get();

            return view("dashboard/order-service/list-service-orders", ['employee' => $employee, 'statuses' => $statuses]);
        }
    }

    function create()
    {
        $locales = Locale::all()->where("deleted_at", "=", null);
        $employee = User::all()->where("deleted_at", "=", null);
        $status = DB::table('statuses')->select('id', 'name')
            ->where('name', '=', 'Pendente')
            ->first();

        return view(
            "dashboard/order-service/create-service-orders", ["locales" => $locales, "employee" => $employee, 'status' => $status]);
    }

    public function store(StoreOrderServiceRequest $request)
    {
        try {
            $data = $request->only('problem', 'problem_type', 'locale_id', 'workstation_id', 'realized_date', 'designated_employee', 'status_id');
            $os = OrderService::create($data);

            return response()->json(["message" => "Ordem de serviço criada com sucesso"], 201);

        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $orderService)
    {

        try {
            $data = $request->only(['realized_date', 'designated_employee', 'solver_employee', 'status_id', 'solution_problem']);

            $orderService = OrderService::find($orderService);
            $orderService->update($data);

            return response()->json(['message' => 'Ordem de serviço atualizada com sucesso']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    function show($id)
    {

        $serviceOrders = DB::table("order_services")
            ->leftJoin("locales", "order_services.locale_id", "=", "locales.id")
            ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
            ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
            ->where("order_services.id", "=", $id)
            ->select(
                "order_services.*",
                "statuses.name as status",
                DB::raw("(SELECT name FROM users WHERE `order_services`.`designated_employee` = `users`.`id`) AS `designated`"),
                DB::raw("(SELECT name FROM users WHERE `order_services`.`solver_employee` = `users`.`id`) AS `solver`"),
                "workstations.name as workstation",
                "locales.name as locale"
            )
            ->get();

        return $serviceOrders;
    }

    function destroy($id)
    {
        try {
            $os = OrderService::find($id);
            $os->delete();
            return response()->json(['data' => $os, 'message' => 'Ordem de serviço atualizada com sucesso']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
