<?php

namespace ReviewQueueV1\Api;

use ReviewQueueV1\Entity\Meta;
use ReviewQueueV1\Http\CurlClient;

/**
 * Class BaseApi
 * @package ReviewQueueV1\Api
 */
class BaseApi
{
    const ENDPOINT = 'https://api.reviewqueue.net/v1';

    /**
     * @var CurlClient
     */
    public $client;

    /**
     * @var Meta
     */
    public $meta;

    /**
     * @var \stdClass
     */
    public $links;

    /**
     * @return CurlClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param CurlClient $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}