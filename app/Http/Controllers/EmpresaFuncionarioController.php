<?php

namespace App\Http\Controllers;

use App\Models\EmpresaFuncionario;
use Illuminate\Http\Request;

class EmpresaFuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresaFuncionarios = EmpresaFuncionario::all();

        if ($empresaFuncionarios->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum vínculo encontrado',
                'data' => $empresaFuncionarios,
            ], 200);
        }

        return response()->json([
            'message' => 'Vínculos encontrados com sucesso',
            'data' => $empresaFuncionarios,
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
            'funcionario_id' => ['required', 'exists:funcionarios,id'],
            'cargo_id' => ['required', 'exists:cargos,id'],
            'empresa_id' => ['required', 'exists:empresas,id'],
            
        ]);

        $data['data_vinculo'] = now();

        $empresaFuncionario = EmpresaFuncionario::create($data);

        return response()->json([
            'message' => 'Vínculo criado com sucesso',
            'data' => $empresaFuncionario,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmpresaFuncionario $empresaFuncionario)
    {
        return response()->json([
            'message' => 'Vínculo encontrado',
            'data' => $empresaFuncionario,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmpresaFuncionario $empresaFuncionario)
    {
        return response()->json([
            'message' => 'Vínculo pronto para edição',
            'data' => $empresaFuncionario,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmpresaFuncionario $empresaFuncionario)
    {
        $data = $request->validate([
            'empresa_id' => ['sometimes', 'exists:empresas,id'],
            'funcionario_id' => ['sometimes', 'exists:funcionarios,id'],
            'cargo_id' => ['sometimes', 'exists:cargos,id'],
            'data_vinculo' => ['sometimes', 'date'],
            'data_desvinculo' => ['sometimes', 'date'],
        ]);

        $empresaFuncionario->update($data);

        return response()->json([
            'message' => 'Vínculo atualizado com sucesso',
            'data' => $empresaFuncionario,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmpresaFuncionario $empresaFuncionario)
    {
        $empresaFuncionario->delete();

        return response()->json([
            'message' => 'Vínculo deletado com sucesso',
        ], 200);
    }
}
