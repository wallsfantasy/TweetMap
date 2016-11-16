<?php

namespace AppBundle\Service;

use AppBundle\Factory\CityTweetFactory;
use AppBundle\Repository\CityTweetRepositoryInterface;
use AppBundle\Service\GeocoderProvider\GeocoderProviderInterface;

class SearchCityTweetService
{
    /** @var CityTweetRepositoryInterface */
    private $cityTweetRepo;

    /** @var CityTweetFactory */
    private $cityTweetFactory;

    /** @var GeocoderProviderInterface */
    private $geocoder;

    /**
     * @param GeocoderProviderInterface    $geocoder
     * @param CityTweetRepositoryInterface $cityTweetRepo
     * @param CityTweetFactory             $cityTweetFactory
     */
    public function __construct(
        GeocoderProviderInterface $geocoder,
        CityTweetRepositoryInterface $cityTweetRepo,
        CityTweetFactory $cityTweetFactory
    ) {
        $this->geocoder         = $geocoder;
        $this->cityTweetRepo    = $cityTweetRepo;
        $this->cityTweetFactory = $cityTweetFactory;
    }

    /**
     * Search CityTweets and get result in json format
     *
     * @param string $cityName
     * @return string
     * @throws \Exception
     */
    public function search($cityName)
    {
        // request geocode from city name
        $geocode = $this->geocoder->geocode($cityName);

        // throws error if the city name cannot be located
        if ($geocode === null) {
            throw new \Exception('Cannot locate specified city name'); // better create a dedicated exception
        }

        // find existing CityTweet and return if exist
        // it is important use geocode object's name as it was verified
        $json = $this->cityTweetRepo->findJsonByCityName($geocode->getName());
        if ($json !== null) {
            return $json;
        }

        // create new CityTweet, save and return as json
        $cityTweet = $this->cityTweetFactory->createFromGeocode($geocode);
        $this->cityTweetRepo->save($cityTweet);

        return json_encode($cityTweet);
    }

}
