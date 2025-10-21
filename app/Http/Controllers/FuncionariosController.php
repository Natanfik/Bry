<?php
namespace App\Http\Controllers;

 use App\Models\Funcionarios;
use Illuminate\Http\Request;
 use App\Http\Requests\FuncionarioRequest;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Str;

class FuncionariosController extends Controller
{
    // GET /api/funcionarios
    public function index()
    {
        $funcionarios = Funcionarios::all();

        if ($funcionarios->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum funcionário encontrado',
                'data' => $funcionarios,
            ], 200);
        }

        return response()->json([
            'message' => 'Funcionários encontrados com sucesso',
            'data' => $funcionarios,
        ], 200);
    }

    // POST /api/funcionarios
    public function store(FuncionarioRequest $request)
    {
        try {
            $validated = $request->validate([
                'login' => ['required', 'string', 'unique:funcionarios,login', 'regex:/^[A-Za-z0-9_]+$/'],
                'nome' => ['required', 'string', 'max:255'],
                'cpf' => ['required', 'string', 'unique:funcionarios,cpf', 'min:11', 'max:14'],
                'email' => ['required', 'email', 'unique:funcionarios,email'],
                'telefone' => ['nullable', 'string', 'max:20'],
                'senha' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $validated['senha'] = Hash::make($validated['senha']);

            $funcionario = Funcionarios::create($validated);

            return response()->json([
                'message' => 'Funcionário criado com sucesso!',
                'data' => $funcionario,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar funcionário',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // GET /api/funcionarios/{id}
    public function show(Funcionarios $funcionario)
    {
        return response()->json([
            'message' => 'Funcionário encontrado com sucesso',
            'data' => $funcionario,
        ], 200);
    }

    // PUT /api/funcionarios/{id}
    public function update(FuncionarioRequest $request, Funcionarios $funcionario)
    {
        $data = $request->validated();

        if (!empty($data['senha'])) {
            $data['senha'] = Hash::make($data['senha']);
        } else {
            unset($data['senha']);
        }

        $funcionario->update($data);
        return response()->json([
            'message' => 'Funcionário atualizado com sucesso',
            'data' => $funcionario,
        ], 200);
    }

    // DELETE /api/funcionarios/{id}
    public function destroy(Funcionarios $funcionario)
    {
        $funcionario->delete();
        return response()->noContent(); // 204
    }
}
