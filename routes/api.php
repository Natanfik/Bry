<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpresaFuncionarioController;


Route::get('/bry-app', function () {
    return response()->json(['message' => 'Welcome to the Bry App API!']);
});

Route::apiResource('funcionarios', FuncionariosController::class);
Route::prefix('v1')->group(function () {
    // Rotas públicas para funcionarios (listar/ver)
    Route::get('funcionarios', [FuncionariosController::class, 'index']);
    Route::get('funcionarios/{funcionario}', [FuncionariosController::class, 'show']);

    // Rotas que criam/atualizam/apagam 
    Route::post('funcionarios', [FuncionariosController::class, 'store']);
    Route::put('funcionarios/{funcionario}', [FuncionariosController::class, 'update']);
    Route::delete('funcionarios/{funcionario}', [FuncionariosController::class, 'destroy']);

    
});

Route::prefix('v1')->group(function () {
    // Rotas públicas para empresas (listar/ver)
    Route::get('empresas', [EmpresasController::class, 'index']);
    Route::get('empresas/{empresa}', [EmpresasController::class, 'show']);

    // Rotas que criam/atualizam/apagam
    Route::post('empresas', [EmpresasController::class, 'store']);
    Route::put('empresas/{empresa}', [EmpresasController::class, 'update']);
    Route::delete('empresas/{empresa}', [EmpresasController::class, 'destroy']);

  
});

Route::prefix('v1')->group(function () {
    // Rotas públicas para cargos (listar/ver)
    Route::get('cargos', [CargoController::class, 'index']);
    Route::get('cargos/{cargo}', [CargoController::class, 'show']);

    // Rotas que criam/atualizam/apagam 
    Route::post('cargos', [CargoController::class, 'store']);
    Route::put('cargos/{cargo}', [CargoController::class, 'update']);
    Route::delete('cargos/{cargo}', [CargoController::class, 'destroy']);

});

Route::prefix('v1')->group(function () {
    // Rotas públicas para empresa-funcionarios (listar/ver)
    Route::get('empresa-funcionario', [EmpresaFuncionarioController::class, 'index']);
    Route::get('empresa-funcionario/{empresaFuncionario}', [EmpresaFuncionarioController::class, 'show']);

    // Rotas que criam/atualizam/apagam
    Route::post('empresa-funcionario', [EmpresaFuncionarioController::class, 'store']);
    Route::put('empresa-funcionario/{empresaFuncionario}', [EmpresaFuncionarioController::class, 'update']);
    Route::delete('empresa-funcionario/{empresaFuncionario}', [EmpresaFuncionarioController::class, 'destroy']);

});