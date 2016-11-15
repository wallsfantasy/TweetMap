<?php

namespace AppBundle\Service\GeocoderProvider;

use AppBundle\Model\Geocode;
use Endroid\Twitter\Twitter;

class TwitterGeocoderProvider implements GeocoderProviderInterface
{
    /** @var Twitter */
    private $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * {@inheritdoc}
     */
    public function geocode($place)
    {
        $geoResult = $this->twitter
            ->query('geo/search', 'GET', 'json', [
                'query' => $place,
                'granularity' => 'city'
            ]);
        $geoData   = json_decode($geoResult->getContent(), true);

        // returns null if cannot found
        if ($geoData['result']['places'] === []) {
            return null;
        }

        // use first geocode
        $geocode  = $geoData['result']['places'][0];
        $name = $geocode['name'];
        list($longitude, $latitude) = $geocode['centroid'];

        return new Geocode($name, $latitude, $longitude);
    }
}
