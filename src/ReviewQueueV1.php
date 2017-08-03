<?php

namespace ReviewQueueV1;

use ReviewQueueV1\Api\ReviewRequestApi;
use ReviewQueueV1\Api\ReviewsApi;
use ReviewQueueV1\Http\CurlClient;

/**
 * Class ReviewQueueV1
 * @package ReviewQueueV1
 */
class ReviewQueueV1
{
    /**
     * @var CurlClient
     */
    protected $client;

    /**
     * ReviewQueueV1 constructor.
     * @param $authKey
     */
    public function __construct($authKey)
    {
        $this->client = new CurlClient();
        $this->client->setAuthKey($authKey);
    }

    /**
     * @return ReviewRequestApi
     */
    public function reviewRequest()
    {
        return new ReviewRequestApi($this->client);
    }

    /**
     * @return ReviewsApi
     */
    public function reviews()
    {
        return new ReviewsApi($this->client);
    }

}