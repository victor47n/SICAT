<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $roles = DB::table('roles')->select('id', 'name')->get();

        if ($request->ajax()) {
            $items = DB::table('items')
                ->select('items.id', 'items.name', 'items.amount', 'items.availability', 'types.name as type')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->join('status', 'items.status_id', '=', 'status.id')
                ->where('status.name', '!=', 'Desabilitado')
                ->get();

            return Datatables::of($items)
                ->addColumn('action', function ($data) {

                    $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                    if (Gate::allows('rolesUser', 'employee_view')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary"  data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-eye"></i>Visualizar</button>';
                    }
                    if (Gate::allows('rolesUser', 'employee_edit')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="'. $data->id .'""><i class="fas fa-fw fa-edit"></i>Editar</button>';
                    }
                    if (Gate::allows('rolesUser', 'employee_disable')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Desabilitar</button>';
                    }

                    $result .= '</div>';
                    return $result;
                })
//                ->editColumn('availability', function($items) {
//                    if ($items->availability == 'true')
//                    {
//                        $result = '<span class="badge badge-pill badge-success">Sim</span>';
//                        return $result;
//                    }
//                    if ($items->availability == 'false')
//                    {
//                        $result = '<span class="badge badge-pill badge-danger">Não</span>';
//                        return $result;
//                    }
//                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.item.list-items', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        $types = DB::table('types')->select('id', 'name')->get();
        $status = DB::table('status')->select('id', 'name')
            ->where('name', '=', 'Habilitado')
            ->orWhere('name', '=', 'Desabilitado')
            ->get();

        return view('dashboard.item.create-items', ['types' => $types, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only('name', 'amount', 'type_id', 'status_id');
            if ($data['amount'] == 0)
            {
                $data['availability'] = 'false';
            }

            Item::create($data);

            return response()->json(["message" => "Cadastrado com sucesso"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        try {
            $items = DB::table('items')
                ->select('items.name', 'items.amount', 'items.availability', 'types.name')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->join('status', 'items.status_id', '=', 'status.id')
                ->where('status.name', '!=', 'Desabilitado')
                ->get();

            return $items;
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
