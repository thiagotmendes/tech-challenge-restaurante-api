<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Tech Challenge API",
 *     description="Documentação da API do sistema de autoatendimento."
 * )
 */

/**
 * @OA\Post(
 *     path="/clients",
 *     tags={"Clientes"},
 *     summary="Cadastrar um novo cliente",
 *     description="Cria um novo cliente no sistema com as informações fornecidas.",
 *     @OA\RequestBody(
 *         description="Dados do cliente a ser cadastrado",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email", "cpf", "phone"},
 *             @OA\Property(property="name", type="string", example="João da Silva"),
 *             @OA\Property(property="email", type="string", format="email", example="joao@gmail.com"),
 *             @OA\Property(property="cpf", type="string", example="123.456.789-00"),
 *             @OA\Property(property="phone", type="string", example="+55 (11) 99999-9999")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Cliente cadastrado com sucesso."
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação: CPF já cadastrado ou dados inválidos."
 *     )
 * )
 */

Route::post('/clients', [ClientController::class, 'store']);

/**
 * @OA\Get(
 *     path="/clients",
 *     tags={"Clientes"},
 *     summary="Listar todos os clientes",
 *     description="Retorna uma lista de todos os clientes cadastrados no sistema.",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de clientes retornada com sucesso.",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="João da Silva"),
 *                 @OA\Property(property="email", type="string", example="joao@gmail.com"),
 *                 @OA\Property(property="cpf", type="string", example="123.456.789-00"),
 *                 @OA\Property(property="phone", type="string", example="+55 (11) 99999-9999")
 *             )
 *         )
 *     )
 * )
 */

Route::get('/clients', [ClientController::class, 'index']);

