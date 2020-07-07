<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
