# Tag

[До списку розділів](../README.md)

Методи керування користувацькими мітками. За допомогою міток ви можете класифікувати листи за потрібними критеріями. Відокремити маркетингові листи від транзакційних або листи з підтвердженням реєстрації від сповіщень про замовлення. AllyMailer дозволяє позначати мітками кожне вихідне повідомлення, а потім сегментувати й аналізувати статистику на основі зазначених під час надсилання міток.

PHP: `AllyMailer\Api\Tag\TagApi`, `$client->tag()`

| Метод | Ендпоінт | Опис |
|---|---|---|
| [`list()`](#list) | `POST /tag/list.json` | Метод без параметрів, повертає список усіх користувацьких міток. |
| [`delete()`](#delete) | `POST /tag/delete.json` | Видаляє мітку. |

## list

`POST /tag/list.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#tag-list)

Метод без параметрів, повертає список усіх користувацьких міток.

### Запит

Метод не має параметрів.

### Відповідь: `TagListResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |
| `tags` | `list<TagsResponseObject>` | Масив об'єктів з даними користувацьких міток. |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->tag()->list();
    var_dump($response->tags);
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```

## delete

`POST /tag/delete.json` · [Документація](https://docs.allymailer.com.ua/ua/web-api-ref#tag-delete)

Видаляє мітку.

### Запит: `TagDeleteRequest`

| Поле | Тип | Обов'язкове | Опис |
|---|---|---|---|
| `tag_id` | `int` | так | Унікальний id мітки. |

### Відповідь: `SuccessResponse`

| Поле | Тип | Опис |
|---|---|---|
| `status` | `string` | Рядок "success". (`success`) |

### Приклад

```php
<?php

use AllyMailer\AllyMailer;
use AllyMailer\Api\Tag\Model\TagDeleteRequest;
use AllyMailer\Client\ApiException;

$client = AllyMailer::client('YOUR_API_KEY');

try {
    $response = $client->tag()->delete(new TagDeleteRequest(
        tagId: 54,
    ));
} catch (ApiException $e) {
    echo $e->getErrorCode(), ': ', $e->getMessage(), PHP_EOL;
}
```
