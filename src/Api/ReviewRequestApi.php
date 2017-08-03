<?php

namespace ReviewQueueV1\Api;

use ReviewQueueV1\Entity\ReviewRequestEntity;
use ReviewQueueV1\Http\CurlClient;

/**
 * Class ReviewRequestApi
 * @package ReviewQueueV1\Api
 */
class ReviewRequestApi extends BaseApi
{
    /**
     * ReviewRequestApi constructor.
     * @param CurlClient $client
     */
    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $phoneNumber
     * @return ReviewRequestEntity
     */
    public function create($phoneNumber)
    {
        $response = $this->client->request(CurlClient::METHOD_POST, sprintf('%s/review-request/create', self::ENDPOINT),
            ['phone_number' => $phoneNumber]);

        if ($this->client->responseCode == 201) {
            $reviewRequest = json_decode($response);
            return new ReviewRequestEntity($reviewRequest);
        }
    }

    /**
     * @param $id
     * @return ReviewRequestEntity
     */
    public function getByID($id)
    {
        $response = $this->client->request(CurlClient::METHOD_GET, sprintf('%s/review-request/view', self::ENDPOINT),
            ['id' => $id]);

        if ($this->client->responseCode == 200) {
            $reviewRequest = json_decode($response);
            return new ReviewRequestEntity($reviewRequest);
        }
    }
}