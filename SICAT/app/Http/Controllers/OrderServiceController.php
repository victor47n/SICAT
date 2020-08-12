<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderServiceController extends Controller
{
    function index()
    {
        return view("dashboard/order-service/list-service-orders");
    }

    function create()
    {
        return view("dashboard/order-service/create-service-orders");
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, OrderService $order)
    {
        //
    }

    function show()
    {
        $os = DB::table('order_services')->select('id', 'problem_type', 'problem', 'realized_date', 'solution_problem',
        'designated_employee')->get();
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
