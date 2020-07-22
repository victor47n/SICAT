<?php

namespace App\Http\Controllers;

use App\Locale;
use Illuminate\Http\Request;

class LocaleController extends Controller
{

    private $locale;

    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    function add(Request $req)
    {
        $data = $req->all();
        $local = Locale::create($data);
        return response()->json(array("message" => "Cadastrado com sucesso", "data" => json_encode($local)));
    }

    function list($id)
    {
        $data = Locale::find($id);
        return $data;
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

        return $data;
    }

    function disable($id)
    {
        try {
            Locale::find($id)->delete();
            return response()->json(["message" => "Funcionário desabilitado com sucesso!"], 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(["message" => $e->getMessage()], 400);
            }

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
