<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    function index()
    {
        return view('dashboard/users');
    }

    function create()
    {
        return view('dashboard/users_create');
    }

    function add(Request $req)
    {
        $data = $req->all();

        $user = User::create($data);
        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($data)));
    }

    function show()
    {
        $users = DB::table('users')->select('id', 'name', 'email')->get();
        return Datatables::of($users)
            ->addColumn('action', function($data){
                return '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">
                       <button type="button" id="'.$data->id.'" class="btn btn-secondary"><i class="fas fa-fw fa-edit"></i>Editar</button>
                       <button type="button" id="'.$data->id.'" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i>Excluir</button>
                       </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
