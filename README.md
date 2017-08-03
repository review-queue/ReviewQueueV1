ReviewQueue V1
=========================

### Documentation
http://developers.reviewqueue.net


### Installation
This library can be found on Packagist. The recommended way to install this is through [composer](http://getcomposer.org)

```json
composer require local-spark/reviewqueue-v1

```

### Send Review Request
```php

require 'vendor/autoload.php';

$reviewQueueApi = new ReviewQueueV1('<YOUR_API_KEY>');

// Send a review request
try {

    $reviewRequestAPI = $reviewQueueApi->reviewRequest();
    $response = $reviewRequestAPI->create('+18888888888');
    print_r($response);

} catch (Exception $e) {
    die($e->getMessage());
}



```

### Retrieve Reviews
20 Reviews are returned in each request
```php
try {

    $firstPageOfReviews = $reviewsAPI->getAll();

    // Page meta
    $currentPage = $reviewsAPI->meta->currentPage;
    $totalCount = $reviewsAPI->meta->totalCount;
    $itemsPerPage = $reviewsAPI->meta->perPage;
    $pageCount = $reviewsAPI->meta->pageCount;

    // Get next 20 results
    if($pageCount > 1){
        $secondPageOfReviews = $reviewsAPI->getAll(2);
    }

} catch (Exception $e) {
    die($e->getMessage());
}

```