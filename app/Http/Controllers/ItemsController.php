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
    public function verificaInfected($survivor_1, $survivor_2)
    {
        if ($survivor_1->infected >= 3 || $survivor_2->infected >= 3) {
            return response()->json([
                'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
            ]);
        }
    }

    public function trocas(Request $request)
    {
        $data = $request->all();
        $survivor_troca = $data['survivor_troca']; // Survivor troca é o que irá ser trocado do inventario.
        $id_survivor_1 = $data['id_survivor_1']; //pessoa que solicitou a troca
        $id_survivor_2 = $data['id_survivor_2']; //pessoa que irá trocar
        $survivor_1 = DB::select('select * from items where survivor_id = "'.$id_survivor_1.'"');
        $survivor_2 = DB::select('select * from items where survivor_id = "'.$id_survivor_2.'"');

        if (!$survivor_troca || !$id_survivor_1 || !$id_survivor_2) {
            return response()->json([
                'alert' => 'Desculpe não consegui prosseguir com a sua survivor_troca :('
            ], 404);
        }
        $inventario_1 = (object)$survivor_1[0];
        $inventario_2 = (object)$survivor_2[0];

        if ($survivor_troca == 'item'){

            $item_1 = $inventario_1->item;
            $item_2 = $inventario_2->item;
            // efetuando a troca

            $this->verificaInfected($inventario_1, $inventario_2);
            DB::select('update items set item = "'.$item_2.'" where survivor_id = "'.$inventario_1->survivor_id .'"');
            DB::select('update items set item = "'.$item_1.'" where survivor_id = "'.$inventario_2->survivor_id.'"');
        } else {
            switch ($survivor_troca):
                case 'W-F': // W-F caso o sobrevente queira trocar seus pontos de agua por comida.
                    DB::beginTransaction();
                    $points_water_1 = $inventario_1->water*4; // Pega a quantidade de pontos de agua o sobrevivente tem;
                    $points_food_2 = $inventario_2->food*3;
                    $quantity = $data['quantity'];
                    try {
                        if($points_water_1 >= 4 && $points_food_2 >= 3 && $quantity > 0){
                            $this->verificaInfected($inventario_1, $inventario_2);

                            $points_water_1 = $inventario_1->water - $quantity;
                            $points_food_2 = $inventario_2->food - $quantity;

                            //Efetuando a remoção dos pontos para depois efetuar a troca
                            DB::select('update items set water = "'.$points_water_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                            DB::select('update items set food = "'.$points_food_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                            $points_food_1 = $inventario_1->food + $quantity;
                            $points_water_2 = $inventario_2->water + $quantity;
                            //Agora eu atualizo  os pontos de cada sobrevivente
                            DB::select('update items set food = "'.$points_food_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                            DB::select('update items set water = "'.$points_water_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        }
                            DB::commit();
                            return "Troca efetuada com sucesso !";

                    } catch(Exception $e) {
                        return response()->json([
                           'alert' => "Não foi possivel efetuar a troca, verifique seus pontos."
                        ]);
                        DB::rollBack();
                    }





            endswitch;
        }
    }





}
