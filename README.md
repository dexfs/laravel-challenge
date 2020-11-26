## Informações 

O projeto foi feito utilizando Laravel 5.5 e banco de dados PostgreSQL   

[Configurações necessárias](https://laravel.com/docs/5.5/installation#server-requirements)

Pode ser utilizada a versão 7.3 do PHP

## Como executar 
Clone o projeto 

Antes de configurar a aplicação necessário ter uma instância do banco de dados preparada 

## Banco de dados
### Usando Docker  
[Docker Get Started ](https://www.docker.com/get-started)

O comando abaixo irá criar e executar um container com o postgreSQL

````bash
$ docker-compose up 
#ou para rodar em background
$ docker-compose up -d  
````
### Info de acesso do banco de dados

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sandbox
DB_USERNAME=sandbox
DB_PASSWORD=sandbox
```

## Sem o Docker
[Download](https://www.postgresql.org/download/)


## Configurando a aplicação 

Entre no diretório da aplicação e execute os comandos abaixo

```bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
# migration 
$ php artisan migrate --seed

# to fresh migration and data  
$ php artisan migrate:fresh --seed
```

## Servidor para execução do projeto
Para macOs uma alternativa é usar o [valet](https://laravel.com/docs/5.5/valet#introduction)

para os demais casos execute o comando 
```$ php artisan serve```  

## Usuários de acesso ao sistema

```

email: admin@user.com
senha: 123456

email: a@a.com
senha: password
```

## Para rodar os testes

```
$ cp .env.test.example .env.test
$ php artisan test
```
