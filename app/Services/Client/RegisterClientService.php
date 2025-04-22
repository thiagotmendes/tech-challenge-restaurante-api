<?php
namespace App\Services\Client;

use App\Domain\Client\ClientEntity;
use App\Repositories\Contracts\ClientRepositoryInterface;

class RegisterClientService
{
    public function __construct(
        protected ClientRepositoryInterface $repository
    ) {}

    public function handle(array $data): void
    {
        $existing = $this->repository->findByCpf($data['cpf']);

        if ($existing) {
            abort(response()->json([
                'message' => 'CPF já cadastrado.'
            ], 422));
        }

        $client = new ClientEntity($data['name'], $data['email'], $data['cpf'], $data['phone']);
        $this->repository->save($client);
    }
}
