<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrdemServicoController extends Controller
{
    function Index(Request $request)
    {
        return view("dashboard/listar_ordens");
    }

    function Create(Request $request)
    {
        return view("dashboard/listar_ordens");
    }


    function show()
    {
        $os = DB::table('ordens_servico')->select('id', 'description', 'place', 'scheduled', 'status')->get();
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
}
