<?php

namespace AppBundle\Factory;

use AppBundle\Entity\CityTweet;
use AppBundle\Model\Geocode;
use AppBundle\Repository\CityTweetRepositoryInterface;
use AppBundle\Service\TwitterProvider\TwitterProviderInterface;

class CityTweetFactory
{
    /** @var CityTweetRepositoryInterface */
    private $cityTweetRepo;

    /** @var TwitterProviderInterface */
    private $twitter;

    /** @var int */
    private $radius;

    /** @var int */
    private $querySize;

    /**
     * @param int                          $radius
     * @param int                          $querySize
     * @param CityTweetRepositoryInterface $cityTweetRepo
     * @param TwitterProviderInterface     $twitter
     */
    public function __construct(
        $radius,
        $querySize,
        CityTweetRepositoryInterface $cityTweetRepo,
        TwitterProviderInterface $twitter
    ) {
        $this->radius        = $radius;
        $this->querySize     = $querySize;
        $this->cityTweetRepo = $cityTweetRepo;
        $this->twitter       = $twitter;
    }

    /**
     * @param Geocode $geocode
     * @return CityTweet
     */
    public function createFromGeocode(Geocode $geocode)
    {
        // get tweets from received geocode
        $cityName  = $geocode->getName();
        $latitude  = $geocode->getLatitude();
        $longitude = $geocode->getLongitude();

        $tweets = $this->twitter
            ->findTweetsHavingCoordinateAt($latitude, $longitude, $this->radius, $this->querySize);

        // create CityTweet object
        $id = $this->cityTweetRepo->id($cityName);

        return new CityTweet($id, $cityName, $latitude, $longitude, $tweets);
    }
}
