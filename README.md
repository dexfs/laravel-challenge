# Desafio DotSet

[Video execução do projeto](https://www.loom.com/share/a325ec4c447e4e56a29f15aecbeea945) 

## Link das tarefas do projeto

[Projeto Start](https://docs.google.com/spreadsheets/d/1piYemiZ3ssumbXGA_VN-M96tea6nY7lRmH_oyySDfLw/edit#gid=885023806)

## Informações 

O projeto foi feito utilizando Laravel 5.5 e banco de dados PostgreSQL  

[Configurações necessárias](https://laravel.com/docs/5.5/installation#server-requirements)


## Como executar 
Clone o projeto 

Antes de configurar a aplicação necessário ter uma instância do banco de dados preparada 

## Banco de dados
### Usando Docker  
[Docker Get Started ](https://www.docker.com/get-started)

O comando abaixo irá criar e executar um container com o postgreSQL

````bash
$ docker run --name dotse_challenge_dev -e POSTGRES_PASSWORD=dotse -e POSTGRES_DB=dotse_challenge -p 5432:5432 -d -t postgres
````
### Info de acesso do banco de dados

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dotse_challenge
DB_USERNAME=postgres
DB_PASSWORD=dotse
```

## Sem o Docker
[Download](https://www.postgresql.org/download/)


## Configurando a aplicação 

Entre no diretório da aplicação e execute os comandos abaixo

```bash
$ composer install
$ php artisan key:generate

# migration 
$ php artisan migrate

# seeders de usuários e tarefas 
$ php artisan db:seed

# seeder do usuário administrador dotse
$ php artisan db:seed --class=UserAdminSeeder
```

## Servidor para execução do projeto
Para macOs uma alternativa é usar o [valet](https://laravel.com/docs/5.5/valet#introduction)

para os demais casos execute o comando ```$ php artisan serve```  

## Usuários de acesso ao sistema

```

email: admin@dotse.com
senha: 123456

email: a@a.com
senha: password
```

## Outros comandos uteis

````bash
# irá executar a migration e seed do zero, limpa a base por completo - (Não executar esse comando em um ambiente de produção)
$ php artisan migrate:refresh --seed
````
