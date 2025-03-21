<?php

namespace App\Http\Controllers;

use App\Models\Explorador;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateItem = $request->validate([
            'nome' => 'required | string | max:255',
            'valorItem' => 'required | integer',
            'explorador_id' => 'required | integer | exists:exploradores,id',
            'latitude' => 'required | string | max:255',
            'longitude' => 'required | string | max:255',
        ]);

        Explorador::findOrFail($validateItem['explorador_id']);

        $inventario = Inventario::create($validateItem);

        return response()->json( [
            'message' => 'Item foi adicionado com sucesso!',
            $inventario
        ], 201);

    }

    public function trade(Request $request){
        $validateTrade = $request->validate([
            'explorador1_id' => 'required | integer | exists:exploradores,id',
            'explorador1_itens.*' => 'required | integer | distinct | exists:inventario,id',
            'explorador2_id' => 'required | integer | exists:exploradores,id',
            'explorador2_itens.*' => 'required | integer | distinct | exists:inventario,id',
        ]);

        $explorador1 = Explorador::with('inventario')->findOrFail($validateTrade['explorador1_id']);
        $explorador2 = Explorador::with('inventario')->findOrFail($validateTrade['explorador2_id']);

        $explorador1Itens = $explorador1->inventario->whereIn('id', $validateTrade['explorador1_itens']);
        $explorador2Itens = $explorador2->inventario->whereIn('id', $validateTrade['explorador2_itens']);

        $somaItensExp1 = 0;

        foreach($explorador1Itens as $item){
            $somaItensExp1 += $item->valorItem;
        }

        $somaItensExp2 = 0;

        foreach($explorador2Itens as $item){
            $somaItensExp2 += $item->valorItem;
        }

        if($somaItensExp1 != $somaItensExp2){
            return response()->json([
            'error' => 'Os valores não são compatíveis para fazer a troca'
        ], 400);
        }

        foreach($explorador1Itens as $item){
            $item->update([
                'explorador_id' => $explorador2->id
            ]);
        }


        foreach($explorador2Itens as $item){
            $item->update([
                'explorador_id' => $explorador1->id
            ]);
        }

        return response()->json([
            $explorador1
        ]);
    }
}
