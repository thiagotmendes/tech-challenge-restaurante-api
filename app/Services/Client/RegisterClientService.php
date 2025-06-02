<?php
namespace App\Services\Client;

use App\Domain\Client\ClientEntity;
use App\Repositories\Contracts\ClientRepositoryInterface;

class RegisterClientService
{
    public function __construct(
        protected ClientRepositoryInterface $repository
    ) {}

    public function handle(array $data): ClientEntity
    {
        // Verifica se já existe um cliente com o CPF informado
        $existing = $this->repository->findByCpf($data['cpf']);

        if ($existing) {
            return $existing;
        }

        // Caso não exista, cria um novo cliente
        $client = new ClientEntity($data['name'], $data['email'], $data['cpf'], $data['phone']);
        return $this->repository->save($client);
    }
}
