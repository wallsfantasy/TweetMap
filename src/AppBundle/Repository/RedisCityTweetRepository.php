<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CityTweet;
use Predis\Client;

class RedisCityTweetRepository implements CityTweetRepositoryInterface
{
    /** @var Client */
    private $predis;

    /** @var string */
    private $keyPrefix;

    /** @var int */
    private $ttl;

    /**
     * @param Client $predis
     * @param string $keyPrefix
     * @param int    $ttl
     */
    public function __construct(Client $predis, $keyPrefix, $ttl)
    {
        $this->predis    = $predis;
        $this->keyPrefix = $keyPrefix;
        $this->ttl       = $ttl;
    }

    /**
     * @param string $cityName
     * @return string
     */
    private function prefixedId($cityName)
    {
        return "{$this->keyPrefix}:{$cityName}";
    }

    /**
     * @param string $cityName
     * @return string
     */
    public function id($cityName)
    {
        return $this->prefixedId($cityName);
    }

    /**
     * @param string $cityName
     * @return string|null
     */
    public function findJsonByCityName($cityName)
    {
        $key    = $this->prefixedId($cityName);
        $string = $this->predis->get($key);

        if ($string === '') {
            return null;
        }

        return $string;
    }

    /**
     * @param CityTweet $cityTweet
     */
    public function save(CityTweet $cityTweet)
    {
        $key   = $this->prefixedId($cityTweet->getCityName());
        $value = json_encode($cityTweet);

        $this->predis->set($key, $value, 'ex', $this->ttl);
    }
}
