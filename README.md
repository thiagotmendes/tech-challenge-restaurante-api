# Tech Challenge - Sistema de Autoatendimento para Lanchonete

Tech challenge FIAP Arquitetura de Software

## 🮩 Visão Geral
Este projeto foi criado para resolver os principais problemas operacionais de uma lanchonete em expansão, oferecendo um sistema backend robusto para controle de pedidos e administração via autoatendimento. O sistema é construído com foco em uma arquitetura limpa e desacoplada, seguindo os princípios da **Arquitetura Hexagonal**.

---

### Grupo 49
![Logo do 49Burguer](./logo_49ers.jpg)
> RM363873 - Danilo Alves Ganda <br/>
> RM362245 - Fernando Nistal <br/>
> RM364485 - Ricardo Cezar Dias <br/>
> RM362014 - Thiago Mendes <br/>

---

## 🧪 Tecnologias Utilizadas

- **Laravel 12**: Framework PHP para desenvolvimento backend
- **MySQL**: Sistema gerenciador de banco de dados relacional
- **phpMyAdmin**: Interface visual para inspecionar o banco de dados
- **Swagger (Laravel OpenAPI)**: Documentação interativa das APIs
- **Docker + Docker Compose**: Ambiente padronizado e replicável
- **Mercado Pago**: Integração para pagamentos via QR Code
- **Laravel Telescope**: Debugging e monitoramento
- **Laravel Sanctum**: Autenticação API
- **Laravel Pail**: Logging avançado

---

## 📁 Estrutura Organizacional (Arquitetura Hexagonal Adaptada ao Laravel)

```
app/
├── Domain/                      # Camada de Domínio (Regras de Negócio)
│   ├── Order/                   # Domínio de Pedidos
│   │   ├── Entities/           # Entidades do domínio
│   │   ├── ValueObjects/       # Objetos de valor
│   │   └── Exceptions/         # Exceções específicas do domínio
│   ├── Product/                # Domínio de Produtos
│   │   ├── Entities/
│   │   ├── ValueObjects/
│   │   └── Exceptions/
│   └── Client/                 # Domínio de Clientes
│       ├── Entities/
│       ├── ValueObjects/
│       └── Exceptions/
│
├── Http/                       # Camada de Apresentação
│   ├── Controllers/           # Controladores da API
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   └── ClientController.php
│   ├── Requests/              # Validação de dados
│   │   ├── OrderRequest.php
│   │   ├── ProductRequest.php
│   │   └── ClientRequest.php
│   └── Resources/             # Transformação de dados
│       ├── OrderResource.php
│       ├── ProductResource.php
│       └── ClientResource.php
│
├── Services/                  # Camada de Aplicação
│   ├── Order/                # Serviços de Pedidos
│   │   ├── CreateOrderService.php
│   │   ├── UpdateOrderService.php
│   │   └── DeleteOrderService.php
│   ├── Product/              # Serviços de Produtos
│   │   ├── CreateProductService.php
│   │   ├── UpdateProductService.php
│   │   └── DeleteProductService.php
│   ├── Client/               # Serviços de Clientes
│   │   ├── CreateClientService.php
│   │   ├── UpdateClientService.php
│   │   └── DeleteClientService.php
│   └── Payment/              # Serviços de Pagamento
│       ├── MercadoPagoService.php
│       └── PaymentGatewayInterface.php
│
├── Repositories/             # Camada de Infraestrutura
│   ├── Contracts/           # Interfaces dos Repositórios
│   │   ├── OrderRepositoryInterface.php
│   │   ├── ProductRepositoryInterface.php
│   │   └── ClientRepositoryInterface.php
│   └── Eloquent/           # Implementações Eloquent
│       ├── OrderRepository.php
│       ├── ProductRepository.php
│       └── ClientRepository.php
│
├── Models/                  # Modelos Eloquent
│   ├── Order.php
│   ├── Product.php
│   └── Client.php
│
├── Events/                 # Eventos do Sistema
│   ├── OrderCreated.php
│   ├── OrderUpdated.php
│   └── OrderDeleted.php
│
├── Providers/             # Service Providers
│   ├── AppServiceProvider.php
│   ├── RepositoryServiceProvider.php
│   └── EventServiceProvider.php
│
└── Exceptions/           # Exceções Globais
    ├── Handler.php
    └── CustomExceptions/

routes/
├── api.php              # Rotas da API
└── channels.php         # Rotas de Broadcasting

config/
├── app.php             # Configurações da aplicação
├── database.php        # Configurações do banco
└── services.php        # Configurações de serviços

database/
├── migrations/         # Migrações do banco
├── seeders/           # Seeders para dados iniciais
└── factories/         # Factories para testes

tests/
├── Unit/              # Testes unitários
├── Feature/           # Testes de integração
└── TestCase.php       # Classe base para testes

swagger/
└── api-docs.yaml      # Documentação Swagger

docker/
├── wait-for.sh        # Script de espera do MySQL
└── nginx/            # Configurações do Nginx
    └── default.conf

Dockerfile             # Build da aplicação
docker-compose.yml     # Composição dos containers
```

