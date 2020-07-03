<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

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

        //echo $data;

        $user = User::create($data);
        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($data)));
    }

    function show()
    {
        $users = DB::table('users')->select('name', 'email')->get();
        return response()->json(array("data" => $users));
    }
}
