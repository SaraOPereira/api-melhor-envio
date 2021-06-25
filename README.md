# API Melhor Envio - Requisição para envio de lojas e endereços
Uso da API Melhor Envio para o envio de lojas e endereços por CSV.

## Requisitos
- PHP v8+
- Composer

## Como usar
Baixar o código e, dentro da pasta do projeto, abra um prompt de comando.
Instale as dependências do Composer:
```sh
composer install
```

Copie o .env.example para .env:
```sh
cp .env.example .env
```

Coloque suas informações no .env:
```sh
MENV_CLIENT_ID=XXXXXXXXXX
MENV_CLIENT_SECRET=XXXXXXXXXX
MENV_CODE=XXXXXXXXXX
MENV_REDIRECT_URI=XXXXXXXXXX
MENV_ACCESS_TOKEN=XXXXXXXXXX
MENV_REFRESH_TOKEN=XXXXXXXXXX
```

Gere uma key para o laravel e inicie ele localmente:
```sh
php artisan key:generate
php artisan serve
```