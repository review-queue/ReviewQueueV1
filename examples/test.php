<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use ReviewQueueV1\ReviewQueueV1;

require_once __DIR__ . '/../vendor/autoload.php';

$reviewQueueApi = new ReviewQueueV1('lVwU8ioiS9Aw1qc0l7Ubv12aWNMVUPVdvTn');

try {

    $allReviews = [];

    $reviewsAPI = $reviewQueueApi->reviews();

    // Get first page of reviews
    $firstPageOfReviews = $reviewsAPI->getAll();
    $allReviews[1] = $firstPageOfReviews;

    //
    //$currentPage = $reviewsAPI->client->headers['X-Pagination-Current-Page'];
    //$totalPages = $reviewsAPI->client->headers['X-Pagination-Page-Count'];
    //$totalCount = $reviewsAPI->client->headers['X-Pagination-Total-Count'];


    // Links
    $links = $reviewsAPI->links;

    echo "Rate Limit Limit: " . $reviewsAPI->client->headers['X-Rate-Limit-Limit'] . "<br>";
    echo "Rate Limit Remaining: " . $reviewsAPI->client->headers['X-Rate-Limit-Remaining'] . "<br>";
    echo "Rate Limit Reset: " . $reviewsAPI->client->headers['X-Rate-Limit-Reset'] . "<br>";

    // Page meta
    $currentPage = $reviewsAPI->meta->currentPage;
    $totalCount = $reviewsAPI->meta->totalCount;
    $itemsPerPage = $reviewsAPI->meta->perPage;
    $pageCount = $reviewsAPI->meta->pageCount;


    echo 'Current Page: ' . $currentPage . "<br>";
    echo 'Total Count: ' . $totalCount . "<br>";
    echo 'Items Per Page: ' . $itemsPerPage . "<br>";
    echo 'Page Count: ' . $pageCount . "<br>";


    // First page
    echo "<pre>";
    print_r($allReviews[1]);
    echo "</pre>";

    if ($totalCount > 1) {

        for ($nextPage = $currentPage + 1; $nextPage <= $pageCount; $nextPage++) {

            $allReviews[$nextPage] = $reviewsAPI->getAll($nextPage);
            echo "<pre>";
            print_r($allReviews[$nextPage]);
            echo "</pre>";

        }
    }
} catch (Exception $e) {
    echo($e->getMessage());
}


// Send a review request
//$reviewRequest = $reviewQueueApi->reviewRequest();
//$response = $reviewRequest->create('+18135002096');
//echo $reviewRequest->client->responseCode;
//echo $response->status;
//echo $response->phone_number;


//$response = $reviewRequest->getByID(256);
////echo $reviewRequest->client->responseCode;
//print_r($response);
