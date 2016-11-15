<?php

namespace AppBundle\Entity;

use AppBundle\Model\Tweet;

class CityTweet implements \JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $cityName;

    /** @var int */
    private $latitude;

    /** @var int */
    private $longitude;

    /** @var Tweet[] */
    private $tweets;

    public function __construct($id, $cityName, $latitude, $longitude, array $tweets = [])
    {
        $this->id        = $id;
        $this->cityName  = $cityName;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->tweets    = $tweets;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return \AppBundle\Model\Tweet[]
     */
    public function getTweets()
    {
        return $this->tweets;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $json = [
            'id' => $this->id,
            'city' => $this->cityName,
            'lat' => $this->latitude,
            'lng' => $this->longitude,
            'tweets' => []
        ];

        // add tweet objects
        foreach ($this->tweets as $tweet) {
            $json['tweets'][] = $tweet->toArray();
        }

        return $json;
    }
}
