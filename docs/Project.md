# Project

[До списку розділів](../README.md)

Проєкти дозволяють об'єднати кілька незалежних доменів із webhook, шаблонами та списками відписки. Це дуже корисно, якщо у вас є власні клієнти і ви керуєте їхніми даними з одного облікового запису AllyMailer. Кожен проєкт отримує власний ключ API, а виклики методів API з цим ключем обробляють лише дані цього проєкту. Таким чином, ви можете призначити окремий проєкт для кожного користувача і бути впевненими, що вони не конфліктуватимуть: наприклад, відписка від одного проєкту не вплине на інший.

Методи проєктів за замовчуванням вимкнено через заходи захисту від спаму. Щоб їх увімкнути, вам необхідно звернутися до [служби підтримки](https://cp.allymailer.com/ua/support).

Зверніть увагу: за замовчуванням домени для надсилання підтверджуються та використовуються незалежно для основного облікового запису й кожного з проєктів. Але є можливість увімкнути для проєктів використання доменів, підтверджених в основному обліковому записі. Просто попросіть про це [техпідтримку](https://cp.allymailer.com/ua/support).

PHP: `AllyMailer\Api\Project\ProjectApi`, `$client->project()`

| Метод | Ендпоінт | Опис |
|---|---|---|
| [`create()`](#create) | `POST /project/create.json` | Створити новий проєкт. |
| [`update()`](#update) | `POST /project/update.json` | Змінити властивості проєкту. |
| [`list()`](#list) | `POST /project/list.json` | Повертає список проєктів. |
| [`delete()`](#delete) | `POST /project/delete.json` | Видалити проєкт. |

## create

`POST /project/create.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#project-create)

Створити новий проєкт.

### Запит: `ProjectCreateRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `project` | `ProjectObject` | так | Об'єкт із властивостями проєкту. |

### Відповідь: `ProjectCreateResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `project_id` | `string` | Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки. |
| `project_api_key` | `string` | API-ключ проєкту. Ви можете використовувати цей ключ замість користувацького api_key у всіх методах, крім project-методів. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Project\Model\ProjectCreateRequest;
use AllyMailer\Api\Project\Model\ProjectObject;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->project()->create(new ProjectCreateRequest(
        (new ProjectObject('Project 1A'))
            ->setCountry('ES')
            ->setBackendDomainId(1234)
            ->setUnsubscribePageId(1)
    ));
    echo $response->getProjectId(), PHP_EOL;
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## update

`POST /project/update.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#project-update)

Змінити властивості проєкту.

### Запит: `ProjectUpdateRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `project_id` | `string` |  | Ідентифікатор проєкту, що оновлюється. Проєкт має бути ідентифіковано або цим полем project_id, або полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше. |
| `project_api_key` | `string` |  | Необов'язковий API-ключ проєкту, що оновлюється. Проєкт має бути ідентифіковано або полем project_id, або полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше. |
| `project` | `ProjectUpdateObject` | так | Об'єкт із властивостями проєкту. |

### Відповідь: `ProjectUpdateResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `project_api_key` | `string` | API-ключ проєкту. Повертається лише в разі, якщо в параметрі запиту був project_api_key. Якщо ж проєкт було ідентифіковано через project_id, то не повертається. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Project\Model\ProjectUpdateObject;
use AllyMailer\Api\Project\Model\ProjectUpdateRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->project()->update((new ProjectUpdateRequest(
        (new ProjectUpdateObject('Project 1A'))
            ->setCountry('ES')
            ->setBackendDomainId(1234)
            ->setUnsubscribePageId(1)
    ))
        ->setProjectId('1234567890')
        ->setProjectApiKey('your api_key'));
    echo $response->getProjectApiKey(), PHP_EOL;
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## list

`POST /project/list.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#project-list)

Повертає список проєктів.

### Запит: `ProjectListRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `project_id` | `string` |  | Опціональна можливість указати project_id для включення до списку лише вказаного проєкту. |
| `project_api_key` | `string` |  | Опціональна можливість указати project_api_key для включення до списку лише вказаного проєкту. |

### Відповідь: `ProjectListResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `projects` | `list<ProjectListObject>` | Масив об'єктів, де кожен об'єкт відповідає окремому проєкту. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Project\Model\ProjectListRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->project()->list((new ProjectListRequest())
        ->setProjectId('1234567890')
        ->setProjectApiKey('your api_key'));
    var_dump($response->getProjects());
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## delete

`POST /project/delete.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#project-delete)

Видалити проєкт.

Деякий час проєкт не видаляється остаточно, і його ще можна відновити — для цього необхідно звернутися в техпідтримку.

### Запит: `ProjectDeleteRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `project_id` | `string` |  | Ідентифікатор проєкту, що видаляється. Проєкт має бути ідентифіковано або цим полем project_id, або полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше. |
| `project_api_key` | `string` |  | Необов'язковий API-ключ проєкту, що видаляється. Проєкт має бути ідентифіковано або полем project_id, або полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше. |

### Відповідь: `SuccessResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Project\Model\ProjectDeleteRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->project()->delete((new ProjectDeleteRequest())
        ->setProjectId('1234567890')
        ->setProjectApiKey('your api_key'));
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```
