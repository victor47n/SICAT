<?php

namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
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

    function index(Request $request)
    {
        $roles = DB::table('roles')->select('id', 'name')->get();

//        $users = DB::table('users')
//            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.office', 'roles.name as permission')
//            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
//            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
//            ->join('status', 'users.status_id', '=', 'status.id')
//            ->where('status.name', '!=', 'Desabilitado')
//            ->dd();

        if ($request->ajax()) {
            $users = DB::table('users')
                ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.office', 'roles.name as permission')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->join('status', 'users.status_id', '=', 'status.id')
                ->where('status.name', '!=', 'Desabilitado')
                ->get();

            return Datatables::of($users)
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.employee.list-users', ['roles' => $roles]);
    }

    function create()
    {
        $roles = DB::table('roles')->select('id', 'name')->get();

        return view('dashboard.employee.create-users', ['roles' => $roles]);
    }

    function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);

            DB::transaction(function () use ($data) {
                $user = User::create($data);
                $user->user_roles()->create($data);
            });

            return response()->json(["message" => "Cadastrado com sucesso"], 201);

        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function show($user)
    {
        $users = DB::table('users')
            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.office', 'roles.name as permission')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->join('status', 'users.status_id', '=', 'status.id')
            ->where('status.name', '!=', 'Desabilitado')
            ->where('users.id', '=', $user)
            ->get();

        return $users;
    }

    function update(Request $request, $user)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $data = $request->except(['_token', '_method']);
            $user_role = $request->only('role_id');
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            DB::transaction(function () use ($user, $data, $user_role) {
                $user = User::find($user);
                $user->update($data);
                $user->user_roles()->update($user_role);
            });

            return response()->json(["message" => "Atualizado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function disable($user)
    {
        try {
            User::find($user)->update(['status' => 'disable']);
            return response()->json(["message" => "Funcionário desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
