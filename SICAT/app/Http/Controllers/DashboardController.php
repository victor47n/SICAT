<?php

namespace App\Http\Controllers;

use App\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() === true) {

            $os = DB::table("order_services")->orderBy("realized_date", "desc")->get();
            $osPendentes = OrderService::where("realized_date", "<", "NOW()")->where("status_id", "4")->count();
            $osAtrasados = OrderService::where("realized_date", ">", "NOW()")->where("status_id", "4")->count();
            $osFinalizados = OrderService::where("realized_date", "<", new \DateTime(strtotime("last day of week")))
                ->where("realized_date", ">", new \DateTime(strtotime("first day of week")))
                ->where("status_id", "3")->count();
            $osTotal = $osPendentes + $osFinalizados + $osAtrasados;

            return view('dashboard.dashboard', [
                "osPendentes" => $osPendentes,
                "osAtrasados" => $osAtrasados,
                "osFinalizados" => $osFinalizados,
                "osTotal" => $osTotal,
                "os" => $os
            ]);
        }

        return redirect()->route('login');
    }
}
