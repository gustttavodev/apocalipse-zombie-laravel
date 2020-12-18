<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function relatorio(){
        $infectados = DB::select('select survivor.*, items.infected from survivor
        join items on survivor.id = items.survivor_id where items.infected > 3');

        $sobreviventes = DB::select('select survivor.*, items.infected from survivor
        join items on survivor.id = items.survivor_id where items.infected <= 3');

        $relatorio['sobreviventes'] = $sobreviventes;
        $relatorio['infectados'] = $infectados;
        return json_encode($relatorio);
    }
}
