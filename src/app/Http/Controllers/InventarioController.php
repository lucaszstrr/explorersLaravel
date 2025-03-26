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

        //Essa variavel foi criada para depois fazer a somatoria dos valores dos itens
        $somaItensExp1 = 0;

        //Esse foreach é usado para percorrer os itens que estão dentro do array
        foreach($explorador1Itens as $item){
            $somaItensExp1 += $item->valorItem;
        }

        $somaItensExp2 = 0;

        foreach($explorador2Itens as $item){
            $somaItensExp2 += $item->valorItem;
        }

        // return response()->json([
        //     $somaItensExp2
        // ]);

        if($somaItensExp1 != $somaItensExp2){
            return response()->json([
            'error' => 'Os valores não são compatíveis para fazer a troca'
        ], 400);
        }

        //O foreach é usado novamente para procurar o id do explorador e atualizar ele mudando o id para o outro explorador
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
            'message' => 'Troca feita com sucesso'
        ], 201);
    }

    public function relatorio(){

        $somaItensTotal = 0;

        //Seleciona a coluna valorItem da tabela Inventario
        $valorTodosItens = Inventario::select('valorItem')->get();

        //Percorre os valores para fazer a soma
        foreach($valorTodosItens as $item){
            $somaItensTotal += $item->valorItem;
        }

        //Percorre os valores e faz a media 
        foreach($valorTodosItens as $item){
            $media = $somaItensTotal / count($valorTodosItens);
        }

        //Aqui é feita uma contagem de valores maiores que 100 na coluna 'valorItem' da model Inventario
        $valoresMaiores = count(Inventario::where('valorItem', '>=', 100)->get());


        return response()->json([
            "O valor total de todos os itens é de   $somaItensTotal",
            "A média dos valores dos itens é de   $media",
            "A quantidade de valores maiores que 100 é $valoresMaiores",
        ]);

    }
}
