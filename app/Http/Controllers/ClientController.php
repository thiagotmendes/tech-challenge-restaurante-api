<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Services\Client\ListClientsService;
use App\Services\Client\RegisterClientService;

class ClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/clients",
     *     tags={"Clientes"},
     *     summary="Listar todos os clientes",
     *     description="Retorna uma lista de todos os clientes cadastrados.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="João da Silva"),
     *                 @OA\Property(property="email", type="string", example="joao@gmail.com"),
     *                 @OA\Property(property="cpf", type="string", example="12345678900"),
     *                 @OA\Property(property="phone", type="string", example="11999998888")
     *             )
     *         )
     *     )
     * )
     */
    public function index(ListClientsService $service)
    {
        return response()->json($service->handle());
    }

    /**
     * @OA\Post(
     *     path="/clients",
     *     tags={"Clientes"},
     *     summary="Cadastrar novo cliente",
     *     description="Cadastra um novo cliente com nome, email, CPF e telefone.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","cpf","phone"},
     *             @OA\Property(property="name", type="string", example="João da Silva"),
     *             @OA\Property(property="email", type="string", example="joao@gmail.com"),
     *             @OA\Property(property="cpf", type="string", example="12345678900"),
     *             @OA\Property(property="phone", type="string", example="11999998888")
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
    public function store(StoreClientRequest $request, RegisterClientService $service)
    {
        $service->handle($request->validated());

        return response()->json(['message' => 'Cliente cadastrado com sucesso.'], 201);
    }

}
