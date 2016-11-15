<?php

namespace AppBundle\Model;

class Geocode
{
    /** @var string */
    private $name;

    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    /**
     * @param string $name
     * @param string $latitude
     * @param string $longitude
     */
    public function __construct($name, $latitude, $longitude)
    {
        $this->name      = $name;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
