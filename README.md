# 🍔 Tech Challenge - Sistema de Autoatendimento para Lanchonete

## 🮩 Visão Geral
Este projeto foi criado para resolver os principais problemas operacionais de uma lanchonete em expansão, oferecendo um sistema backend robusto para controle de pedidos e administração via autoatendimento. O sistema será construído com foco em uma arquitetura limpa e desacoplada, seguindo os princípios da **Arquitetura Hexagonal**.

---

## 🧪 Tecnologias Utilizadas

- **Laravel 12**: Framework PHP para desenvolvimento backend.
- **MySQL**: Sistema gerenciador de banco de dados relacional.
- **Swagger (Laravel OpenAPI)**: Documentação interativa das APIs.
- **Docker + Docker Compose**: Ambiente padronizado e replicável.

---

## 📁 Estrutura Organizacional (Arquitetura Hexagonal Adaptada ao Laravel)

```
app/
├── Domain/
│   └── Pedido/                  # Regras de negócio (Entidades, regras puras)
│   └── Cliente/
│   └── Produto/
│   └── Categoria/
│
├── Http/
│   ├── Controllers/            # Adaptadores de entrada (API Controllers)
│   ├── Requests/               # Validação de dados de entrada
│
├── Services/                   # Casos de uso (application layer)
│   └── Pedido/
│   └── Cliente/
│   └── Produto/
│
├── Repositories/
│   ├── Contracts/              # Interfaces (ports)
│   └── Eloquent/              # Implementações concretas (adapters)
│
├── Models/                     # Modelos Eloquent
│
├── Providers/
│   └── AppServiceProvider.php # Bind das interfaces para os adapters

routes/
├── api.php                     # Rotas da API

swagger/
├── api-docs.yaml               # Documentação Swagger (Laravel OpenAPI)

Dockerfile                       # Dockerfile para build da aplicação

docker-compose.yml              # Composição de containers
```

---

## 🔧 Funcionalidades Esperadas (MVP Backend)

### APIs

1. **Cadastro do Cliente**
2. **Identificação do Cliente via CPF**
3. **CRUD de Produtos**
4. **Busca de Produtos por Categoria**
5. **Checkout (fake)** - Envio dos produtos para fila de pedidos
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

3. Suba os containers com Docker Compose
```bash
docker-compose up --build
```

4. Acesse a aplicação:
- Laravel: `http://localhost:8000`
- Swagger: `http://localhost:8000/api/documentation`

---

## 📌 Comandos Úteis no Docker

### ▶️ Rodar novas migrations manualmente
Caso adicione uma nova migration e queira executá-la sem reiniciar os containers:
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

