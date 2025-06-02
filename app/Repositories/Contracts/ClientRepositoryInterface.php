<?php
namespace App\Repositories\Contracts;
use App\Domain\Client\ClientEntity;

interface ClientRepositoryInterface
{
    public function save(ClientEntity $client): ClientEntity;
    public function findByCpf(string $cpf): ?ClientEntity;
    public function getAll(): array;
}
