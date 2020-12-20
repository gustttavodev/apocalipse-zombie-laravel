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
        $inventario_1 = (object)$survivor_1[0]; //mochila do sobrevivente 1
        $inventario_2 = (object)$survivor_2[0]; //mochila do sobrevivente 2

        if ($survivor_troca == 'item'){

            $item_1 = $inventario_1->item;
            $item_2 = $inventario_2->item;
            // efetuando a troca

            if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                return response()->json([
                    'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                ]);
            }
            DB::select('update items set item = "'.$item_2.'" where survivor_id = "'.$inventario_1->survivor_id .'"');
            DB::select('update items set item = "'.$item_1.'" where survivor_id = "'.$inventario_2->survivor_id.'"');
        } else {
            switch ($survivor_troca):

                case 'W-F': // W-F caso o sobrevente queira trocar seus pontos de agua por comida.
                    DB::beginTransaction();
                    $points_water_1 = $inventario_1->water; // Pega a quantidade de pontos de agua o sobrevivente tem;
                    $points_food_2 = $inventario_2->food;
                    $quantity = $data['quantity'];

                    if($points_water_1 >= 4 && $points_food_2 >= 3 && $quantity > 0){

                        if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                            return response()->json([
                                'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                            ]);
                        }
                        $points_water_1 = $inventario_1->water - $quantity*3;
                        $points_food_2 = $inventario_2->food - $quantity*3;

                        //Efetuando a remoção dos pontos para depois efetuar a troca
                        DB::select('update items set water = "'.$points_water_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set food = "'.$points_food_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        $points_food_1 = $inventario_1->food + $quantity*3;
                        $points_water_2 = $inventario_2->water + $quantity*3;
                        //Agora eu atualizo  os pontos de cada sobrevivente
                        DB::select('update items set food = "'.$points_food_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set water = "'.$points_water_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        DB::commit();
                        return "Troca efetuada com sucesso !";
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'alert' => "Não foi possivel efetuar a troca, verifique seus pontos."
                        ]);
                    }
                case 'W-M': // W-M caso o sobrevente queira trocar seus pontos de agua por medicamento.
                    DB::beginTransaction();
                    $points_water_1 = $inventario_1->water;
                    $points_ammunition_2 = $inventario_2->medicament;
                    $quantity = $data['quantity'];

                    if($points_water_1 >= 4 && $points_ammunition_2 >= 2 && $quantity > 0){

                        if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                            return response()->json([
                                'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                            ]);
                        }

                        $points_water_1 = $inventario_1->water - $quantity*2;
                        $points_ammunition_2 = $inventario_2->medicament - $quantity*2;

                        //Efetuando a remoção dos pontos para depois efetuar a troca
                        DB::select('update items set water = "'.$points_water_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set medicament = "'.$points_ammunition_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        $points_medicament_1 = $inventario_1->medicament + $quantity*2;
                        $points_water_2 = $inventario_2->water + $quantity*2;

                        //Agora eu atualizo  os pontos de cada sobrevivente
                        DB::select('update items set medicament = "'.$points_medicament_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set water = "'.$points_water_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        DB::commit();
                        return "Troca efetuada com sucesso !";

                    } else {
                        DB::rollBack();
                        return response()->json([
                            'alert' => "Não foi possivel efetuar a troca, verifique seus pontos."
                        ]);
                    }
                case 'W-A':
                    DB::beginTransaction();
                    $points_water_1 = $inventario_1->water;
                    $points_ammunition_2 = $inventario_2->ammunition;
                    $quantity = $data['quantity'];

                    if($points_water_1 >= 4 && $points_ammunition_2 >= 1 && $quantity > 0){

                        if ($inventario_1->infected >= 3 || $inventario_2->infected >= 3) {
                            return response()->json([
                                'alert' => 'SOBREVIVENTE INFECTADO NÃO FOI POSSIVEL EFETUAR A TROCA!'
                            ]);
                        }
                        $points_water_1 = $inventario_1->water - $quantity*1;
                        $points_ammunition_2 = $inventario_2->ammunition - $quantity*1;

                        //Efetuando a remoção dos pontos para depois efetuar a troca
                        DB::select('update items set water = "'.$points_water_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set ammunition = "'.$points_ammunition_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        $points_ammunition_1 = $inventario_1->ammunition + $quantity*1;
                        $points_water_2 = $inventario_2->water + $quantity*1;

                        //Agora eu atualizo  os pontos de cada sobrevivente
                        DB::select('update items set ammunition = "'.$points_ammunition_1.'" where survivor_id = "'.$inventario_1->survivor_id.'"');
                        DB::select('update items set water = "'.$points_water_2.'" where survivor_id = "'.$inventario_2->survivor_id.'"');

                        DB::commit();
                        return "Troca efetuada com sucesso !";

                    } else {
                        DB::rollBack();
                        return response()->json([
                            'alert' => "Não foi possivel efetuar a troca, verifique seus pontos."
                        ]);
                    }



            endswitch;
        }
    }





}
