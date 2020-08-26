<?php

namespace App\Http\Controllers;

use App\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = DB::table('types')->select('id', 'name')->get();

        $status = DB::table('statuses')->select('id', 'name')
            ->where('name', '=', 'Emprestado')
            ->orWhere('name', '=', 'Atrasado')
            ->orWhere('name', '=', 'Devolvido')
            ->get();

        return view('dashboard.borrowing.create-borrowing', ['types' => $types, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only('requester', 'phone_requester', 'email_requester', 'office_requester', 'amount[]', 'acquisition_date',
                'item_id[]', 'status_id');
            foreach ($data['amount'] as $amount)
            {
                if ($amount == 0)
                {
                    return response()->json(["message" => "Quantidade inválida de itens"], 400);
                }
            }

            $borrowing = null;
//            $items = $request->only('item_id[]', 'amount[]');

            $items = $data['item_id'] + $data['amount'];
            dd($items);

//            DB::transaction(function () use ($data, $borrowing) {
//                $borrowing = Borrowing::create($data);
//                foreach ($data['item_id'] as $item) {
//                    $borrowing->borrowed_item()->create(["item_id" => $item]);
//                }
//            });

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
     * @param \App\Borrowing $borrowing
     * @return \Illuminate\Http\Response
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Borrowing $borrowing
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Borrowing $borrowing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Borrowing $borrowing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }

    public function select(Request $request)
    {
        try {
            $data = $request->only('id');
            $items = DB::table('items')->select('items.id', 'items.name')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->where('types.id', '=', $data)
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
}