---

## 🔧 Funcionalidades Implementadas

### APIs

1. **Cadastro do Cliente**
2. **Identificação do Cliente via CPF**
3. **CRUD de Produtos**
4. **Busca de Produtos por Categoria**
5. **Checkout com Mercado Pago** - Integração com QR Code
6. **Listagem e acompanhamento dos pedidos**

### Fluxo do Cliente
- Cadastro opcional via CPF
- Montagem do combo:
    1. Lanche
    2. Acompanhamento
    3. Bebida
    4. Sobremesa
- Pagamento via QRCode (Mercado Pago)
- Acompanhamento de status:
    - Recebido
    - Em preparação
    - Pronto
    - Finalizado

### Painel Administrativo
- Gerenciar clientes (dados para campanhas)
- Gerenciar produtos e categorias fixas:
    - Lanche, Acompanhamento, Bebida, Sobremesa
- Acompanhamento de pedidos em andamento e tempo de espera

---

## 🚀 Como Executar Localmente

1. Clone o repositório
```bash
git clone git@github.com:seu-usuario/seu-repositorio.git
cd seu-repositorio
```

2. Copie o arquivo de exemplo de ambiente
```bash
cp .env.example .env
```

3. Dê permissão ao script de espera do banco
```bash
chmod +x docker/wait-for.sh
```

4. Suba os containers com Docker Compose
```bash
docker-compose up --build
```

5. Acesse a aplicação:
- Laravel: `http://localhost:8000`
- Swagger: `http://localhost:8000/api/documentation`
- phpMyAdmin: `http://localhost:8081` (login: `root` / senha: `root`)
- Telescope: `http://localhost:8000/telescope`

---

## 📌 Comandos Úteis no Docker

### ▶️ Rodar novas migrations manualmente
```bash
docker exec -it laravel_app php artisan migrate
```

### ♻️ Persistência de dados
Os dados do banco **não serão perdidos** ao parar ou reiniciar os containers, pois usamos um volume nomeado:
```yaml
volumes:
  dbdata:
```
Para resetar completamente o banco (inclusive os dados):
```bash
docker-compose down -v
```

### 🔍 Debugging e Monitoramento
- Acesse o Laravel Telescope em `http://localhost:8000/telescope` para monitorar requisições, queries, logs e mais
- Use o Laravel Pail para logs em tempo real:
```bash
docker exec -it laravel_app php artisan pail
```

---

## ⚙️ Dependências Principais

- Laravel Framework 12
- Laravel Sanctum 4.0
- Laravel Telescope 5.7
- Mercado Pago SDK 3.2
- L5-Swagger 9.0
- Laravel Pail 1.2.2
- Laravel Pint 1.13
- PHPUnit 11.5.3

---

## 🔐 Segurança

- Autenticação via Laravel Sanctum
- Validação de dados com Form Requests
- Proteção contra CSRF
- Sanitização de inputs
- Rate limiting nas APIs
- Logs de segurança via Telescope

---

## 📝 Notas de Desenvolvimento

- O projeto segue os princípios SOLID
- Implementação de testes unitários e de integração
- Documentação da API via Swagger
- Logs estruturados para debugging
- Monitoramento via Laravel Telescope 