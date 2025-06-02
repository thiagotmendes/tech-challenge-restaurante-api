<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\ConfirmOrderRequest;
use App\Http\Requests\Order\StepOrderRequest;
use App\Services\Order\ConfirmOrderService;
use App\Services\Order\SaveOrderStepService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderStepController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/orders/step",
     *     tags={"Pedidos"},
     *     summary="Adicionar item ao pedido em andamento",
     *     description="Adiciona um produto ao pedido atual. Se um token de pedido for enviado via cabeçalho, ele será reutilizado. Caso contrário, um novo pedido será iniciado.",
     *     @OA\Parameter(
     *         name="X-Order-Token",
     *         in="header",
     *         required=false,
     *         description="Token do pedido em andamento. Se não for enviado, será criado um novo token.",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"step", "product_id", "quantity"},
     *             @OA\Property(property="step", type="string", example="lanche"),
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item adicionado ao pedido com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", format="uuid"),
     *             @OA\Property(property="steps", type="array", @OA\Items(
     *                 @OA\Property(property="product_id", type="integer", example=1),
     *                 @OA\Property(property="quantity", type="integer", example=1)
     *             ))
     *         )
     *     )
     * )
     */
    public function step(StepOrderRequest $request, SaveOrderStepService $service): \Illuminate\Http\JsonResponse
    {
        $token = $request->header('X-Order-Token') ?? Str::uuid()->toString();

        $stepItem = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity ?? 1,
        ];

        $steps = $service->handle($token, $stepItem);

        return response()->json([
            'success' => true,
            'token' => $token,
            'steps' => $steps,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/orders/confirm",
     *     tags={"Pedidos"},
     *     summary="Confirmar pedido",
     *     description="Finaliza o pedido atual com base no token enviado. Os itens são salvos no banco de dados e o cache temporário é apagado. O client_id é opcional e pode ser usado para vincular o pedido a um cliente cadastrado. Se não for fornecido, o pedido será registrado sem vínculo com cliente.",
     *     @OA\Parameter(
     *         name="X-Order-Token",
     *         in="header",
     *         required=true,
     *         description="Token do pedido em andamento a ser finalizado.",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pickup_method"},
     *             @OA\Property(
     *                 property="client_id",
     *                 type="integer",
     *                 nullable=true,
     *                 description="ID do cliente obtido no cadastro/consulta de clientes. Opcional.",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="origin",
     *                 type="string",
     *                 enum={"totem", "whatsapp", "balcao"},
     *                 default="totem",
     *                 description="Origem do pedido",
     *                 example="totem"
     *             ),
     *             @OA\Property(
     *                 property="pickup_method",
     *                 type="string",
     *                 enum={"balcao", "delivery", "mesa"},
     *                 description="Método de retirada do pedido",
     *                 example="delivery"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido criado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pedido criado com sucesso!"),
     *             @OA\Property(property="order_id", type="integer", example=10),
     *             @OA\Property(property="total", type="number", format="float", example=45.90),
     *             @OA\Property(property="token", type="string", format="uuid", example="550e8400-e29b-41d4-a716-446655440000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido não encontrado ou expirado."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Pedido inválido ou vazio."
     *     )
     * )
     */
    public function confirm(ConfirmOrderRequest $request, ConfirmOrderService $service): \Illuminate\Http\JsonResponse
    {
        $token = $request->header('X-Order-Token');
        $clientId = $request->input('client_id');
        $origin = $request->input('origin', 'totem');
        $pickupMethod = $request->input('pickup_method');

        $response = $service->handle($token, $clientId, $origin, $pickupMethod);

        return response()->json(
            $response['status'] === 'success'
                ? [
                'success' => true,
                'message' => $response['message'],
                'order_id' => $response['order_id'],
                'total' => $response['total'],
                'token' => $token
            ]
                : ['success' => false, 'message' => $response['message']],
            $response['code']
        );
    }

}
