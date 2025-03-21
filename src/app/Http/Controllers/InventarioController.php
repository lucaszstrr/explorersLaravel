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

    /**
     * Display the specified resource.
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        //
    }
}
