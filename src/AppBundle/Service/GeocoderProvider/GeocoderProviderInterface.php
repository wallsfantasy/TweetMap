<?php

namespace AppBundle\Service\GeocoderProvider;

use AppBundle\Model\Geocode;

interface GeocoderProviderInterface
{
    /**
     * Return array of [latitude, longitude] of given location
     *
     * @param string $location
     * @return Geocode|null
     */
    public function geocode($location);
}
