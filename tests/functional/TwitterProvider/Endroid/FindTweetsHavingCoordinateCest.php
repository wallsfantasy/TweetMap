<?php

namespace tests\functional\Service\TwitterProvider\Endroid;

use AppBundle\Model\Tweet;
use AppBundle\Service\TwitterProvider\TwitterProviderInterface;
use FunctionalTester;

class FindTweetsHavingCoordinateCest
{
    /** @var TwitterProviderInterface */
    private $twitterProvider;

    public function _before(FunctionalTester $I)
    {
        $this->twitterProvider = $I->grabService('app.provider.twitter');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function findTweetsHavingCoordinateSuccess(FunctionalTester $I)
    {
        $I->wantTo('Find tweets having coordinate success');

        $latitude = 13.7563;
        $longitude = 100.5018;
        $radius = 50;
        $querySize = 100;

        // Execute
        $actual = $this->twitterProvider
            ->findTweetsHavingCoordinateAt($latitude, $longitude, $radius, $querySize);

        // Assert
        $I->assertInstanceOf(Tweet::class, $actual[0]); // better off using http mock
    }

    public function findTweetsDontHaveCoordinateSuccess(FunctionalTester $I)
    {
        $I->wantTo('Find tweets having coordinate returns empty array');

        $latitude = 100;
        $longitude = 100;
        $radius = 50;
        $querySize = 5;

        // Execute
        $actual = $this->twitterProvider
            ->findTweetsHavingCoordinateAt($latitude, $longitude, $radius, $querySize);

        // Assert
        $I->assertSame([], $actual);
    }
}
