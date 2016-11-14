<?php

namespace AppBundle\Model;

class Tweet
{
    /** @var string */
    private $url;

    /** @var string */
    private $text;

    /** @var string */
    private $createdAt;

    /**
     * @param string $url
     * @param string $text
     * @param string $createdAt
     */
    public function __construct($url, $text, $createdAt)
    {
        $this->url       = $url;
        $this->text      = $text;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Return its properties in array format
     */
    public function toArray()
    {
        return [
            'url' => $this->url,
            'text' => $this->text,
            'created_at' => $this->createdAt
        ];
    }
}
