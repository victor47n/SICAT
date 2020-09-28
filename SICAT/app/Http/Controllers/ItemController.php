<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $types = DB::table('types')->select('id', 'name')->get();

        if ($request->ajax()) {
            $items = DB::table('items')
                ->select('items.id', 'items.name', 'items.amount', 'items.availability', 'types.name as type')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->whereNull('items.deleted_at')
                ->get();

            return Datatables::of($items)
                ->addColumn('action', function ($data) {

                    $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                    if (Gate::allows('rolesUser', 'item_edit')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="'. $data->id .'""><i class="fas fa-fw fa-edit"></i>Editar</button>';
                    }
                    if (Gate::allows('rolesUser', 'item_disable')) {
                        $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Desabilitar</button>';
                    }

                    $result .= '</div>';
                    return $result;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.item.list-items', ['types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        $types = DB::table('types')->select('id', 'name')->get();

        return view('dashboard.item.create-items', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreItemRequest $request)
    {
        try {
            $data = $request->only('name', 'amount', 'type_id');
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
    public function show($item)
    {
        try {
            $items = DB::table('items')
                ->select('items.name', 'items.amount', 'items.availability', 'types.name as type')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->where('items.id', '=', $item)
                ->whereNull('items.deleted_at')
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required',
                'amount' => 'required',
                'availability' => 'required',
            ]);

            $data = $request->only(['name', 'amount', 'availability', 'type_id']);

            DB::transaction(function () use ($data, $item) {
                $_item = Item::find($item);
                $_item->update($data);
            });

            return response()->json(["message" => "Atualizado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
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

    public function disable($item)
    {
        try {
            Item::destroy($item);
            return response()->json(["message" => "Item desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
