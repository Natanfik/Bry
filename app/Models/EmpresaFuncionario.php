<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaFuncionario extends Model
{
    use HasFactory;
    
    protected $table = 'empresa_funcionario';
    protected $fillable = ['empresa_id', 'funcionario_id', 'cargo_id', 'data_vinculo', 'data_desvinculo'];

    public function funcionario(): BelongsTo
    {
        // Assume que o modelo é Funcionarios e a chave é funcionario_id
        return $this->belongsTo(Funcionarios::class, 'funcionario_id');
    }

    /**
     * Define a relação com o cargo.
     */
    public function cargo(): BelongsTo
    {
        // Assume que o modelo é Cargo e a chave é cargo_id. 
        // Se seu modelo de cargo tem outro nome, substitua 'Cargo::class'.
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}

