# Projeto Laravel 10 e Nuxt com Docker

Este projeto é uma aplicação full-stack utilizando **Laravel 10** para o backend e **Nuxt.js** para o frontend, ambos executados em containers Docker.

## Tecnologias

-   **Backend**: Laravel 10 (PHP 8.2)
-   **Frontend**: Nuxt.js (Vue.js 3)
-   **Banco de dados**: Postgres 8.0
-   **Ambiente**: Docker

## Pré-requisitos

-   **Docker** e **Docker Compose** instalados na sua máquina.

    Caso não tenha o Docker e o Docker Compose, siga os passos de instalação:

    -   [Instalar o Docker](https://docs.docker.com/get-docker/)
    -   [Instalar o Docker Compose](https://docs.docker.com/compose/install/)

## Estrutura do Projeto

### laravel-backend/ # Backend em Laravel

-   Dockerfile # Dockerfile para o Laravel
-   .env # Arquivo de configuração do ambiente
-   app/ # Código do Laravel
-   routes/ # Rotas do Laravel

...

### nuxt-frontend/ # Frontend em Nuxt.js

-   Dockerfile # Dockerfile para o Nuxt
-   nuxt.config.js # Configurações do Nuxt
-   pages/ # Páginas do Nuxt
    ...

-   docker-compose.yml # Arquivo de configuração do Docker Compose

## Como Rodar o Projeto

### Passo 1: Clone o repositório

Primeiro, faça o clone do repositório para sua máquina local.

```bash
git clone https://github.com/LaisBeluco/aplicacao-rh.git
cd aplicacao-rh #Ou o nome que foi colocado por você
```

### Passo 2: Suba os Containers

Dentro da pasta do projeto, execute o seguinte comando para subir os containers do Docker:

```bash
docker compose up --build
```

```bash
docker exec -it aplicacao-rh-php-1 mv .env.example .env
```

```bash
docker exec -it aplicacao-rh-php-1 php artisan key:generate
```

```bash
docker exec -it aplicacao-rh-php-1 composer install
```

```bash
docker exec -it aplicacao-rh-php-1 chmod 755 . -R
```

```bash
docker exec -it aplicacao-rh-php-1 chmod 777 storage public bootstrap -R
```

Estes comando irão:

-   Construir as imagens Docker para o backend (Laravel) e frontend (Nuxt.js).
-   Subir os containers do Postgres, Laravel e Nuxt.

### Passo 3: Acessar o Projeto

-   Backend (Laravel): Acesse o backend em http://localhost:8001.
-   Frontend (Nuxt): Acesse o frontend em http://localhost:8000.

### Passo 4: Usar o Banco de Dados

O Postgres estará rodando no container com a porta 5432. Se você precisar conectar a um cliente de banco de dados local, use a porta 5432 ou a porta configurada no arquivo docker-compose.yml.

```
Usuário: root
Senha: root
Banco de dados: laravel
```

## Como Configurar o Ambiente Local

### Variáveis de Ambiente do Laravel

Certifique-se de que o banco de dados esteja configurado para se conectar ao container Postgres com as credenciais fornecidas no docker-compose.yml.

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
