<?php
namespace App\Domain\Client;

class ClientEntity
{
    public function __construct(
        public string $name,
        public string $email,
        public string $cpf,
        public string $phone
    ) {}
}
