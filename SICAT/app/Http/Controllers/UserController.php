<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    function index()
    {
        Auth::loginUsingId(1);

        // echo "<pre>";
        // var_dump(Route::getCurrentRoute()->action['as']);
        // echo "</pre>";
        return view('dashboard/employee/list-users');
    }

    function create()
    {
        return view('dashboard/employee/create-users');
    }

    function add(Request $req)
    {
        $data = $req->all();

        $user = User::create($data);
        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($data)));
    }

    function list()
    {
        $users = DB::table('users')->select('id', 'name', 'email')->get();

        return Datatables::of($users)
            ->addColumn('action', function ($data) {

                $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                if (Gate::allows('rolesUser', 'user_edit')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" onclick="showEditModal(' . $data->id . ')"><i class="fas fa-fw fa-edit"></i>Editar</button>';
                }
                if (Gate::allows('rolesUser', 'user_delete')) {
                    $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Excluir</button>';
                }
                $result .= '</div>';
                return $result;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    function show($id)
    {
        $data = User::find($id);

        return $data;
    }

    function update(Request $req, $id)
    {
        try {

            $validatedData = $req->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $data = $req->all();
            $user = $this->user->find($id);
            $user->update($data);

            return response()->json(["message" => "Atualizado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function disable($id)
    {
        try {
            User::find($id)->delete();
            return response()->json(["message" => "Funcionário desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
