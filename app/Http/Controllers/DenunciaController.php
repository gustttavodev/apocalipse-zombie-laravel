<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use PhpParser\Error;

class DenunciaController extends Controller
{
    public function denuncia(Request $request){
        //Buscando a pessoa Infectada.
        $find_infected = Items::where('survivor_id', $request->survivor_id_infected)->first();

        //Acrescentando a denuncia.
        $find_infected->infected = $find_infected->infected + 1;
        $find_infected->save();

        return response()->json([
            'alert' => "Obrigado pela sua denuncia a humanidade agradece."
        ]);
    }
}
