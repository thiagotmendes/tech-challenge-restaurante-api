<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Services\Client\ListClientsService;
use App\Services\Client\RegisterClientService;

class ClientController extends Controller
{
    public function index(ListClientsService $service)
    {
        return response()->json($service->handle());
    }

    public function store(StoreClientRequest $request, RegisterClientService $service)
    {
        $service->handle($request->validated());

        return response()->json(['message' => 'Cliente cadastrado com sucesso.'], 201);
    }
}
