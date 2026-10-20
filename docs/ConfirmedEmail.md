# ConfirmedEmail

[До списку розділів](../README.md)

Керування email-адресами, підтвердженими для надсилання із sandbox-домену. Методи доступні лише з API-ключем основного облікового запису.

PHP: `AllyMailer\Api\ConfirmedEmail\ConfirmedEmailApi`, `$client->confirmedEmail()`

| Метод | Ендпоінт | Опис |
|---|---|---|
| [`create()`](#create) | `POST /confirmed-email/create.json` | Adds an email address and sends a confirmation link. |
| [`list()`](#list) | `POST /confirmed-email/list.json` | Lists confirmed and unconfirmed email addresses for the account. |
| [`delete()`](#delete) | `POST /confirmed-email/delete.json` | Deletes an email address from the account's confirmed email list. |

## create

`POST /confirmed-email/create.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-create)

Adds an email address and sends a confirmation link.

### Запит: `ConfirmedEmailRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `email` | `string` | так | Email address to add or delete. |

### Відповідь: `ConfirmedEmailCreateResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `confirmed_email` | `ConfirmedEmail` |  |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->confirmedEmail()->create(new ConfirmedEmailRequest('dev@example.com'));
    var_dump($response->getConfirmedEmail());
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## list

`POST /confirmed-email/list.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-list)

Lists confirmed and unconfirmed email addresses for the account.

### Запит

Метод не має параметрів.

### Відповідь: `ConfirmedEmailListResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `confirmed_emails` | `list<ConfirmedEmail>` |  |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->confirmedEmail()->list();
    var_dump($response->getConfirmedEmails());
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## delete

`POST /confirmed-email/delete.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-delete)

Deletes an email address from the account's confirmed email list.

### Запит: `ConfirmedEmailRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `email` | `string` | так | Email address to add or delete. |

### Відповідь: `ConfirmedEmailDeleteResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `message` | `string` |  |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->confirmedEmail()->delete(new ConfirmedEmailRequest('dev@example.com'));
    echo $response->getMessage(), PHP_EOL;
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```
