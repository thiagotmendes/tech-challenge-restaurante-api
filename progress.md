# ✅ Tech Challenge - Checklist de Progresso

Este documento lista as funcionalidades já implementadas e as pendências identificadas a partir da análise do Event Storming e do sistema desenvolvido.

---

## ✅ Funcionalidades Implementadas

* [x] Cadastro de clientes (nome, email, CPF, telefone)
* [x] Criação de pedidos por etapas (step-based)
* [x] Armazenamento temporário do pedido em Redis
* [x] Confirmação do pedido e gravação no banco
* [x] Itens vinculados ao pedido (order\_items)
* [x] Campo `origin` para identificar a origem do pedido (`totem`, `whatsapp`, `balcao`)
* [x] Enum de status do pedido (`recebido`, `em_preparacao`, `pronto`, `finalizado`)
* [x] Integração com Mercado Pago (Checkout Pro)
* [x] Notificação por evento: Pedido confirmado (`OrderConfirmed`)
* [x] Notificação por evento: Pedido pronto (`OrderReady`)
* [x] Listagem de pedidos na cozinha com filtro por status
* [x] Atualização do status do pedido via endpoint
* [x] Campo `preparation_started_at` na tabela `orders`
* [x] Endpoint `/orders/{token}/track` para retorno do status do pedido

---

## 📌 Melhorias Pendentes

### 🕒 Controle de tempo

* [x] Adicionar campo `preparation_started_at` na tabela `orders`
* [x] Adicionar campo `estimated_ready_at` (estimativa de conclusão)

### 👀 Acompanhamento pelo cliente

* [x] Criar endpoint `/orders/{token}/track` para retorno do status do pedido

### 🧾 Canal de retirada

* [x] Adicionar campo `pickup_method` (`balcao`, `delivery`, `mesa`) na tabela `orders`

### 👨‍🍳 Identificação do cozinheiro (futuro)

* [ ] Campo `kitchen_staff_id` (relacional ou opcional no MVP)

### 🎁 Promoções e combos

* [ ] Estrutura para aplicar combos e descontos dinâmicos nos produtos
* [ ] Avaliar regra de aplicação de `discount` via serviço

### 📈 Histórico e campanhas

* [ ] Criar endpoint `/clients/{id}/orders` para listar histórico de pedidos

### 🖥️ Painel administrativo

* [ ] Criar endpoint `/admin/orders/dashboard` para exibir resumo dos pedidos ativos por status

---

## 📌 Notas

* As melhorias podem ser implementadas de forma incremental.
* Recomenda-se priorizar as funcionalidades voltadas à experiência do cliente e fluxo da cozinha.
* Utilizar eventos para notificação e atualização de status garante escalabilidade e desacoplamento.
