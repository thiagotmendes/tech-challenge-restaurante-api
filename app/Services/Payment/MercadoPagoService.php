<?php
namespace App\Services\Payment;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoService
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
    }

    public function criarPagamento(array $items): string
    {
        $client = new PreferenceClient();

        $preferenceData = [
            'items' => array_map(function ($item) {
                return [
                    'title' => 'Produto ID ' . $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'currency_id' => 'BRL',
                ];
            }, $items),
            'back_urls' => [
                'success' => route('pagamento.sucesso'),
                'failure' => route('pagamento.falha'),
                'pending' => route('pagamento.pendente'),
            ],
            'auto_return' => 'approved',
        ];

        try {
            $preference = $client->create($preferenceData);
            return $preference->init_point;
        } catch (MPApiException $e) {
            // Trate a exceção conforme necessário
            throw $e;
        }
    }
}

