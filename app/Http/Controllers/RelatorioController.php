<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\b;

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
    public function gerarExel(){
        header("Content-Type: aplication/xls");
        header("Content-Disposition:attachment; filename = RelatorioApocalipse.xls");

        $infectados = DB::select('select survivor.*, items.infected from survivor
        join items on survivor.id = items.survivor_id where items.infected > 3');

        $sobreviventes = DB::select('select survivor.*, items.infected from survivor
        join items on survivor.id = items.survivor_id where items.infected <= 3');

        (object)$sobreviventes[0];
        (object)$infectados[0];

        $exel = "<meta charset='UTF-8'>";
        $exel .= "<table border='1'>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
    </thead>
    <tbody>";
        $exelInfec = $exel;
        $exelSobrev = $exel;
        $exelInfec .= "<br> <br> <b>INFECTADOS</b>";
        $exelSobrev .= "<b>SOBREVIVENTES</b>";
        foreach ($sobreviventes as $data){

            $exelSobrev .="
                <tr>
                <td>{$data->name}</td>
                <td>{$data->age}</td>
                <td>{$data->latitude}</td>
                <td>{$data->longitude}</td>
                </tr>";
        }
        foreach ($infectados as $data){

            $exelInfec .="
                <tr>
                <td>{$data->name}</td>
                <td>{$data->age}</td>
                <td>{$data->latitude}</td>
                <td>{$data->longitude}</td>
                </tr>";
        }
        $exelSobrev .= "</tbody>
                    </table>";
        $exelInfec .= "</tbody>
                    </table>";
        echo $exelSobrev;
        echo $exelInfec;

    }
}
