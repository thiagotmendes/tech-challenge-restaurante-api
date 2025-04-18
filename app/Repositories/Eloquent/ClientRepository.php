<?php
namespace App\Repositories\Eloquent;

use App\Domain\Client\ClientEntity;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function save(ClientEntity $client): void
    {
        // TODO: Implement save() method.
        Client::create([
            'name' => $client->name,
            'email' => $client->email,
            'cpf' => $client->cpf,
            'phone' => $client->phone
        ]);
    }

    public function findByCpf(string $cpf): ?ClientEntity
    {
        // TODO: Implement findByCpf() method.
        $model = Client::where('cpf', $cpf)->first();

        if (!$model) return null;

        return new ClientEntity($model->name, $model->email, $model->cpf, $model->phone );
    }

    public function getAll(): array
    {
        // TODO: Implement all() method.
        return Client::all()
            ->map(fn ($client) => new ClientEntity(
                $client->name,
                $client->email,
                $client->cpf,
                $client->phone
            ))
            ->toArray();
    }
}
