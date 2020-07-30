<?php

namespace App\Http\Controllers;

use App\Locale;
use App\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class LocaleController extends Controller
{

    private $locale;

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    function index()
    {
        return view('dashboard/listar_locais');
    }

    function create()
    {
        return view('dashboard/locales_create');
    }

    function add(Request $req)
    {
        $data = $req->all();
        $local = null;
        DB::transaction(function () use ($data, $local) {
            $local = Locale::create($data);
            foreach ($data['sala'] as $sala) {
                $local->workstation()->create(["name" => $sala]);
            }
        });

        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($local)));
    }

    function list()
    {
        $locais = DB::table('locales')->select('id', 'name')->get();

        return DataTables::of($locais)
            ->addColumn('action', function ($data) {

                $result = '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">';
                // if (Gate::allows('rolesUser', 'user_edit')) 
                $result .= '<button type="button" id="' . $data->id . '" class="btn btn-secondary" onclick="showEditModal(' . $data->id . ')"><i class="fas fa-fw fa-edit"></i>Editar</button>';

                //if (Gate::allows('rolesUser', 'user_delete')) 
                $result .= '<button type="button" id="' . $data->id . '" class="btn btn-danger" onclick="disable(' . $data->id . ')"><i class="fas fa-fw fa-trash"></i>Excluir</button>';

                $result .= '</div>';
                return $result;
            })
            ->rawColumns(['action'])
            ->make(true);
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

    function disableWorkstation($id)
    {
        try {
            $work = Workstation::find($id);
            $work->status = "disable";
            $work->save();

            return response()->json(["message" => "Posto de trabalho desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }


    function ableWorkstation($id)
    {
        try {
            $work = Workstation::find($id);
            $work->status = "able";
            $work->save();

            return response()->json(["message" => "Posto de trabalho habilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
