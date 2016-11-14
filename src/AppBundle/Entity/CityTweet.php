<?php

namespace AppBundle\Entity;

use AppBundle\Model\Tweet;

class CityTweet implements \JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $cityName;

    /** @var Tweet[] */
    private $tweets;

    public function __construct($id, $cityName, array $tweets = [])
    {
        $this->id   = $id;
        $this->cityName = $cityName;
        $this->tweets = $tweets;
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
            'tweets' => []
        ];

        // add tweet objects
        foreach ($this->tweets as $tweet) {
            $json['tweets'][] = $tweet->toArray();
        }

        return $json;
    }
}
