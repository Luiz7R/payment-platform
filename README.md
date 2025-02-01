<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<br>
<br>
<br>
<h1 align="center">Payment Platform</h1>

### Plataforma de Pagamentos com Laravel e RabbitMQ

✅ Transferências entre usuários com validação de saldo e autorização externa.
<br>
✅ Processamento de pagamentos revertidos em caso de inconsistência.
<br>
✅ Notificações de transação assíncrono utilizando filas do RabbitMQ.
<br>
✅ Arquitetura baseada em services para modularidade e fácil manutenção.
<br>
✅ Feature Tests for Transactions.
<br>
✅ Regras de negócio seguras para evitar inconsistências financeiras.

Tecnologias Utilizadas
<br>
✅  Laravel – Framework PHP para desenvolvimento da API.
<br>
✅  RabbitMQ – Mensageria para processamento de transações de forma assíncrona.
<br>
✅  MySQL – Banco de dados relacional para armazenar transações e usuários.
<br>
✅  Docker – Containerização para padronizar ambiente de desenvolvimento e produção.

## Setup do Projeto
### Clone o repositório:

```bash
git clone https://github.com/luiz7R/payment-platform.git

cd payment-platform
```

### Configure o ambiente:
```bash
cp .env.example .env
```

### Inicie o Projeto:

```bash
./vendor/bin/sail up -d
```

#### Baixe o arquivo de coleção JSON
 [API Collection - Insomnia](./Payment_Platform_Collection_2025-02-01.json)

    obs: use os ids do usuário para testar a aplicação

### Rodar o UserSeeder
```bash
docker exec -it payment_platform php artisan db:seed
```

### Inicie o Processamento de filas dentro do container do Docker

```bash
docker exec -it payment_platform php artisan queue:work
```


## Regras de Negócio:

Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
usuários do tipo "COMMON"

Lojistas só recebem transferências, não enviam dinheiro para ninguém.
usuários do tipo "MERCHANT"

Antes de finalizar a transferência, consulta-se um serviço autorizador externo.

A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

No recebimento de pagamento, o usuário e o lojista receber notificação enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável.


