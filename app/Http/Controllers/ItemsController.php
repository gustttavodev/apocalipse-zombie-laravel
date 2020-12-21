<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Items;

use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function index(){
        return Items::all();
    }

    public function trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,$points_1,$points_2){
        DB::beginTransaction();
        /* $quantity = Quantidade que irá trocar
         * $inventario_1 = Inventario do primeiro sobrevivente
         * $inventario_2 = Inventario do segundo sobrevivente
         * $trocar_1 = O que irá ser trocado (water,food...)
         * $trocar_2 = Segunda coisa que irá ser trocado (water,food...)
         * $poits_1 = Quantidade de pontos que o primeiro produto vale.
         * $poits_2 = Quantidade de pontos que o segundo produto vale.
         * */
        if($inventario_1->$trocar_1 >= $points_2 && $inventario_2->$trocar_2 >= $points_2 && $quantity > 0) {

            if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                return response()->json([
                    'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                ]);
            }
            $survivor_1 = Items::where('survivor_id', $inventario_1->survivor_id)->first();
            $survivor_2 = Items::where('survivor_id', $inventario_2->survivor_id)->first();

            $survivor_1->$trocar_1 = $inventario_1->$trocar_1 - ($quantity * $points_2);
            $survivor_2->$trocar_2 = $inventario_2->$trocar_2 - ($quantity * $points_2);

            $survivor_1->$trocar_2 = $inventario_1->$trocar_2 + ($quantity * $points_2);
            $survivor_2->$trocar_1 = $inventario_2->$trocar_1 + ($quantity * $points_2);

            $survivor_1->save();
            $survivor_2->save();
            DB::commit();

            return ['alert' => 'Troca efetuada com sucesso !'];
        }
         else {
             DB::rollBack();
            response()->json([
                'alert' => "Não foi possivel efetuar a troca, verifique seus pontos."
            ]);

        }
    }

    public function trocas(Request $request)
    {
        $data = $request->all();
        $data['survivor_troca'] = strtoupper($data['survivor_troca']);
        $survivor_troca = $data['survivor_troca']; // Survivor troca é o que irá ser trocado do inventario.
        $id_survivor_1 = $data['id_survivor_1']; //pessoa que solicitou a troca
        $id_survivor_2 = $data['id_survivor_2']; //pessoa que irá trocar
        $survivor_1 = DB::select('select * from items where survivor_id = "'.$id_survivor_1.'"');
        $survivor_2 = DB::select('select * from items where survivor_id = "'.$id_survivor_2.'"');
        $inventario_1 = (object)$survivor_1[0]; //mochila do sobrevivente 1
        $inventario_2 = (object)$survivor_2[0]; //mochila do sobrevivente 2

        if (!$survivor_troca || !$id_survivor_1 || !$id_survivor_2) {
            return response()->json([
                'alert' => 'Desculpe não consegui prosseguir com a sua survivor_troca :('
            ], 404);
        }

        switch ($survivor_troca):


            case 'ITEM':
                $item_1 = $inventario_1->item;
                $item_2 = $inventario_2->item;

                if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                    return response()->json([
                        'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                    ]);
                }
                DB::select('update items set item = "'.$item_2.'" where survivor_id = "'.$inventario_1->survivor_id .'"');
                DB::select('update items set item = "'.$item_1.'" where survivor_id = "'.$inventario_2->survivor_id.'"');
                break;
            case 'W-F': // W-F caso o sobrevente queira trocar seus pontos de agua por comida.

                $quantity = $data['quantity'];
                $trocar_1 = 'water';
                $trocar_2 = 'food';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,4,3);
                break;
            case 'W-M':
                $quantity = $data['quantity'];
                $trocar_1 = 'water';
                $trocar_2 = 'medicament';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,4,2);
                break;
            case 'W-A':
                $quantity = $data['quantity'];
                $trocar_1 = 'water';
                $trocar_2 = 'ammunition';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,4,1);
                break;
            case 'F-W':
                $quantity = $data['quantity'];
                $trocar_1 = 'food';
                $trocar_2 = 'water';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,3,4);
                break;
            case 'F-M':
                $quantity = $data['quantity'];
                $trocar_1 = 'food';
                $trocar_2 = 'medicament';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,3,2);
                break;
            case 'F-A':
                $quantity = $data['quantity'];
                $trocar_1 = 'food';
                $trocar_2 = 'ammunition';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,3,1);
                break;
            case 'M-W':
                $quantity = $data['quantity'];
                $trocar_1 = 'medicament';
                $trocar_2 = 'water';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,2,4);
                break;
            case 'M-F':
                $quantity = $data['quantity'];
                $trocar_1 = 'medicament';
                $trocar_2 = 'food';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,2,3);
                break;
            case 'M-A':
                $quantity = $data['quantity'];
                $trocar_1 = 'medicament';
                $trocar_2 = 'ammunition';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,2,1);
                break;
            case 'A-W':
                $quantity = $data['quantity'];
                $trocar_1 = 'ammunition';
                $trocar_2 = 'water';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,1,4);
                break;
            case 'A-F':
                $quantity = $data['quantity'];
                $trocar_1 = 'ammunition';
                $trocar_2 = 'food';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,1,3);
                break;
            case 'A-M':
                $quantity = $data['quantity'];
                $trocar_1 = 'ammunition';
                $trocar_2 = 'medicament';
                $this->trocandoItems($quantity,$inventario_1,$inventario_2,$trocar_1,$trocar_2,1,2);
                break;
        endswitch;

    }

}
