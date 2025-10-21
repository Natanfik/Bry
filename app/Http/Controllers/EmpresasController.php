<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\EmpresaFuncionario;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $empresas = Empresas::with(['vinculos.funcionario', 'vinculos.cargo'])->get();

        $empresasSimplificadas = $empresas->map(function ($empresa) {
            return [
                'id' => $empresa->id,
                'nome' => $empresa->nome,
                'CNPJ' => $empresa->CNPJ,
                'endereco' => $empresa->endereco,
                'telefone' => $empresa->telefone,
                'funcionarios' => $empresa->vinculos->map(function ($vinculo) {
                    return ['nome' => $vinculo->funcionario->nome, 'cpf' => $vinculo->funcionario->cpf];

                }),
                'vinculos' => $empresa->vinculos->map(function ($vinculo) {
                    return ['cargo' => ['nome' => $vinculo->cargo->nome,],
                            'data_inicio' => $vinculo->data_vinculo,
                            'data_fim' => $vinculo->data_desvinculo,
                    ];
                }),
            ];
        });

        return response()->json([
            'message' => 'Empresas e seus vínculos encontrados com sucesso.',
            'data' => $empresasSimplificadas,
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
        // Normaliza campos com variações de chave (ex: acento ou maiúsculas)
        if (!$request->has('endereco') && $request->has('endereço')) {
            $request->merge(['endereco' => $request->input('endereço')]);
        }
        if (!$request->has('cnpj') && $request->has('CNPJ')) {
            $request->merge(['cnpj' => $request->input('CNPJ')]);
        }
        if (!$request->has('cnpj') && $request->has('Cnpj')) {
            $request->merge(['cnpj' => $request->input('Cnpj')]);
        }

        // Validação básica
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'cnpj' => ['required', 'string', 'max:18', Rule::unique('empresas', 'cnpj')],
            'endereco' => ['sometimes', 'nullable', 'string', 'max:255'],
            'telefone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        $empresa = Empresas::create($data);

        return response()->json([
            'message' => 'Empresa criada com sucesso',
            'data' => [
                'id' => $empresa->id,
                'nome' => $empresa->nome,
                'cnpj' => $empresa->cnpj,
                'endereco' => $empresa->endereco,
                'telefone' => $empresa->telefone,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresas $empresa)
    {
        try {
            // 1. A variável $empresa já contém a empresa que você quer (graças ao Route Model Binding).
            
            // 2. Usamos 'load' para anexar a relação 'vinculos' (definida no modelo Empresas).
            //    Dentro de 'vinculos', usamos Eager Loading aninhado para trazer o Funcionário e o Cargo.
            $empresa->load([
                'vinculos' => function ($query) {
                    $query->with(['funcionario', 'cargo']);
                }
            ]);

            // 3. Verifica se a empresa tem vínculos, mas o retorno é sempre 200 OK.
            $message = $empresa->vinculos->isEmpty() 
                       ? 'Empresa encontrada, mas sem funcionários vinculados.'
                       : 'Empresa e vínculos encontrados com sucesso.';

            // 4. Retorna a empresa com os vínculos aninhados no JSON
            return response()->json([
                'message' => $message,
                'data' => $empresa,
            ], 200);

        } catch (\Exception $e) {
            // Em caso de erro de carregamento ou outro erro interno
            return response()->json([
                'message' => 'Erro interno do servidor ao buscar a empresa e seus vínculos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresas $empresa)
    {
        // Usamos route-model binding, apenas retornamos o recurso
        return response()->json([
            'message' => 'Empresa encontrada para edição',
            'data' => $empresa,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresas $empresa)
    {
        // Normaliza campos com variações de chave (ex: acento ou maiúsculas)
        if (!$request->has('endereco') && $request->has('endereço')) {
            $request->merge(['endereco' => $request->input('endereço')]);
        }
        if (!$request->has('cnpj') && $request->has('CNPJ')) {
            $request->merge(['cnpj' => $request->input('CNPJ')]);
        }
        if (!$request->has('cnpj') && $request->has('Cnpj')) {
            $request->merge(['cnpj' => $request->input('Cnpj')]);
        }

        $data = $request->validate([
            'nome' => ['sometimes', 'string', 'max:100'],
            'cnpj' => ['sometimes', 'string', 'max:18', Rule::unique('empresas', 'cnpj')->ignore($empresa->id)],
            'endereco' => ['sometimes', 'nullable', 'string', 'max:255'],
            'telefone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        $empresa->update($data);

        // Recarrega a instância a partir do banco e retorna
        $empresa->refresh();

        return response()->json([
            'message' => 'Empresa atualizada com sucesso',
            'data' => $empresa,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresas $empresa)
    {
        $empresa->delete();

        // 204 No Content é apropriado para deleções bem sucedidas sem corpo
        return response()->noContent();
    }
}
