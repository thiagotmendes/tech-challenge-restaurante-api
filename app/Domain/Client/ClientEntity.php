<?php
namespace App\Domain\Client;

class ClientEntity
{
    /**
     * @param string $name
     * @param string $email
     * @param string $cpf
     * @param string $phone
     * @param int|null $id
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $cpf,
        public string $phone,
        public ?int $id = null
    ) {}
}
