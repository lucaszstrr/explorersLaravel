<?php

namespace App\Http\Controllers;

use App\Models\Explorador;
use Illuminate\Http\Request;

class ExploradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Sucesso";
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
        $validateData = $request->validate([
            'nome' => 'required | string | max:255',
            'idade' => 'required | integer',
            'latitude' => 'required | string | max:255',
            'longitude' => 'required | string | max:255',
        ]);

        $explorador = Explorador::create($validateData);

        return response()->json([
            $explorador
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $atualizaLoc = $request->validate([
            'latitude' => 'required | string | max:255',
            'longitude' => 'required | string | max:255',
        ]);

        //Encontrando o id na tabela
        $explorer = Explorador::findOrFail($id);

        //Aqui faz o update para os novos dados no array associativo $atualizaLoc
        $explorer->update([
            'latitude' => $atualizaLoc['latitude'],
            'longitude' => $atualizaLoc['longitude']
        ]);

        return response()->json([
            $explorer['latitude'],
            $explorer['longitude'],
            'message' => 'Localizacao de ' . $explorer['nome'] . ' atualizada com sucesso!'
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
