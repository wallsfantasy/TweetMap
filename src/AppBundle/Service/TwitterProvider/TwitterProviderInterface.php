<?php

namespace AppBundle\Service\TwitterProvider;

use AppBundle\Model\Tweet;

interface TwitterProviderInterface
{
    /**
     * Find tweets by coordinate and radius those having its "place" coordinate.
     * Since not many tweets has "place" coordinate we can specify how much tweets
     * we'll make at one time in $querySize. Radius in kilometer unit.
     *
     * @param float $latitude
     * @param float $longitude
     * @param int   $radius
     * @param int   $querySize
     * @return Tweet[]
     */
    public function findTweetsHavingCoordinateAt($latitude, $longitude, $radius, $querySize);
}
