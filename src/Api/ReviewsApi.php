<?php

namespace ReviewQueueV1\Api;

use ReviewQueueV1\Entity\Meta;
use ReviewQueueV1\Entity\ReviewEntity;
use ReviewQueueV1\Http\CurlClient;

/**
 * Class ReviewRequestApi
 * @package ReviewQueueV1\Api
 */
class ReviewsApi extends BaseApi
{
    /**
     * ReviewsApi constructor.
     * @param CurlClient $client
     */
    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $pageSize
     * @param int $page
     * @return array|ReviewEntity[]
     */
    public function getAll($pageSize = 20, $page = 1)
    {
        $response = $this->client->request(CurlClient::METHOD_GET, sprintf('%s/reviews', self::ENDPOINT),
            ['page' => $page, 'page_size' => $pageSize]);

        if ($this->client->responseCode == 200) {

            $reviewArr = [];
            $reviews = json_decode($response);

            if (isset($reviews->items)) {
                foreach ($reviews->items as $review) {
                    $reviewArr[] = new ReviewEntity($review);
                }
            }

            if (isset($reviews->_meta)) {
                $this->meta = new Meta($reviews->_meta);
            }

            if (isset($reviews->_links)) {
                $this->links = $reviews->_links;
            }

            return $reviewArr;
        }
    }
}