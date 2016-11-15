<?php

namespace tests\functional\Geocode\Repository;

use AppBundle\Entity\CityTweet;
use AppBundle\Model\Tweet;
use FunctionalTester;
use AppBundle\Repository\RedisCityTweetRepository;

class SaveCityTweetCest
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

    public function saveDataAsJsonSuccess(FunctionalTester $I)
    {
        $I->wantTo('Save CityTweet as json success');

        // Mock object
        $cityName  = 'Bangkok';
        $id        = $this->repository->id($cityName);
        $latitude  = 1;
        $longitude = 2;

        $tweet     = new Tweet('http://www.twitter.com/me.jpg', 'Adam', 'Hello!', '12/12/12', 1, 2);
        $cityTweet = new CityTweet($id, $cityName, $latitude, $longitude, [$tweet]);

        // Execute
        $this->repository->save($cityTweet);
        $actual = $I->grabFromRedis($id);

        // Expectation
        $expected = json_encode($cityTweet);

        // Assert
        $I->assertEquals($expected, $actual);
    }
}
