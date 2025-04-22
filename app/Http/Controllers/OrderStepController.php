<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
    public function step(Request $request ): \Illuminate\Http\JsonResponse
    {
        $token = $request->header('x-Order-Token') ?? Str::uuid()->toString();

        $stepItem = [
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity', 1),
        ];

        $currentSteps = json_decode(Redis::get("order_draft:$token"), true);

        $currentSteps[] = $stepItem;

        Redis::setex("order_draft:$token", 60 * 60 * 24, json_encode($currentSteps));

        return response()->json([
            'success' => true,
            'token' => $token,
            'steps' => $currentSteps,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/orders/confirm",
     *     tags={"Pedidos"},
     *     summary="Confirmar pedido",
     *     description="Finaliza o pedido atual com base no token enviado. Os itens são salvos no banco de dados e o cache temporário é apagado.",
     *     @OA\Parameter(
     *         name="X-Order-Token",
     *         in="header",
     *         required=true,
     *         description="Token do pedido em andamento a ser finalizado.",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", nullable=true, example=1),
     *             @OA\Property(property="origin", type="string", example="totem")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido criado com sucesso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pedido criado com sucesso!"),
     *             @OA\Property(property="order_id", type="integer", example=10),
     *             @OA\Property(property="total", type="number", format="float", example=45.90)
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
    public function confirm(Request $request): \Illuminate\Http\JsonResponse
    {
        $token = $request->header('X-Order-Token');

        if (!$token || !Redis::exists("order_draft:$token")) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido não encontrado ou expirado.'
            ], 404);
        }

        $stepsData = json_decode(Redis::get("order_draft:$token"), true);
        if (empty($stepsData)) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido inválido ou vazio.'
            ], 400);
        }

        $total = 0;
        $clientId = $request->input('client_id'); // Pode ser null
        $origin = $request->input('origin', 'totem'); // 'totem' como default

        // Cria o pedido
        $order = Order::create([
            'client_id' => $clientId,
            'total' => 0, // atualizado depois
            'status' => 'recebido',
            'token' => $token,
            'origin' => $origin,
        ]);

        foreach ($stepsData as $item) {
            $product = Products::find($item['product_id']);
            if (!$product) {
                continue;
            }

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        // Atualiza total
        $order->update(['total' => $total]);

        // Limpa o rascunho do Redis
        Redis::del("order_draft:$token");

        return response()->json([
            'success' => true,
            'message' => 'Pedido criado com sucesso!',
            'order_id' => $order->id,
            'total' => $total
        ]);
    }

}
