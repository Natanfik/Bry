<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Se a tabela já existe (migração parcial executada anteriormente), pule a criação
        if (Schema::hasTable('cargos')) {
            return;
        }

        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            // empresa_id deve ser chave estrangeira para empresas
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            // garante unicidade do mesmo nome dentro da mesma empresa
            $table->unique(['empresa_id', 'nome'], 'cargos_empresa_nome_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
