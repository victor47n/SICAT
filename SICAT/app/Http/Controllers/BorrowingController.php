<?php

namespace App\Http\Controllers;

use App\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    private $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

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
            $data = $request->all();

//            $data['lender_id'] = Auth::user()->id;

            $items[] = null;

            for ($i = 0; $i < count($data['item_id']); $i++)
            {
                $items[$i]['item_id'] = $data['item_id'][$i];
                $items[$i]['amount'] = $data['amount'][$i];
                $items[$i]['lender_id'] = Auth::user()->id;
                $items[$i]['status_id'] = $data['status_id'];
            }

            DB::transaction(function () use ($data, $items) {
                $borrowing = Borrowing::create($data);
                foreach ($items as $item) {
                    $borrowing->borrowed_item()->create($item);
                }
            });

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
