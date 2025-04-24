<?php
namespace App\Services\Order;

use App\Services\Payment\MercadoPagoService;
use MercadoPago\Exceptions\MPApiException;
use App\Events\OrderConfirmed;

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

        /** uncomment this line to back work on mercado pago */
//        $paymentUrl = $this->mercadoPagoService->criarPagamento( $entity->getItems() );

        $order = $this->creator->persist($entity, $token);
        $this->draft->clear($token);

        event(new OrderConfirmed($order->id, $order->total));

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Pedido criado com sucesso!',
            'order_id' => $order->id,
            'total' => $order->total,
        ];
    }
}
