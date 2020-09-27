<?php

namespace App\Http\Controllers;

use App\Locale;
use App\Workstation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkstationController extends Controller
{

    function store(Request $req)
    {
        try {
            $data = $req->all();

            DB::transaction(function () use ($data) {
                $local = Locale::find($data['id']);
                $local->workstation()->create(["name" => $data['name']]);
            });

            $result = DB::table('workstations')
                ->select('id', 'name')
                ->where('name', '=', $data['name'])
                ->where('locale_id', '=', $data['id'])
                ->first();

//            dd($result->data);

            return response()->json(["message" => "Cadastrado com sucesso", "data" => $result], 201);
        } catch (Exception $e) {
//            DB::rollBack();
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }


    function update(Request $req, $id)
    {
        $data = $req->all();
        try {
            $work = Workstation::find($id);
            $work->name = $data['name'];
            $work->save();

            return response()->json(["message" => "Posto de trabalho atualizado com sucesso!"], 200);
        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function disable($id)
    {
        try {
            Workstation::destroy($id);

            return response()->json(["message" => "Posto de trabalho desabilitado com sucesso!"], 201);
        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }


    function able($id)
    {
        try {
            Workstation::withTrashed()->where('id', $id)->restore();

            return response()->json(["message" => "Posto de trabalho habilitado com sucesso!"], 201);
        } catch (Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
