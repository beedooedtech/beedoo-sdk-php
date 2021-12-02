<p align="center"><a href="http://document-api.beedoo.io.s3-website-us-east-1.amazonaws.com/" target="_blank"><img src="https://www.beedoo.com.br/wp-content/uploads/2019/09/LOGO-BEEDOO-EDTECH-WHITE.png" width="400"></a></p>

<!-- <p align="center">
<a href="https://packagist.org/packages/beedooedtech/beedoo-sdk-php"><img src="https://img.shields.io/packagist/dt/beedooedtech/beedoo-sdk-php" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/beedooedtech/beedoo-sdk-php"><img src="https://img.shields.io/packagist/v/beedooedtech/beedoo-sdk-php" alt="Latest Stable Version"></a>
</p> -->

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
    - [Consultar artigos na Wiki](#consultar-artigos-na-wiki)
  - [User](#beehub-user)
    - [Access Token](#access-token)
- [Beedoo API](#beedoo-api)
  - [Groups](#groups)
    - [Consultar grupos](#consultar-grupos)
  - [Wiki](#beedoo-wiki)
    - [Retorna se um determinado artigo foi lido](#retorna-se-um-determinado-artigo-lido)
    - [Marca um artigo como lido](#marca-um-artigo-como-lido)
  - [Team](#team)
    - [Retornar os avatares do time](#retornar-os-avatares-do-time)
  - [Upload](#upload)
    - [Retornar uma URL pre assinada para upload de arquivos para o S3](#retornar-uma-URL-pre-assinada-para-upload-de-arquivos-para-o-S3)
  - [Visual Identity](#visual-identity)
    - [Retornar a identidade visual do time](#retornar-a-identidade-visual-do-time)
  - [User](#beedoo-user)
    - [Cadastrar novo usuário](#cadastrar-novo-usuário)
    - [Atualizar novo usuário](#atualizar-usuário)

# Instalação

Instale a biblioteca utilizando o comando:

```shell
composer require beedooedtech/beedoo-sdk-php
```

## Configuração

Para incluir a biblioteca em seu projeto, basta fazer o seguinte:

```php
<?php

require __DIR__ . "/vendor/autoload.php"

$beedoo = new Beedoo\Client("SECRET_KEY");
```

# BeeHub API

## BeeHub Wiki

### Consultar artigos na Wiki

```php
<?php

$params = [
  "question" => "assunto_a_ser_pesquisado",
  "category" => 1,
  "tag" => 5,
  "offset" => 20,
  "limit" => 20,
];

$groups = $beedoo->groups()->get($params);

```

## BeeHub User

### Access Token

```php
<?php

$payloadAuth = [
    "clientId" => "n6XSN0o6FDQZQ4lmxb7P2"
];

$accessToken = $beedoo->accessToken()->get($payloadAuth);

```

# Beedoo API

## Groups

### Consultar grupos

```php
<?php

$params = [
  "id" => 1,
  "name" => "nome_do_grupo",
  "offset" => 5,
  "limit" => 20,
];

$groups = $beedoo->groups()->get($params);

```

## Beedoo Wiki

### Retorna se um determinado artigo foi lido

```php
<?php

$article = [
  'id' => 279
];

$beedoo = $beedoo->wiki()->getIsReadArticle($article);

```

### Marca um artigo como lido

```php
<?php

$article = [
  'id' => 279
];

$beedoo = $beedoo->wiki()->saveArticleRead($article);

```

## Team

### Retornar os avatares do time

```php
<?php

$beedoo = $beedoo->team()->getAvatar();

```

## Upload

### Retornar uma URL pre assinada para upload de arquivos para o S3

```php
<?php

$beedoo = $beedoo->upload()->getUrl();

```

## Visual Identity

### Retornar a identidade visual do time

```php
<?php

$beedoo = $beedoo->visualIdentity()->get();

```

## Beedoo User

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
BeeTalk