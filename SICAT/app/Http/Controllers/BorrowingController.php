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

//        $items = DB::table('items')->select('id', 'name')->where('status_id', '!=', $disable->id)->get();
        $status = DB::table('status')->select('id', 'name')
            ->where('name', '=', 'Emprestado')
            ->orWhere('name', '=', 'Atrasado')
            ->orWhere('name', '=', 'Finalizado')
            ->get();

        return view('dashboard.borrowing.create-borrowing', ['types' => $types, 'status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Borrowing  $borrowing
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
            $disable = DB::table('status')->select('id')->where('name', '=', 'Desabilitado')->first();
            $items = DB::table('items')->select('id', 'name')
                ->join('types', 'items.type_id', '=', 'types.id')
            ->where('status_id', '!=', $disable->id)->get()
            ->where('types.id', '=', $data);

            return $items;

        } catch (\Exception $e) {

        }
    }
}
