<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Empresas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'telefone',
    ];

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    public function vinculos(): HasMany
    {
        // A relação busca todos os registros na tabela 'empresa_funcionario'
        return $this->hasMany(EmpresaFuncionario::class, 'empresa_id');
    }

    public function funcionarios()
    {
        return $this->belongsToMany(Funcionarios::class)
                    ->withPivot(['cargo_id', 'data_vinculo', 'data_desvinculo'])
                    ->withTimestamps();
    }
}
