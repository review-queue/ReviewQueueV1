<?php

namespace ReviewQueueV1\Entity;

/**
 * Class ReviewEntity
 * @package ReviewQueueV1\Entity
 */
class ReviewEntity extends BaseEntity
{
    public $id;
    public $companyId;
    public $name;
    public $email;
    public $feedback;
    public $rating;
    public $date;
}