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
        $cityName = 'Bangkok';
        $id = $this->repository->id($cityName);
        $tweet = new Tweet('http://www.twitter.com', 'Hello!', '12/12/12');
        $cityTweet = new CityTweet($id, $cityName, [$tweet]);

        // Execute
        $this->repository->save($cityTweet);
        $actual = $I->grabFromRedis($id);

        // Expectation
        $expected = json_encode($cityTweet);

        // Assert
        $I->assertEquals($expected, $actual);
    }
}
