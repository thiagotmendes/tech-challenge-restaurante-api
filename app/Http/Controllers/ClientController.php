<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Services\Client\ListClientsService;
use App\Services\Client\RegisterClientService;

class ClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clients",
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
     *                 @OA\Property(property="id", type="integer", example=1),
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
     *     path="/api/clients",
     *     tags={"Clientes"},
     *     summary="Cadastrar cliente ou retornar cliente existente",
     *     description="Cria um novo cliente com os dados informados ou retorna o cliente já existente com o mesmo CPF. O ID do cliente retornado pode ser usado posteriormente para vincular pedidos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "cpf", "phone"},
     *             @OA\Property(property="name", type="string", example="João da Silva"),
     *             @OA\Property(property="email", type="string", format="email", example="joao@example.com"),
     *             @OA\Property(property="cpf", type="string", example="12345678900"),
     *             @OA\Property(property="phone", type="string", example="11999999999")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente registrado ou já existente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Cliente registrado ou já existente."),
     *             @OA\Property(
     *                 property="client",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="João da Silva"),
     *                 @OA\Property(property="email", type="string", example="joao@example.com"),
     *                 @OA\Property(property="cpf", type="string", example="12345678900"),
     *                 @OA\Property(property="phone", type="string", example="11999999999")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados fornecidos"
     *     )
     * )
     */

    public function store(StoreClientRequest $request, RegisterClientService $service)
    {
        $client = $service->handle($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado ou já existente.',
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'cpf' => $client->cpf,
                'phone' => $client->phone
            ]
        ], 200);
    }

}
