# Template

[До списку розділів](../README.md)

Ви можете зберегти шаблон на боці AllyMailer і потім посилатися на нього за ідентифікатором. Це не обов'язково, але вкрай рекомендовано у разі повторюваних email-повідомлень або за великих обсягів надсилання. AllyMailer підтримує два різні синтаксиси для шаблонів, докладніше читайте [тут](https://docs.allymailer.com.ua/ua/template-engines).

PHP: `AllyMailer\Api\Template\TemplateApi`, `$client->template()`

| Метод | Ендпоінт | Опис |
|---|---|---|
| [`set()`](#set) | `POST /template/set.json` | Створити або оновити шаблон. |
| [`get()`](#get) | `POST /template/get.json` | Повертає властивості шаблону за його ідентифікатором. |
| [`list()`](#list) | `POST /template/list.json` | Повертає повний список або частину списку всіх шаблонів. |
| [`delete()`](#delete) | `POST /template/delete.json` | Видаляє шаблон за ідентифікатором. |

## set

`POST /template/set.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#template-set)

Створити або оновити шаблон.

Обмеження:
* Максимальний розмір запиту — 10 MB.
* Кількість шаблонів обмежено 10000.

### Запит: `TemplateSetRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `template` | `TemplateObject` | так | Об'єкт, що містить властивості шаблону. |

### Відповідь: `TemplateSetResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `template` | `TemplateObject` | Об'єкт, що містить властивості шаблону. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Template\Model\EditorType;
use AllyMailer\Api\Template\Model\TemplateObject;
use AllyMailer\Api\Template\Model\TemplateSetRequest;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\TemplateEngine;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->template()->set(new TemplateSetRequest(
        template: new TemplateObject(
            name: 'name',
            editorType: EditorType::Html,
            templateEngine: TemplateEngine::Velocity,
            subject: 'AllyMailer test email ',
            fromEmail: 'user@example.com',
            fromName: 'John Smith',
            replyTo: 'email@example.com',
            replyToName: 'John Smith',
        ),
    ));
    var_dump($response->template);
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## get

`POST /template/get.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#template-get)

Повертає властивості шаблону за його ідентифікатором.

### Запит: `TemplateGetRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `id` | `string` | так | Ідентифікатор шаблону. |

### Відповідь: `TemplateGetResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `template` | `TemplateObject` | Об'єкт, що містить властивості шаблону. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Template\Model\TemplateGetRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->template()->get(new TemplateGetRequest(
        id: '00000000-0000-0000-0000-000000000000',
    ));
    var_dump($response->template);
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## list

`POST /template/list.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#template-list)

Повертає повний список або частину списку всіх шаблонів.

Ви можете переглядати великий список частинами, використовуючи параметри "offset" і "limit". Якщо повернуто менше ніж "limit" шаблонів — значить, ви досягли кінця списку.

### Запит: `TemplateListRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `limit` | `int` |  | Максимальна кількість шаблонів, що повертаються, за замовчуванням 50. |
| `offset` | `int` |  | Індекс першого шаблону зі списку, що повертається, рахуючи з нуля. |

### Відповідь: `TemplateListResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `templates` | `list<TemplateListObject>` | Масив об'єктів-шаблонів. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Template\Model\TemplateListRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->template()->list(new TemplateListRequest());
    var_dump($response->templates);
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## delete

`POST /template/delete.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#template-delete)

Видаляє шаблон за ідентифікатором.

### Запит: `TemplateDeleteRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `id` | `string` | так | Ідентифікатор шаблону. |

### Відповідь: `SuccessResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Template\Model\TemplateDeleteRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->template()->delete(new TemplateDeleteRequest(
        id: '00000000-0000-0000-0000-000000000000',
    ));
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```
