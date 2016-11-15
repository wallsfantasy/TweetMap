<?php

namespace AppBundle\Model;

class Tweet
{
    /** @var string */
    private $image;

    /** @var string */
    private $screenName;

    /** @var string */
    private $text;

    /** @var string */
    private $createdAt;

    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    /**
     * @param string $image
     * @param string $screenName
     * @param string $text
     * @param string $createdAt
     * @param string $latitude
     * @param string $longitude
     */
    public function __construct($image, $screenName, $text, $createdAt, $latitude, $longitude)
    {
        $this->image      = $image;
        $this->screenName = $screenName;
        $this->text       = $text;
        $this->createdAt  = $createdAt;
        $this->latitude   = $latitude;
        $this->longitude  = $longitude;
    }

    /**
     * Return its properties in array format
     */
    public function toArray()
    {
        return [
            'image' => $this->image,
            'screen_name' => $this->screenName,
            'text' => $this->text,
            'created_at' => $this->createdAt,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
}
