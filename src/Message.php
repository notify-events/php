<?php

namespace notify_events\php_send;

use GuzzleHttp\Client;
use InvalidArgumentException;

/**
 * Class Message
 * @package notify_events\php_send
 */
class Message
{
    const PRIORITY_LOWEST  = 'lowest';
    const PRIORITY_LOW     = 'low';
    const PRIORITY_NORMAL  = 'normal';
    const PRIORITY_HIGH    = 'high';
    const PRIORITY_HIGHEST = 'highest';

    const LEVEL_VERBOSE = 'verbose';
    const LEVEL_INFO    = 'info';
    const LEVEL_NOTICE  = 'notice';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR   = 'error';
    const LEVEL_SUCCESS = 'success';

    /** @var string */
    protected static $_baseUrl = 'https://notify.events/api/v1/channel/source/%s/execute';

    /** @var Client */
    protected static $_client;

    /** @var string */
    protected $_title;
    /** @var string */
    protected $_content;
    /** @var string */
    protected $_priority;
    /** @var string */
    protected $_level;

    /** @var array */
    protected $_files = [];

    /**
     * @return Client
     */
    protected static function getClient()
    {
        if (static::$_client) {
            static::$_client = new Client();
        }

        return static::$_client;
    }

    /**
     * Message constructor.
     * @param string $content
     * @param string $title
     * @param string $priority
     * @param string $level
     */
    public function __construct($content = '', $title = '', $priority = self::PRIORITY_NORMAL, $level = self::LEVEL_INFO)
    {
        $this
            ->setTitle($title)
            ->setContent($content)
            ->setPriority($priority)
            ->setLevel($level);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->_content = $content;

        return $this;
    }

    /**
     * @param string $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        if (!in_array($priority, [
            self::PRIORITY_LOWEST,
            self::PRIORITY_LOW,
            self::PRIORITY_NORMAL,
            self::PRIORITY_HIGH,
            self::PRIORITY_HIGHEST,
        ])) {
            throw new InvalidArgumentException('Invalid priority value');
        }

        $this->_priority = $priority;

        return $this;
    }

    /**
     * @param string $level
     * @return $this
     */
    public function setLevel($level)
    {
        if (!in_array($level, [
            self::LEVEL_VERBOSE,
            self::LEVEL_INFO,
            self::LEVEL_NOTICE,
            self::LEVEL_WARNING,
            self::LEVEL_ERROR,
            self::LEVEL_SUCCESS,
        ])) {
            throw new InvalidArgumentException('Invalid level value');
        }

        $this->_level = $level;

        return $this;
    }

    /**
     * @param string $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addFile($fileName, $mimeType = null)
    {
        $f = fopen($fileName, 'r');

        $this->_files[] = [
            'name'     => 'files[]',
            'contents' => $f,
            'filename' => basename($fileName),
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $content
     * @param string|null $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addFileFromContent($content, $fileName = null, $mimeType = null)
    {
        $this->_files[] = [
            'name'     => 'files[]',
            'contents' => $content,
            'filename' => $fileName,
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $url
     * @param string|null $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addFileFromUrl($url, $fileName = null, $mimeType = null)
    {
        $this->_files[] = [
            'name'     => 'files[]',
            'contents' => file_get_contents($url),
            'filename' => $fileName ? $fileName : null,
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addImage($fileName, $mimeType = null)
    {
        $f = fopen($fileName, 'r');

        $this->_files[] = [
            'name'     => 'images[]',
            'contents' => $f,
            'filename' => basename($fileName),
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $content
     * @param string|null $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addImageFromContent($content, $fileName = null, $mimeType = null)
    {
        $this->_files[] = [
            'name'     => 'images[]',
            'contents' => $content,
            'filename' => $fileName,
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $url
     * @param string|null $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addImageFromUrl($url, $fileName = null, $mimeType = null)
    {
        $this->_files[] = [
            'name'     => 'images[]',
            'contents' => file_get_contents($url),
            'filename' => $fileName ? $fileName : null,
            'headers'  => [
                'content-type' => $mimeType ? $mimeType : 'application/octet-stream',
            ],
        ];

        return $this;
    }

    /**
     * @param string $channelToken
     * @return bool
     */
    public function send($channelToken)
    {
        $url = sprintf(self::$_baseUrl, $channelToken);

        $data = [
            'title'    => $this->_title,
            'content'  => $this->_content,
            'priority' => $this->_priority,
            'level'    => $this->_level,
        ];

        $multipart = [];

        $multipart[] = [
            'name'     => 'data',
            'contents' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'headers'  => [
                'content-type' => 'application/json',
            ],
        ];

        $multipart = array_merge($multipart, $this->_files);

        $response = self::getClient()->request('POST', $url, [
            'multipart' => $multipart,
        ]);

        return $response->getStatusCode() == 200;
    }
}