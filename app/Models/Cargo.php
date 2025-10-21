<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome',
        'empresa_id',
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionarios::class);
    }
}
