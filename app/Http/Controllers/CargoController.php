<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::all();

        if ($cargos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum cargo encontrado',
                'data' => $cargos,
            ], 200);
        }

        return response()->json([
            'message' => 'Cargos encontrados com sucesso',
            'data' => $cargos,
        ], 200);
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
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'empresa_id' => ['required', 'exists:empresas,id'],
        ]);

        $cargo = Cargo::create($data);

        return response()->json([
            'message' => 'Cargo criado com sucesso',
            'data' => $cargo,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $data = $request->validate([
            'nome' => ['sometimes', 'string', 'max:100'],
            'empresa_id' => ['sometimes', 'exists:empresas,id'],
        ]);

        $cargo->update($data);

        return response()->json([
            'message' => 'Cargo atualizado com sucesso',
            'data' => $cargo,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return response()->json([
            'message' => 'Cargo deletado com sucesso',
        ], 200);
    }
}
