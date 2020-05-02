# Available Functions

## Message object creating

```php
$message = new Message('<b>Important</b> messasge text', 'Title');
```

You can specify the values of ``Priority`` and ``Level`` of your message as third and fourth optional parameters.

## Setting parameters

#### Message title
Use `setTitle` function to define the message title. 
```php
$message->setTitle('Title');
```

#### Message content
Use `setContent` function to define the message content.

You can also use `<b>`, `<i>`, `<a>`, `<br>` HTML tags to format the message.
```php
$message->setContent('<b>Important</b> messasge text');
```

#### Priority
Use `setPriority` function to define the message priority.
```php
$message->setPriority(Message::PRIORITY_NORMAL);
```

List of possible values:
```php
Message::PRIORITY_LOWEST
Message::PRIORITY_LOW
Message::PRIORITY_NORMAL
Message::PRIORITY_HIGH
Message::PRIORITY_HIGHEST 
```

#### Level
Use `setLevel` function to define the message level.
```php
$message->setLevel(Message::LEVEL_SUCCESS);
```

List of possible values:
```php
Message::LEVEL_VERBOSE
Message::LEVEL_INFO
Message::LEVEL_NOTICE
Message::LEVEL_WARNING
Message::LEVEL_ERROR
Message::LEVEL_SUCCESS
```

#### File attachment
There are several ways to attach a file:
```php
// As a local file attachment
$message->addFile('path\to\local\file');
```

```php
// As binary content
$message->addFileFromContent('binary_file_content');
```

```php
// As an attachment file located at the specified URL
$message->addFileFromUrl('https://some.file.source/very_important.doc');
```

In each method you can specify the the ``Name`` and ``MimeType`` of the attached file as second and third optional parameters.

#### Image attachment
There are several ways to attach an image:
```php
// As a local file attachment
$message->addImage('path\to\local\file');
```

```php
// As binary content
$message->addImageFromContent('binary_file_content');
```

```php
// As an attachment file located at the specified URL
$message->addImageFromUrl('https://some.image.source/very_lazy_cat.jpg');
```

In each method you can specify the the ``Name`` and ``MimeType`` of the attached file as second and third optional parameters.

## Getting parameters

#### Message title
Use the `getTitle` function to get the defined message title.
```php
$title = $message->getTitle();
```

#### Message content
Use the `getContent` function to get the defined message content.
```php
$content = $message->getContent();
```

#### Priority
Use the `getPriority` function to get the defined message priority.
```php
$priority = $message->getPriority();
```

#### Level
Use the `getLevel` function to get the defined message level.
```php
$level = $message->getLevel();
```

## Message sending
Use the `send` function to send the message.

The function requires the channel token that you received when creating the channel on the [Notify.Events](https://notify.events) service side.

```php
$message->send('XXXXXXXX');
```