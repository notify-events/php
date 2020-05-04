# PHP client for Notify.Events

A simple PHP extension that simplifies the process of integrating your project with the [Notify.Events](https://notify.events) service to send messages to your channels.

#### Instruction on another languages

- [Русский](/docs/ru-RU/README.md)

# Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist notify-events/php
```

or add

```
"notify-events/php": "~1.0"
```

to the require section of your composer.json.

# Usage

To use this extension, you need to import the Message class into your PHP script.

If you used composer for installation, it will be enough to include the autoload.php file:

```php
require_once "vendor/autoload.php";
```

Otherwise, if you added the extension manually, you need to import the Message class by yourself:

```php
require_once "path/to/notify-events/php/Message.php";
```

After that, you can create a message object, set the necessary parameters and send the message to the channel.

### Usage example

```php
<?php
    require_once "vendor/autoload.php";
    
    // Defining channel token.
    // You get this token when creating a channel on the Notify.Events service.
    $myChannelToken = 'XXXXXXXX';
    
    // Create a message object.
    $message = new Message('Some <b>important</b> message', 'Title', Message::PRIORITY_HIGH, Message::LEVEL_ERROR);

    // Attach the file to the message.
    $message->addFile('path\to\local\file');
    
    // Send a message to your channel in Notify.Events.
    $message->send($myChannelToken);
?>
```

[List of all available functions](/docs/en-US/Message.md)