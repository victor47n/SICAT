<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    
    function index(){
        return view('dashboard/users');
    }

    function create(){
        return view ('dashboard/createUser');
    }

    function add(Request $req){
       $data = $req->all();
       
       //echo $data;

       $user = User::create($data);
       return response()->json(array("mensagem"=> "Cadastrado com sucesso", "data"=> json_encode($data)));
    }
}
