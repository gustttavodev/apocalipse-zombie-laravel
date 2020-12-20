<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survivor;
use App\Items;
use Illuminate\Support\Facades\DB;

class SurvivorController extends Controller
{
    public function index() {
        $survivor = Survivor::with('items')->get();
        return response()->json($survivor);
    }

    public function show($id) {
        $survivor = Survivor::with('items')->find($id);
        if(!$survivor){
            return response()->json([
                'alert' => 'Survivor not found'
            ]);
        }

        return response()->json($survivor);
    }

    public function store(Request $request) {

        DB::beginTransaction();
        $survivor = new Survivor();
        $inventory = new Items();

        //Salvando o sobrevivente
        $survivor->fill($request->all());
        $survivor->save();
        //Salvando o inventario e acrescentando os

        $inventory->infected = $request->infected;
        $inventory->item = $request->item;
        $inventory->water = $request->water*4;
        $inventory->food = $request->food*3;
        $inventory->medicament = $request->medicament*2;
        $inventory->ammunition = $request->ammunition*1;
        $inventory->survivor_id = $survivor->id;
        $inventory->save();

        if($survivor && $inventory){
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $survivor;
    }

    public function update(Request $request, $id) {

        DB::beginTransaction();
        $survivor = Survivor::find($id);
        $items = Items::find($id);

        if(!$survivor){
            return response()->json([
                'alert' => 'Survivor not found'
            ]);
        }

        $items->infected = $request->infected;
        $survivor->fill($request->all());
        $survivor->save();
        $items->save();

        if($survivor && $items){
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $survivor;
    }

    public function destroy($id){
        $survivor = Survivor::find($id);

        if(!$survivor){
            return response()->json([
                'alert' => 'Survivor not found'
            ], 404);
        }

        $survivor->delete();
    }

    public function relatorio(){
        echo "OK";
    }
}
