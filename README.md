# Projeto Laravel 10 e Nuxt com Docker

Este projeto é uma aplicação full-stack utilizando **Laravel 10** para o backend e **Nuxt.js** para o frontend, ambos executados em containers Docker.

## Tecnologias

-   **Backend**: Laravel 10 (PHP 8.2)
-   **Frontend**: Nuxt.js (Vue.js 3)
-   **Banco de dados**: MySQL 8.0
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
docker-compose up --build
```

Este comando irá:

-   Construir as imagens Docker para o backend (Laravel) e frontend (Nuxt.js).
-   Subir os containers do MySQL, Laravel e Nuxt.

### Passo 3: Acessar o Projeto

-   Backend (Laravel): Acesse o backend em http://localhost:8000.
-   Frontend (Nuxt): Acesse o frontend em http://localhost:3000.

### Passo 4: Usar o Banco de Dados

O MySQL estará rodando no container com a porta 3306. Se você precisar conectar a um cliente de banco de dados local, use a porta 3306 ou a porta configurada no arquivo docker-compose.yml.

```
Usuário: root
Senha: root
Banco de dados: laravel
```

## Como Configurar o Ambiente Local

### Variáveis de Ambiente do Laravel

No diretório laravel-backend, copie o arquivo .env.example para .env e defina as variáveis de ambiente, especialmente a configuração do banco de dados:

```bash
cp .env.example .env
```

Certifique-se de que o banco de dados esteja configurado para se conectar ao container MySQL com as credenciais fornecidas no docker-compose.yml.

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

### Gerar a chave do Laravel

Dentro do container do backend, gere a chave da aplicação Laravel:

```bash
docker exec -it laravel-app bash
php artisan key:generate
exit
```

## Parar os Containers

Para parar os containers em execução, execute:

```bash
docker-compose down
```

Isso irá parar e remover os containers, mas os volumes persistirão. Para remover os volumes também, use:

```bash
docker-compose down -v
```
