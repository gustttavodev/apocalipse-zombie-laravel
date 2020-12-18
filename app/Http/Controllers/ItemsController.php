<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Items;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function index(){
        return Items::all();
    }

    public function trocas(Request $request){

        $data = $request->all();
        $troca = $data['troca'];
        $id = $data['id']; //pessoa que solicitou a troca
        $id_2 = $data['id_exchange']; //pessoa que irá trocar
        $exchange_1 = DB::select('select * from items where survivor_id = "'.$id.'" ');
        $exchange_2 = DB::select('select * from items where survivor_id = "'.$id_2.'" ');

        if(!$troca && !$data || !$exchange_1 || !$exchange_2){
            return response()->json([
                'alert' => 'Desculpe não consegui prosseguir com a sua troca :('
            ], 404);
        }
        if($troca == 'item' && $exchange_1 && $exchange_2){
            $inventario_1 = (object)$exchange_1[0]; //transforma o array que veio da query, em um objeto
            $inventario_2 = (object)$exchange_2[0];

            $item_1 = $inventario_1->item;
            $item_2 = $inventario_2->item;


            // efetuando a troca
            if($inventario_1->infected < 3 && $inventario_2->infected < 3){
                DB::select('update items set item = "'.$item_2.'" where survivor_id = "'.$id.'" ');
                DB::select('update items set item = "'.$item_1.'" where survivor_id = "'.$id_2.'" ');
            } else {
                return response()->json([
                   'alert' => 'ALERTA! SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                ]);
            }

            return response()->json([
               'alert' => 'Troca efetuada !'
            ]);
        }
    }
}
