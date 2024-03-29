# Доступные функции


## Message
#### Создать объект сообщения

```php
public function __construct ( ?string $content = '', ?string $title = '', ?string $priority = Message::PRIORITY_NORMAL, ?string $level = Message::LEVEL_INFO )
```
| Параметр      | Тип    | Обязательный | Описание                                                       |
|---------------|--------|--------------|----------------------------------------------------------------|
| **$content**  | String | Нет          | Текст сообщения                                                |
| **$title**    | String | Нет          | Заголовок сообщения                                            |
| **$priority** | String | Нет          | Приоритет. Допустимые значения описаны в функции `setPriority` |
| **$level**    | String | Нет          | Уровень. Допустимые значения описаны в функции `setLevel`      |

## setTitle
#### Задать заголовок сообщения

```php
public function setTitle ( string $title ): $this
```
| Параметр   | Тип    | Обязательный | Описание            |
|------------|--------|--------------|---------------------|
| **$title** | String | Да           | Заголовок сообщения |

## getTitle
#### Получить установленный заголовок сообщения

```php
public function getTitle (): string
```


## setContent
#### Задать текст сообщения
Для получателей, которые не поддерживают отображение HTML, теги будут игнорироваться.
```php
public function setContent ( string $content ): $this
```
| Параметр     | Тип    | Обязательный | Описание                                                                   |
|--------------|--------|--------------|----------------------------------------------------------------------------|
| **$content** | String | Да           | Текст сообщения. Допустимые HTML-теги: `<b>`, `<i>`, `<a href="">`, `<br>` |

## getContent
#### Получить установленный текст сообщения

```php
public function getContent (): string
```


## setPriority
#### Установить приоритет сообщения
Для получателей, которые имеют поддержку приоритезации, сообщение будет выделено соответствующим образом.

```php
public function setPriority ( string $priority ): $this
```
| Параметр      | Тип    | Обязательный | Описание            |
|---------------|--------|--------------|---------------------|
| **$priority** | String | Да           | Приоритет сообщения |

Список возможных значений:
```php
Message::PRIORITY_LOWEST  - Незначительный
Message::PRIORITY_LOW     - Низкий
Message::PRIORITY_NORMAL  - Нормальный
Message::PRIORITY_HIGH    - Высокий
Message::PRIORITY_HIGHEST - Критичный 
```


## getPriority
#### Получить установленный приоритет сообщения

```php
public function getPriority (): string
```


## setLevel
#### Установить уровень сообщения
Для получателей, которые имеют различия в отображении разных уровней сообщений, будет учитываться установленный уровень.

```php
public function setLevel ( string $level ): $this
```
| Параметр   | Тип    | Обязательный | Описание          |
|------------|--------|--------------|-------------------|
| **$level** | String | Да           | Уровень сообщения |

Список возможных значений:
```php
Message::LEVEL_VERBOSE - Подробный
Message::LEVEL_INFO    - Информация
Message::LEVEL_NOTICE  - Уведомление
Message::LEVEL_WARNING - Предупреждение
Message::LEVEL_ERROR   - Ошибка
Message::LEVEL_SUCCESS - Успешно
```


## getLevel
#### Получить установленный уровень сообщения

```php
public function getLevel (): string
```


## addFile
#### Прикрепить локальный файл

```php
public function addFile ( string $filePath, ?string $mimeType = null, ?string $fileName = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$filePath** | String | Да           | Путь к локальному файлу      |
| **$mimeType** | String | Нет          | MimeType файла               |
| **$fileName** | String | Нет          | Название файла с расширением |

## addFileFromContent
#### Прикрепить файл, передав его содержимое

```php
public function addFileFromContent ( string $content, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$content**  | String | Да           | Содержимое файла             |
| **$fileName** | String | Нет          | Название файла с расширением |
| **$mimeType** | String | Нет          | MimeType файла               |

## addFileFromUrl
#### Прикрепить файл, расположенный по указанному URL

```php
public function addFileFromUrl ( string $url, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$url**      | String | Да           | Путь к удалённому файлу      |
| **$fileName** | String | Нет          | Название файла с расширением |
| **$mimeType** | String | Нет          | MimeType файла               |

## addImage
#### Прикрепить локальное изображение

```php
public function addImage ( string $filePath, ?string $mimeType = null, ?string $fileName = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$filePath** | String | Да           | Путь к локальному файлу      |
| **$mimeType** | String | Нет          | MimeType файла               |
| **$fileName** | String | Нет          | Название файла с расширением |

## addImageFromContent
#### Прикрепить изображение, передав его содержимое

```php
public function addImageFromContent ( string $content, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$content**  | String | Да           | Содержимое файла             |
| **$fileName** | String | Нет          | Название файла с расширением |
| **$mimeType** | String | Нет          | MimeType файла               |

## addImageFromUrl
#### Прикрепить файл, расположенный по указанному URL

```php
public function addImageFromUrl ( string $url, ?string $fileName = null, ?string $mimeType = null ): $this
```
| Параметр      | Тип    | Обязательный | Описание                     |
|---------------|--------|--------------|------------------------------|
| **$url**      | String | Да           | Путь к удалённому файлу      |
| **$fileName** | String | Нет          | Название файла с расширением |
| **$mimeType** | String | Нет          | MimeType файла               |

## addAction
#### Добавить действие с обратным вызовом

```php
public function addAction ( string $name, string $title, ?string $callback_url = null, string $callback_method = 'get', array $callback_headers = [], string $callback_content = '' )
```
 
| Параметр              | Тип    | Обязательный | Описание                                                    |
|-----------------------|--------|--------------|-------------------------------------------------------------|
| **$name**             | String | Да           | Имя действия                                                |
| **$title**            | String | Да           | Название действия (кнопки)                                  |
| **$callback_url**     | String | Нет          | URL Обратного вызова                                        |
| **$callback_method**  | String | Нет          | Метод обратного вызова                                      |
| **$callback_headers** | Array  | Нет          | Заголовки обратного вызова (key: value)                     |
| **$callback_content** | String | Нет          | Содержание обратного вызова (для POST, PUT, PATCH запросов) |

Список возможных значений для $callback_method:
```php
Message::CALLBACK_METHOD_HRAD   - HEAD
Message::CALLBACK_METHOD_GET    - GET
Message::CALLBACK_METHOD_POST   - POST
Message::CALLBACK_METHOD_PUT    - PUT
Message::CALLBACK_METHOD_PATCH  - PATCH
Message::CALLBACK_METHOD_DELETE - DELETE
```

## send
#### Отправить сообщение

Токен источника вы можете получить при поключении источника PHP на ваш канал на стороне сервиса [Notify.Events](https://notify.events).

```php
public function send ( string $token )
```
| Параметр   | Тип    | Обязательный | Описание        |
|------------|--------|--------------|-----------------|
| **$token** | String | Да           | Токен источника |
