# PHP клиент для Notify.Events

Простая PHP-библиотека, которая призвана упростить процесс интеграции сервиса [Notify.Events](https://notify.events) в ваш проект,  с целью отправки сообщений в созданный канал.

#### Инстрации на других языках

- [English](/README.md)

# Установка

Рекомендуется производить установку библиотеки через пакетный менеджер [composer](http://getcomposer.org/download/).

Для этого, либо запустите

```
php composer.phar require --prefer-dist notify-events/php
```

либо добавьте

```
"notify-events/php": "dev-master"
```

в секцию require вашего composer.json файла. 

# Использование

Для использования этой библиотеки, вам необходимо подключить класс Message в ваш PHP-скрипт.

Если для установки вы использовали composer, будет достаточно подключить файл autoload.php:

```php
require_once "vendor/autoload.php";
```

В случае, если библиотеку вы добавляли вручную, вам необходимо импортировать класс Message самостоятельно: 

```php
require_once "path/to/notify-events/php/Message.php";
```

После этого вы можете создать объект сообщения, установить необходимые параметры и отправить сообщение в канал.

### Пример использования

```php
<?php
    require_once "vendor/autoload.php";
    
    // Определяем токен канала.
    // Этот токен вы получаете при создании канала на сервисе Notify.Events.
    $myChannelToken = 'XXXXXXXX';
    
    // Создаём объект сообщения.
    $message = new Message('Some <b>important</b> message', 'Title', Message::PRIORITY_HIGH, Message::LEVEL_ERROR);
    
    // Прикрепляем файл к сообщению.
    $message->addFile('path\to\local\file');
    
    // Отправляем сообщение на свой канал в Notify.Events.
    $message->send($myChannelToken);
?>
```

[Список и описание всех доступных функций](/docs/ru-RU/functions.md)