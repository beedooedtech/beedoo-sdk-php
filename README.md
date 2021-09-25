<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://www.beedoo.com.br/wp-content/uploads/2019/09/LOGO-BEEDOO-EDTECH-WHITE.png" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sobre Beedoo SDK

Acessar documentação completa da [Beedoo API](http://document-api.beedoo.io.s3-website-us-east-1.amazonaws.com).

A API é organizada seguindo a arquitetura REST, boas práticas, convenções e padrões como json:api e JSend. Nossa API tem URLs orientadas a recursos, retorna respostas em JSON e usa códigos de resposta HTTP padrão, autenticação e verbos.

Esse SDK em PHP foi desenvolvido no intuito de tornar mais prático a integração com nossa API.

Bom desenvolvimento! 😉

# Índice

- [Instalação](#instalação)
- [Configuração](#configuração)
- [BeeHub API](#beehub-api)
  - [Wiki](#beehub-wiki)
  - [User](#beehub-user)
- [Beedoo API](#beedoo-api)
  - [Groups](#groups)
  - [Wiki](#beedoo-wiki)
  - [Team](#team)
  - [Upload](#upload)
  - [Visual Identity](#visual-identity)
  - [Auth](#auth)
  - [User](#beedoo-user)
    - [Cadastrar novo usuário](#cadastrar-novo-usuário)
    - [Atualizar novo usuário](#atualizar-usuário)

# Instalação

Instale a biblioteca utilizando o comando:

`composer require beedooedtech/beedoo-sdk-php`

## Configuração

Para incluir a biblioteca em seu projeto, basta fazer o seguinte:

```php
<?php

require __DIR__ . "/vendor/autoload.php"

$beedoo = new Beedoo\Client("SECRET_KEY");
```

# BeeHub API

## BeeHub Wiki

```php
<?php

```

## BeeHub User

### Cadastrar novo usuário

```php
<?php

/** Campos obrigatórios */

$userData = [
  "username" => "jhonsnow",
  "name" => "Jhon Snow",
  "login" => "jhonsnow",
  "password" => "123mudar",
  "status" => "Ativo",
  "typeUser" => "Usuário",
  "permission" => "Usuario",
  "groups" => "geral"
];

$user = $beedoo->user()->create($userData);

```

### Atualizar usuário

```php
<?php

$userData = [
  "username" => "jhonsnow",
  "name" => "Jhon Snow",
  "login" => "jhonsnow",
  "email" => "jhonsnow@gmail.com",
  "password" => "123mudar",
  "status" => "Ativo",
  "typeUser" => "Usuário",
  "permission" => "Usuario",
  "groups" => "geral, grupo_pela_api",
  "cpf_cnpj" => 46312127800,
  "dashboard" => [
    "agent_id" => 22032,
    "template" => "Template DEV"
  ],
  "hierarchy" => [
    "leader" => 77202,
    "level" => "Gerente" 
  ],
  "language" => "pt-BR",
  "leader" => true,
  "mention_feed" => false,
  "entrytime" => "18:45:00",
  "exittime" => "23:15:00",
  "customfields" => [
    "Login-SSO" => "jhonsnow",
    "Complementar Numero" => 12345
  ]
];

$user = $beedoo->user()->update($userData);

```

# Beedoo API

## Groups

```php
<?php

```

## Beedoo Wiki

```php
<?php

```

## Team

```php
<?php

```

## Upload

```php
<?php

```

## Visual Identity

```php
<?php

```

## Auth

```php
<?php

```

## Beedoo User

```php
<?php

```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
