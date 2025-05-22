# Projeto de Leads JA

## Init Projeto

```bash
composer install
npm install
```

## Banco de Dados

```.env
DATABASE_URL="mysql://user:senha@127.0.0.1:3306/database?serverVersion=8.0.32&charset=utf8mb4"
```

### Instruções de Configuração

user = "nome de usuário"\
senha = "senha do usuário"\
database = "nome do banco de dados"


### Comando para criar o banco de dados

```bash
php bin/console doctrine:database:create
```

### Comando para criar as tabelas

```bash
php bin/console make:migration
```

### Comando para Carregar as tabelas

```bash
php bin/console doctrine:migrations:migrate
```

### Comando para criar o usuário root

```bash
php bin/console doctrine:fixtures:load
```

## Iniciar Servidor

```bash
symfony serve
```