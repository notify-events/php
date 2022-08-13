# Available Functions


## Message
#### Message object creating

```php
public function __construct ( ?string $content = '', ?string $title = '', ?string $priority = Message::PRIORITY_NORMAL, ?string $level = Message::LEVEL_INFO )
```
| Param         | Type   | Required | Description                                                         |
|---------------|--------|----------|---------------------------------------------------------------------|
| **$content**  | String | No       | Message text                                                        |
| **$title**    | String | No       | Message title                                                       |
| **$priority** | String | No       | Priority. Available values are listed in the `setPriority` function |
| **$level**    | String | No       | Level. Available values are listed in the `setLevel` function       |

## setTitle
#### Set message title

```php
public function setTitle ( string $title ): $this
```
| Param      | Type   | Required | Description   |
|------------|--------|----------|---------------|
| **$title** | String | Yes      | Message title |

## getTitle
#### Get message title

```php
public function getTitle (): string
```


## setContent
#### Set message text
For recipients that do not support HTML, these tags will be ignored.
```php
public function setContent ( string $content ): $this
```
| Param        | Type   | Required | Description                                                            |
|--------------|--------|----------|------------------------------------------------------------------------|
| **$content** | String | Yes      | Message text. Available HTML tags: `<b>`, `<i>`, `<a href="">`, `<br>` |

## getContent
#### Get message text

```php
public function getContent (): string
```


## setPriority
#### Define message priority
For recipients which supports priority, the message will be highlighted accordingly.

```php
public function setPriority ( string $priority ): $this
```
| Param         | Type   | Required | Description      |
|---------------|--------|----------|------------------|
| **$priority** | String | Yes      | Message priority |

Available values:
```php
Message::PRIORITY_LOWEST
Message::PRIORITY_LOW
Message::PRIORITY_NORMAL
Message::PRIORITY_HIGH
Message::PRIORITY_HIGHEST 
```


## getPriority
#### Get message priority

```php
public function getPriority (): string
```


## setLevel
#### Define message level
For recipients which have differences in the display of messages at different levels, this level will be applied.

```php
public function setLevel ( string $level ): $this
```
| Param      | Type   | Required | Description   |
|------------|--------|----------|---------------|
| **$level** | String | Yes      | Message level |

Available values:
```php
Message::LEVEL_VERBOSE
Message::LEVEL_INFO
Message::LEVEL_NOTICE
Message::LEVEL_WARNING
Message::LEVEL_ERROR
Message::LEVEL_SUCCESS
```


## getLevel
#### Get message level

```php
public function getLevel (): string
```


## addFile
#### Attach local file

```php
public function addFile ( string $filePath, ?string $mimeType = null, ?string $fileName = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$filePath** | String | Yes      | Local file path         |
| **$mimeType** | String | No       | File MimeType           |
| **$fileName** | String | No       | File name and extension |

## addFileFromContent
#### Attach file by content

```php
public function addFileFromContent ( string $content, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$content**  | String | Yes      | File content            |
| **$fileName** | String | No       | File name and extension |
| **$mimeType** | String | No       | File MimeType           |

## addFileFromUrl
#### Attach remote file

```php
public function addFileFromUrl ( string $url, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$url**      | String | Yes      | Remote file path        |
| **$fileName** | String | No       | File name and extension |
| **$mimeType** | String | No       | File MimeType           |

## addImage
#### Attach local image

```php
public function addImage ( string $filePath, ?string $mimeType = null, ?string $fileName = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$filePath** | String | Yes      | Local file path         |
| **$mimeType** | String | No       | File MimeType           |
| **$fileName** | String | No       | File name and extension |

## addImageFromContent
#### Attach image by content

```php
public function addImageFromContent ( string $content, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$content**  | String | Yes      | File content            |
| **$fileName** | String | No       | File name and extension |
| **$mimeType** | String | No       | File MimeType           |

## addImageFromUrl
#### Attach remote image

```php
public function addImageFromUrl ( string $url, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Param         | Type   | Required | Description             |
|---------------|--------|----------|-------------------------|
| **$url**      | String | Yes      | Remote file path        |
| **$fileName** | String | No       | File name and extension |
| **$mimeType** | String | No       | File MimeType           |


## addAction
#### Attach action with callback

```php
public function addAction ( string $name, string $title, ?string $callback_url = null, string $callback_method = 'get', array $callback_headers = [], string $callback_content = '' )
```

| Param                 | Type   | Required | Description                                     |
|-----------------------|--------|----------|-------------------------------------------------|
| **$name**             | String | Yes      | Action name                                     |
| **$title**            | String | Yes      | Action (button) title                           |
| **$callback_url**     | String | No       | Callback URL                                    |
| **$callback_method**  | String | No       | Callback method                                 |
| **$callback_headers** | Array  | No       | Callback headers (key: value)                   |
| **$callback_content** | String | No       | Callback content (for POST, PUT, PATCH methods) |

Available values for $callback_method:
```php
Message::CALLBACK_METHOD_HRAD   - HEAD
Message::CALLBACK_METHOD_GET    - GET
Message::CALLBACK_METHOD_POST   - POST
Message::CALLBACK_METHOD_PUT    - PUT
Message::CALLBACK_METHOD_PATCH  - PATCH
Message::CALLBACK_METHOD_DELETE - DELETE
```

## send
#### Send the message

You can get the source token when connecting the PHP source to your channel on the [Notify.Events](https://notify.events) service side.

```php
public function send ( string $token )
```
| Param      | Type   | Required | Description  |
|------------|--------|----------|--------------|
| **$token** | String | Yes      | Source token |
