<?php

namespace tests\functional\Geocode\Repository;

use AppBundle\Entity\CityTweet;
use AppBundle\Model\Tweet;
use FunctionalTester;
use AppBundle\Repository\RedisCityTweetRepository;

class FindJsonByCityNameCest
{
    /** @var RedisCityTweetRepository */
    private $repository;

    public function _before(FunctionalTester $I)
    {
        $this->repository = $I->grabService('app.repository.city_tweet');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function findByCityNameJsonSuccess(FunctionalTester $I)
    {
        $I->wantTo('Find by city name return json');

        // Mock data in DB
        $cityName  = 'Bangkok';
        $id        = $this->repository->id($cityName);
        $latitude  = 1;
        $longitude = 2;

        $tweet  = new Tweet('http://www.twitter.com/me.jpg', 'Adam', 'Hello!', '12/12/12', 1, 2);
        $actual = [
            'id' => $id,
            'city' => $cityName,
            'lat' => $latitude,
            'lng' => $longitude,
            'tweets' => [$tweet->toArray()]
        ];

        $I->haveInRedis('string', $id, json_encode($actual));

        // Execute
        $actual = $this->repository->findJsonByCityName($cityName);

        // Expectation
        $cityTweet = new CityTweet($id, $cityName, $latitude, $longitude, [$tweet]);
        $expected  = json_encode($cityTweet);

        // Assert
        $I->assertEquals($expected, $actual);
    }

    public function findByCityNameJsonNotFoundSuccess(FunctionalTester $I)
    {
        $I->wantTo('Find by city name return null when not found');

        $cityName = 'non-exist';
        $actual   = $this->repository->findJsonByCityName($cityName);

        $expected = null;

        $I->assertEquals($expected, $actual);
    }
}
