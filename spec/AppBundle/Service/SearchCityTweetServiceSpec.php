<?php

namespace spec\AppBundle\Service;

use AppBundle\Entity\CityTweet;
use AppBundle\Factory\CityTweetFactory;
use AppBundle\Model\Geocode;
use AppBundle\Repository\CityTweetRepositoryInterface;
use AppBundle\Service\GeocoderProvider\GeocoderProviderInterface;
use AppBundle\Service\SearchCityTweetService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin SearchCityTweetService
 */
class SearchCityTweetServiceSpec extends ObjectBehavior
{
    function let(
        GeocoderProviderInterface $geocoder,
        CityTweetRepositoryInterface $cityTweetRepo,
        CityTweetFactory $cityTweetFactory
    ) {
        $this->beConstructedWith($geocoder, $cityTweetRepo, $cityTweetFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SearchCityTweetService::class);
    }

    function it_search_by_fetch_existing_city(
        GeocoderProviderInterface $geocoder,
        CityTweetRepositoryInterface $cityTweetRepo
    ) {
        // setup
        $city          = 'Bangkok';
        $geocode       = new Geocode('Bangkok', 5, 10);
        $cityTweetJson = '{"bla":"bla"}';

        // mocks
        $geocoder->geocode($city)->shouldBeCalledTimes(1)->willReturn($geocode);
        $cityTweetRepo->findJsonByCityName($city)->shouldBeCalledTimes(1)->willReturn($cityTweetJson);

        // execute & assert
        $this->search($city)->shouldBeLike($cityTweetJson);
    }

    function it_search_and_create_city_tweet_when_not_found_in_repository(
        GeocoderProviderInterface $geocoder,
        CityTweetRepositoryInterface $cityTweetRepo,
        CityTweetFactory $cityTweetFactory
    ) {
        // setup
        $city      = 'Bangkok';
        $geocode   = new Geocode('Bangkok', 5, 10);
        $cityTweet = new CityTweet('abc', $geocode->getName(), $geocode->getLatitude(), $geocode->getLongitude());
        $cityTweetJson = json_encode($cityTweet);

        // mock
        $geocoder->geocode($city)->shouldBeCalledTimes(1)->willReturn($geocode);
        $cityTweetRepo->findJsonByCityName($city)->shouldBeCalledTimes(1)->willReturn(null);
        $cityTweetFactory->createFromGeocode($geocode)->shouldBeCalledTimes(1)->willReturn($cityTweet);
        $cityTweetRepo->save($cityTweet)->shouldBeCalledTimes(1);

        // execute & assert
        $this->search($city)->shouldBeLike($cityTweetJson);
    }

    function it_throws_when_geocoder_cannnot_find_city(GeocoderProviderInterface $geocoder)
    {
        // setup
        $city = 'kawabanka';

        // mock
        $geocoder->geocode($city)->shouldBeCalledTimes(1)->willReturn(null);

        // execute & assert
        $this->shouldThrow('\Exception')->during('search', [$city]);
    }
}
