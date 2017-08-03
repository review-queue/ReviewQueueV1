<?php

namespace ReviewQueueV1\Entity;

/**
 * Class ReviewEntity
 * @package ReviewQueueV1\Entity
 */
class Meta extends BaseEntity
{
    public $totalCount;
    public $pageCount;
    public $currentPage;
    public $perPage;
}