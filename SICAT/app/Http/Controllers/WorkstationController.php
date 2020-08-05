<?php

namespace App\Http\Controllers;

use App\Locale;
use App\Workstation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkstationController extends Controller
{

    function add(Request $req)
    {
        try {
            $data = $req->all();
            $local = null;
            DB::beginTransaction();

            $local = Locale::find($data['id']);
            $result =  $local->workstation()->create(["name" => $data['name']]);
            DB::commit();

            return response()->json(["message" => "Cadastrado com sucesso", "data" => $result]);
        } catch (Exception $e) {
            DB::rollBack();
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
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    function disable($id)
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


    function able($id)
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
