<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionarios extends Model
{
    use HasFactory;

    // Mass assignable attributes (fixed spelling)
    protected $fillable = [
        'nome',
        'login',
        'cpf',
        'email',
        'telefone',
        'senha',
    ];

    // Hide sensitive attributes when serializing to arrays / JSON
    protected $hidden = [
        'senha',
    ];

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'empresa_funcionario')
                    ->withPivot(['empresa_id', 'data_vinculo', 'data_desvinculo'])
                    ->withTimestamps();

    }

    public function empresas()
    {
        return $this->belongsToMany(Empresas::class, 'empresa_funcionario')
                    ->withPivot(['cargo_id', 'data_vinculo', 'data_desvinculo'])
                    ->withTimestamps();
    }
}
