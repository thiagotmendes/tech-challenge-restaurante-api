<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Services\Order\KitchenOrderService;
use Illuminate\Http\JsonResponse;
class KitchenOrderController extends Controller
{
    public function __construct(protected KitchenOrderService $service) {}

    /**
     * @OA\Get(
     *     path="/api/kitchen/orders",
     *     summary="Listar pedidos da cozinha com filtro opcional de status",
     *     tags={"Cozinha"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar por status do pedido",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"recebido", "em_preparacao", "pronto", "finalizado"},
     *             example="em_preparacao"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pedidos filtrados ou pendentes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="client_id", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="status", type="string", example="em_preparacao"),
     *                 @OA\Property(property="total", type="number", format="float", example=42.50),
     *                 @OA\Property(property="created_at", type="string", example="2025-04-23 16:40:00"),
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="product_id", type="integer", example=1),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="price", type="number", example=15.00),
     *                         @OA\Property(property="product", type="object",
     *                             @OA\Property(property="name", type="string", example="Hambúrguer X")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $orders = $this->service->listPending($status);
        return response()->json($orders);
    }

    /**
     * @OA\Patch(
     *     path="/api/kitchen/orders/{id}/status",
     *     summary="Atualiza o status de um pedido",
     *     tags={"Cozinha"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do pedido",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"recebido", "em_preparacao", "pronto", "finalizado"},
     *                 example="em_preparacao"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Status atualizado para 'em_preparacao'")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido não encontrado"
     *     )
     * )
     */
    public function updateStatus(UpdateOrderStatusRequest $request, int $id): JsonResponse
    {
        $this->service->updateStatus($id, $request->validated('status'));

        return response()->json([
            'success' => true,
            'message' => "Status atualizado para '{$request->status}'"
        ]);
    }
}
