<?php

namespace AppBundle\Service\TwitterProvider;

use AppBundle\Model\Tweet;
use Endroid\Twitter\Twitter;

class EndroidTwitter implements TwitterProviderInterface
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
    public function findTweetsHavingCoordinateAt($latitude, $longitude, $radius, $querySize)
    {
        // query tweets
        $geocodeQuery = "{$latitude},{$longitude},{$radius}km";

        $tweetsResult = $this->twitter
            ->query('search/tweets', 'GET', 'json', ['geocode' => $geocodeQuery, 'count' => $querySize]);
        $tweetsData   = json_decode($tweetsResult->getContent(), true);

        // function to approximate center of bounding box
        // since twitter gave us that way
        $center = function (array $coordinates) {
            $i      = 0;
            $first  = 0;
            $second = 0;
            foreach ($coordinates as $point) {
                $first += $point[0];
                $second += $point[1];
                $i++;
            }
            return [$first / $i, $second / $i];
        };

        // instantiate Tweets
        $tweets = [];
        foreach ($tweetsData['statuses'] as $item) {

            if (!isset($item['place'])) {
                continue;
            }

            $image      = $item['user']['profile_image_url'];
            $screenName = $item['user']['screen_name'];
            $text       = $item['text'];
            $createdAt  = $item['created_at'];

            $points     = $item['place']['bounding_box']['coordinates'][0];
            $coordinate = $center($points);
            list($longitude, $latitude) = $coordinate;

            $tweets[] = new Tweet($image, $screenName, $text, $createdAt, $latitude, $longitude);
        }

        return $tweets;
    }
}
