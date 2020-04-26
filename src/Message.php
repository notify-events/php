<?php

namespace notify_events\php_send;

use ErrorException;
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

    /** @var string */
    protected $_title;
    /** @var string */
    protected $_content;
    /** @var string */
    protected $_priority;
    /** @var string */
    protected $_level;

    CONST FILE_TYPE_FILE    = 'file';
    CONST FILE_TYPE_CONTENT = 'content';
    CONST FILE_TYPE_URL     = 'url';

    /** @var array */
    protected $_files = [];
    /** @var array */
    protected $_images = [];

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
     * @param string $boundary
     * @param string $name
     * @param string $content
     * @return string
     */
    protected static function prepareParam($boundary, $name, $content)
    {
        return self::prepareBoundaryPart($boundary, $content, [
            'Content-Disposition' => 'form-data; name="' . $name . '"',
            'Content-Type'        => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * @param string $boundary
     * @param string $name
     * @param array $files
     * @return string
     * @throws ErrorException
     */
    protected static function boundaryFiles($boundary, $name, $files)
    {
        $result = '';

        foreach ($files as $idx => $file) {
            switch ($file['type']) {
                case self::FILE_TYPE_FILE: {
                    $content  = file_get_contents($file['fileName']);
                    $fileName = basename($file['fileName']);
                    $mimeType = !empty($file['mimeType']) ? $file['mimeType'] : mime_content_type($file['fileName']);
                } break;
                case self::FILE_TYPE_CONTENT: {
                    $content  = $file['content'];
                    $fileName = !empty($file['fileName']) ? $file['fileName'] : 'file.dat';
                    $mimeType = !empty($file['mimeType']) ? $file['mimeType'] : 'application/octet-stream';
                } break;
                case self::FILE_TYPE_URL: {
                    $content  = file_get_contents($file['url']);
                    $fileName = !empty($file['fileName']) ? $file['fileName'] : basename($file['url']);
                    $mimeType = !empty($file['mimeType']) ? $file['mimeType'] : 'application/octet-stream';
                } break;
                default: {
                    throw new ErrorException('Unknown file type');
                }
            }

            $result .= self::prepareBoundaryPart($boundary, $content, [
                'Content-Disposition' => 'form-data; name="' . $name . '[' . $idx . ']"; filename="' . $fileName . '"',
                'Content-Type'        => $mimeType,
            ]);
        }

        return $result;
    }

    /**
     * @param string $boundary
     * @param string $content
     * @param string[] $headers
     * @return string
     */
    protected static function prepareBoundaryPart($boundary, $content, $headers)
    {
        $headers['Content-Length'] = strlen($content);

        $result = '--' . $boundary . PHP_EOL;

        foreach ($headers as $key => $value) {
            $result .= $key . ': ' . $value . PHP_EOL;
        }

        $result .= PHP_EOL;
        $result .= $content . PHP_EOL;

        return $result;
    }

    /**
     * @param string $channelToken
     * @return void
     * @throws ErrorException
     */
    public function send($channelToken)
    {
        $url = sprintf(self::$_baseUrl, $channelToken);

        $boundary = uniqid();

        $content = '';

        if (!empty($this->_title)) {
            $content .= self::prepareParam($boundary, 'title', $this->_title);
        }

        $content .= self::prepareParam($boundary, 'content', $this->_content);
        $content .= self::prepareParam($boundary, 'priority', $this->_priority);
        $content .= self::prepareParam($boundary, 'level', $this->_level);

        $content .= self::boundaryFiles($boundary, 'files', $this->_files);
        $content .= self::boundaryFiles($boundary, 'images', $this->_images);

        $content .= '--' . $boundary . '--';

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' =>
                    'Content-Type: multipart/form-data; boundary="' . $boundary . '"' . PHP_EOL .
                    'Content-Length: ' . strlen($content) . PHP_EOL,
                'content' => $content,
            ],
        ]);

        file_get_contents($url, false, $context);
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
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
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
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
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
     * @return string
     */
    public function getPriority()
    {
        return $this->_priority;
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
     * @return string
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @param string $fileName
     * @param string|null $mimeType
     * @return $this
     */
    public function addFile($fileName, $mimeType = null)
    {
        $this->_files[] = [
            'type'     => self::FILE_TYPE_FILE,
            'fileName' => basename($fileName),
            'mimeType' => $mimeType,
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
            'type'     => self::FILE_TYPE_CONTENT,
            'content'  => $content,
            'fileName' => $fileName,
            'mimeType' => $mimeType,
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
            'type'     => self::FILE_TYPE_URL,
            'url'      => $url,
            'fileName' => $fileName,
            'mimeType' => $mimeType,
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
        $this->_images[] = [
            'type'     => self::FILE_TYPE_FILE,
            'fileName' => basename($fileName),
            'mimeType' => $mimeType,
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
        $this->_images[] = [
            'type'     => self::FILE_TYPE_CONTENT,
            'content'  => $content,
            'fileName' => $fileName,
            'mimeType' => $mimeType,
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
        $this->_images[] = [
            'type'     => self::FILE_TYPE_URL,
            'url'      => $url,
            'fileName' => $fileName,
            'mimeType' => $mimeType,
        ];

        return $this;
    }
}