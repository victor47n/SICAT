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

            $os = DB::table("order_services")
                ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->select('*', 'workstations.name AS workstation', 'statuses.name AS status')
                ->where('designated_employee', '=', Auth::user()->id)
                ->orderBy("realized_date", "desc")
                ->limit(5)
                ->get();

            $osAtrasados = OrderService::where("realized_date", ">", "NOW()")
                ->where("status_id", "5")
                ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->select('*', 'workstations.name AS workstation', 'statuses.name AS status')
                ->where('designated_employee', '=', Auth::user()->id)
                ->limit(5)
                ->get();


            $quantOSPendentes = OrderService::where("realized_date", "<", "NOW()")->where("status_id", "5")->count();
            $quantOSAtrasados = OrderService::where("realized_date", ">", "NOW()")->where("status_id", "5")->count();
            $quantOSFinalizados = OrderService::where("realized_date", "<", new \DateTime(strtotime("last day of week")))
                ->where("realized_date", ">", new \DateTime(strtotime("first day of week")))
                ->where("status_id", "5")->count();
            $quantOSTotal = $quantOSPendentes + $quantOSFinalizados + $quantOSAtrasados;

            return view('dashboard.dashboard', [
                "quantOSPendentes" => $quantOSPendentes,
                "quantOSAtrasados" => $quantOSAtrasados,
                "quantOSFinalizados" => $quantOSFinalizados,
                "quantOSTotal" => $quantOSTotal,
                "os" => $os,
                "osAtrasadas" => $osAtrasados,
            ]);
        }

        return redirect()->route('login');
    }
}
