<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\Order\OrderTrackingService;

class OrderTrackingController extends Controller
{
    public function __construct(protected OrderTrackingService $service) {}

    /**
     * @OA\Get(
     *     path="/api/orders/{token}/track",
     *     tags={"Pedidos"},
     *     summary="Acompanhar status do pedido",
     *     description="Retorna o status atual do pedido, incluindo tempo estimado de preparo e itens.",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Token do pedido a ser acompanhado",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status do pedido retornado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="string", example="em_preparacao"),
     *             @OA\Property(property="preparation_started_at", type="string", format="date-time", example="2024-05-06T17:30:00Z"),
     *             @OA\Property(property="estimated_ready_at", type="string", format="date-time", example="2024-05-06T17:45:00Z"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product", type="string", example="X-Burger"),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Pedido não encontrado.")
     *         )
     *     )
     * )
     */
    public function track(string $token): JsonResponse
    {
        $order = $this->service->handle($token);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'status' => $order->status,
            'preparation_started_at' => $order->preparation_started_at,
            'estimated_ready_at' => $order->estimated_ready_at,
            'items' => $order->items->map(function ($item) {
                return [
                    'product' => $item->product->name,
                    'quantity' => $item->quantity
                ];
            }),
        ]);
    }
}
