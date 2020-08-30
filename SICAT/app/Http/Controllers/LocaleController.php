<?php

namespace App\Http\Controllers;

use App\Locale;
use App\Workstation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class LocaleController extends Controller
{

    private $locale;

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    function index(Request $request)
    {
        if ($request->ajax()) {
            $locales = DB::table('locales')->select('id', 'name')->get();

            try {
                return DataTables::of($locales)
                    ->addColumn('action', function ($data) {

                        $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                        if (Gate::allows('rolesUser', 'workstation_view')) {
                            $result .= '<button type="button" id="' . $data->id . '" class="btn btn-primary"  data-toggle="modal" data-target="#modalView" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-eye"></i>Visualizar</button>';
                        }
                        if (Gate::allows('rolesUser', 'workstation_edit')) {
                            $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" data-toggle="modal" data-target="#modalEdit" data-whatever="' . $data->id . '""><i class="fas fa-fw fa-edit"></i>Editar</button>';
                        }
                        if (Gate::allows('rolesUser', 'workstation_disable')) {
                            $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Desabilitar</button>';
                        }

                        $result .= '</div>';
                        return $result;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                if (config('app.debug')) {
                    return response()->json(["message" => $e->getMessage()], 400);
                }

                return response()->json(["message" => $e->getMessage()], 400);
            }
        }

        return view('dashboard.locale.list-locales');
    }

    function create()
    {
        return view('dashboard.locale.create-locales');
    }

    function store(Request $req)
    {
        $data = $req->all();
        $local = null;

        DB::transaction(function () use ($data, $local) {
            $local = Locale::create(["name" => $data['name']]);
            foreach ($data['sala'] as $sala) {
                $local->workstation()->create(["name" => $sala]);
            }
        });

        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($local)));
    }

    function update(Request $req, $id)
    {
        try {

            $validatedData = $req->validate([
                'name' => 'required',
            ]);

            $data = $req->all();
            $locale = $this->locale->find($id);
            $locale->update($data);

            return response()->json(["message" => "Atualizado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function show($id)
    {
        $data = Locale::find($id);
        $data->workstation = $data->workstation;

        return $data;
    }

    function disable($id)
    {
        try {
            $locale = Locale::find($id);
            $locale->status = "disable";
            $locale->save();

            return response()->json(["message" => "Local desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function able($id)
    {
        try {
            $locale = Locale::find($id);
            $locale->status = "able";
            $locale->save();

            return response()->json(["message" => "Local habilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function workstations($locale)
    {
        try {
            $work = Workstation::all()->where("locale_id", "=", $locale);
            return response()->json(["data" => $work]);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
