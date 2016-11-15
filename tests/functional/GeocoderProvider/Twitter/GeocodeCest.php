<?php

namespace tests\functional\Service\GeocoderProvider\Twitter;

use AppBundle\Model\Geocode;
use AppBundle\Service\GeocoderProvider\GeocoderProviderInterface;
use FunctionalTester;

class GeocodeCest
{
    /** @var GeocoderProviderInterface */
    private $geocoderProvider;

    public function _before(FunctionalTester $I)
    {
        $this->geocoderProvider = $I->grabService('app.provider.geocoder');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function geocodeCitySuccess(FunctionalTester $I)
    {
        $I->wantTo('Geocode a city success');

        // Execute
        $actual = $this->geocoderProvider->geocode('bangkok');

        // Assert
        $I->assertInstanceOf(Geocode::class, $actual); // better off using http mock
    }

    public function geocodeNonExistPlaceSuccess(FunctionalTester $I)
    {
        $I->wantTo('Geocode non-exist place return null');

        // Execute
        $actual = $this->geocoderProvider->geocode('xxxxxxxxxxxxxx');

        // Assert
        $I->assertNull($actual);
    }
}
