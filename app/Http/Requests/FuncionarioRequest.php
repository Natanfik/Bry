<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class FuncionarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('cpf')) {
            $cpf = preg_replace('/\D+/', '', $this->input('cpf'));
            $this->merge(['cpf' => $cpf]);
        }

        if ($this->has('telefone')) {
            $this->merge(['telefone' => preg_replace('/\D+/', '', $this->input('telefone'))]);
        }

        if ($this->has('email')) {
            $this->merge(['email' => filter_var($this->input('email'), FILTER_SANITIZE_EMAIL)]);
        }
    }

    public function rules(): array
    {
        $routeFuncionario = $this->route('funcionario');
        $id = is_object($routeFuncionario) ? $routeFuncionario->id : $routeFuncionario;

        $senhaRules = $this->isMethod('post')
            ? ['min:8','required', 'string', 'confirmed', 'min:8']
            : ['sometimes', 'nullable', 'string', 'confirmed', 'min:8'];

        return [
            'nome' => ['required', 'string', 'max:100'],
            'cpf' => [
                'required',
                'digits:11',
                Rule::unique('funcionarios', 'cpf')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('funcionarios', 'email')->ignore($id),
            ],
            'telefone' => ['sometimes', 'nullable', 'string', 'min:8', 'max:20'],
            'senha' => $senhaRules,
        ];
    }

public function messages(): array
    {
        return [
            // Usamos CPF como login — mensagens relacionadas a login removidas

            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser uma string.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.digits' => 'O CPF deve ter exatamente 11 números.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.confirmed' => 'A confirmação de senha não confere.',
            'senha.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ];
    }


    public function attributes(): array
    {
        return [
            'cpf' => 'CPF',
            'senha' => 'senha',
            'senha_confirmation' => 'confirmação de senha',
            'telefone' => 'telefone',
        ];
    }
}
