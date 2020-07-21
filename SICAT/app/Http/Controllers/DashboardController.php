<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() === true) {
            return view('dashboard.dashboard');
        }

        return redirect()->route('login');
    }

}
