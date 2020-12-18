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
//        $data = $request->all();
//        $id = $data['id'];
//        $id_2 = $data['id_exchange'];
//        $exchange_1 = DB::select('select * from items where survivor_id = "'.$id.'" ');
//        $exchange_2 = DB::select('select * from items where survivor_id = "'.$id_2.'" ');
//
//        if(!$data){
//            return response()->json([
//                'alert' => 'Para fazer uma troca você deve informar o
//                [id] da pessoa que quer trocar  e [id] da pessoa que irá fazer a troca !'
//            ], 404);
//        }
//
//        if($exchange_1 && $exchange_2){
//            foreach ($exchange_1[0] as $inventario){
//                $items = [];
//                array_push($items, $inventario);
//            }
//
//            dd($items);
//
//            $item1 = $exchange_1->item;
//            $item2 = $exchange_2->item;
//            //O item não tem pontos, ou seja ambos sobreviventes podem trocar Armas por facas etc...
//            $exchange_1->item = $item2;
//            $exchange_2->item = $item1;
//        }
    }
}
