<?php

namespace spec\AppBundle\Factory;

use AppBundle\Entity\CityTweet;
use AppBundle\Factory\CityTweetFactory;
use AppBundle\Model\Geocode;
use AppBundle\Model\Tweet;
use AppBundle\Repository\CityTweetRepositoryInterface;
use AppBundle\Service\TwitterProvider\TwitterProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin CityTweetFactory
 */
class CityTweetFactorySpec extends ObjectBehavior
{
    private $findQuerySize;
    private $findRadius;

    function let(
        CityTweetRepositoryInterface $cityTweetRepo,
        TwitterProviderInterface $twitter
    ) {
        $this->findQuerySize = 100;
        $this->findRadius    = 50;

        $this->beConstructedWith($this->findRadius, $this->findQuerySize, $cityTweetRepo, $twitter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CityTweetFactory::class);
    }

    function it_creates_city_tweet_from_geocode(
        CityTweetRepositoryInterface $cityTweetRepo,
        TwitterProviderInterface $twitter
    ) {
        // setup
        $city    = 'Bangkok';
        $geocode = new Geocode($city, 5, 10);
        $tweet1  = new Tweet('http://me.com/me.jpg', 'me1', 'hello!', '12/12/12', 5.1, 5.1);
        $tweet2  = new Tweet('http://me.com/me.jpg', 'me1', 'hello!', '12/12/12', 5.1, 5.1);
        $tweet3  = new Tweet('http://me.com/me.jpg', 'me1', 'hello!', '12/12/12', 5.1, 5.1);
        $tweets  = [$tweet1, $tweet2, $tweet3];

        // mock twitter provider
        $twitter->findTweetsHavingCoordinateAt(5, 10, $this->findRadius, $this->findQuerySize)
            ->shouldBeCalledTimes(1)
            ->willReturn($tweets);

        // mock repo
        $cityTweetRepo->id($geocode->getName())->willReturn('abc:Bangkok');

        // execute & assert
        $expected = new CityTweet('abc:Bangkok', 'Bangkok', 5, 10, $tweets);
        $this->createFromGeocode($geocode)->shouldBeLike($expected);
    }
}
