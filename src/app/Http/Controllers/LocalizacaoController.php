<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $explorador_id)
    {
        $historicoLoc = Localizacao::findOrFail($explorador_id);

        if(!$historicoLoc){
            return response()->json([
                "message" => "Explorador não encontrado"
            ], 400);
        }

        $historicoLoc = Localizacao::where('explorador_id', $explorador_id)->get();

        return response()->json([
            "message" => "Este é o histórico de localizações",
            $historicoLoc
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localizacao $localizacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localizacao $localizacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localizacao $localizacao)
    {
        //
    }
}
