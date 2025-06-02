<?php
namespace App\Repositories\Eloquent;

use App\Domain\Client\ClientEntity;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function save(ClientEntity $client): ClientEntity
    {
        $model = Client::create([
            'name' => $client->name,
            'email' => $client->email,
            'cpf' => $client->cpf,
            'phone' => $client->phone
        ]);

        return new ClientEntity(
            $model->name,
            $model->email,
            $model->cpf,
            $model->phone,
            $model->id
        );
    }

    public function findByCpf(string $cpf): ?ClientEntity
    {
        $model = Client::where('cpf', $cpf)->first();

        if (!$model) return null;

        return new ClientEntity(
            $model->name,
            $model->email,
            $model->cpf,
            $model->phone,
            $model->id
        );
    }

    public function getAll(): array
    {
        return Client::all()
            ->map(fn ($client) => new ClientEntity(
                $client->name,
                $client->email,
                $client->cpf,
                $client->phone,
                $client->id
            ))
            ->toArray();
    }
}
