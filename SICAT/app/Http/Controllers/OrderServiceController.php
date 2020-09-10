<?php

namespace App\Http\Controllers;

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
                )
                ->get();

            foreach ($serviceOrders as $order) {
                $order->realized_date = \Carbon\Carbon::parse($order->realized_date)->format('d/m/Y');
                $order->created_at = \Carbon\Carbon::parse($order->created_at)->format('d/m/Y');
            }

            return DataTables::of($serviceOrders)->addColumn('action', function ($data) {

                $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                if (Gate::allows('rolesUser', 'employee_view')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary"  data-toggle="modal" data-target="#modalView" onclick="visualizarOS(' . $data->id . ')"><i class="fas fa-fw fa-eye"></i>Visualizar</button>';
                }
                if (Gate::allows('rolesUser', 'employee_edit') && $data->deleted_at == null && $data->status != 'Finalizado') {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" onclick="editarOS(' . $data->id . ')"><i class="fas fa-fw fa-edit"></i>Editar</button>';
                }
                if (Gate::allows('rolesUser', 'employee_disable') && $data->deleted_at == null && $data->status != 'Finalizado') {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Cancelar</button>';
                }

                $result .= '</div>';
                return $result;
            })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $funcionarios = User::all()->where("deleted_at", "=", null);
            return view("dashboard/order-service/list-service-orders", ['funcionarios' => $funcionarios]);
        }
    }

    function create()
    {
        $locales = Locale::all()->where("deleted_at", "=", null);
        $funcionarios = User::all()->where("deleted_at", "=", null);
        return view(
            "dashboard/order-service/create-service-orders",
            [
                "locales" => $locales,
                "funcionarios" => $funcionarios
            ]
        );
    }

    public function store(Request $request)
    {
        try {
            $req = $request->all();

            $os = OrderService::create($req);
            return response()->json(["message" => "Ordem de serviço criada com sucesso", "data" => $os]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {

        try {
            $data = $request->only(['id', 'designated_employee', 'solver_employee', 'status_id', 'solution_problem']);

            $os = DB::table('order_services')
                ->where('id', $data['id'])
                ->update($data);

            $result = OrderService::find($data['id']);

            return response()->json(['data' => $result, 'message' => 'Ordem de serviço atualizada com sucesso']);
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
