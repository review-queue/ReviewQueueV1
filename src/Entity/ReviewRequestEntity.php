<?php

namespace ReviewQueueV1\Entity;

/**
 * Class ReviewRequestEntity
 * @package ReviewQueueV1\Entity
 */
class ReviewRequestEntity extends BaseEntity
{
    public $id;
    public $phoneNumber;
    public $status;
    public $dateSent;
}