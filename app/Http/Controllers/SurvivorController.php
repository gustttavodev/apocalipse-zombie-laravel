<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survivor;
use App\Items;
use Illuminate\Support\Facades\DB;

class SurvivorController extends Controller
{
    public function index() {
        //Sobreviventes infectados automaticamente perdem todos os seus items.
        Items::all()->map(function ($i){
            if($i->infected >= 4){
                $infectado_s = Items::where('survivor_id',$i->survivor_id)->first();
                $infectado_s->item = '';
                $infectado_s->water = 0;
                $infectado_s->food = 0;
                $infectado_s->medicament = 0;
                $infectado_s->ammunition = 0;
                $infectado_s->save();
            }
        });
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

        $survivor->fill($request->all());
        $survivor->save();


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

}
