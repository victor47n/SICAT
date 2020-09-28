<?php

namespace App\Http\Controllers;

use App\OrderService;
use Carbon\Carbon;
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
                ->select('order_services.id', 'order_services.problem', 'workstations.name AS workstation', 'statuses.name AS status')
                ->where('designated_employee', '=', Auth::user()->id)
                ->where('statuses.name', '!=', 'Finalizado')
                ->orderBy("realized_date", "desc")
                ->limit(5)
                ->get();

            $osAtrasados = OrderService::where("realized_date", "<", Carbon::now()->endOfWeek()->format('Y-m-d'))
//                ->where("realized_date", ">", Carbon::now()->startOfWeek()->format('Y-m-d'))
                ->where('statuses.name', '!=', 'Finalizado')
                ->leftJoin("workstations", "order_services.workstation_id", "=", "workstations.id")
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->select('order_services.id', 'order_services.problem', 'workstations.name AS workstation', 'statuses.name AS status')
                ->where('designated_employee', '=', Auth::user()->id)
                ->limit(5)
                ->get();

            $quantOSPendentes = OrderService::where("realized_date", ">", Carbon::today())
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->where("statuses.name", "Pendente")
                ->count();

            $quantOSAtrasados = OrderService::where("realized_date", "<", Carbon::today())
                ->leftJoin("statuses", "statuses.id", "=", "order_services.status_id")
                ->where("statuses.name", "Pendente")
                ->count();

            $quantOSFinalizados = DB::table('order_services')
                ->join("statuses", "statuses.id", "=", "order_services.status_id")
                ->where("statuses.name", "Finalizado")
                ->count();

            $quantOSTotal = DB::table('order_services')
                ->whereNull('deleted_at')
                ->count();

            $qtdBOTotal = DB::table('borrowings')
            ->count();

            $qtdBOFinalizado = DB::table('borrowings')
                ->leftJoin("statuses", "statuses.id", "=", "borrowings.status_id")
                ->where("statuses.name", "Finalizado")
                ->count();

            $qtdBOEmprestado = DB::table('borrowings')
                ->leftJoin("statuses", "statuses.id", "=", "borrowings.status_id")
                ->where("statuses.name", "Emprestado")
                ->count();

            return view('dashboard.dashboard', [
                "quantOSPendentes" => $quantOSPendentes,
                "quantOSAtrasados" => $quantOSAtrasados,
                "quantOSFinalizados" => $quantOSFinalizados,
                "quantOSTotal" => $quantOSTotal,
                "os" => $os,
                "osAtrasadas" => $osAtrasados,
                "qtdBOTotal" =>  $qtdBOTotal,
                'qtdBOFinalizado' => $qtdBOFinalizado,
                'qtdBOEmprestado' => $qtdBOEmprestado,

            ]);
        }

        return redirect()->route('login');
    }
}
