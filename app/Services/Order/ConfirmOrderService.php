<?php
namespace App\Services\Order;

use App\Services\Payment\MercadoPagoService;
use MercadoPago\Exceptions\MPApiException;

class ConfirmOrderService
{
    public function __construct(
        protected OrderDraftService $draft,
        protected OrderFactoryService $factory,
        protected OrderCreatorService $creator,
        protected MercadoPagoService $mercadoPagoService
    ) {}

    /**
     * @throws MPApiException
     */
    public function handle(string $token, ?int $clientId = null, string $origin = 'totem'): array
    {
        if (!$this->draft->exists($token)) {
            return ['status' => 'error', 'code' => 404, 'message' => 'Pedido não encontrado ou expirado.'];
        }

        $stepsData = $this->draft->get($token);
        if (empty($stepsData)) {
            return ['status' => 'error', 'code' => 400, 'message' => 'Pedido inválido ou vazio.'];
        }

        $entity = $this->factory->build($clientId, $origin, $stepsData);

//        $paymentUrl = $this->mercadoPagoService->criarPagamento( $entity->getItems() );

        $order = $this->creator->persist($entity, $token);
        $this->draft->clear($token);

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Pedido criado com sucesso!',
            'order_id' => $order->id,
            'total' => $order->total,
        ];
    }
}
