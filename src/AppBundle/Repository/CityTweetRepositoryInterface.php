<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CityTweet;

interface CityTweetRepositoryInterface
{
    /**
     * @param string $cityName
     * @return string
     */
    public function id($cityName);

    /**
     * @param string $cityName
     * @return string String in Json format
     */
    public function findJsonByCityName($cityName);

    /**
     * @param CityTweet $cityTweet
     */
    public function save(CityTweet $cityTweet);
}
