<?php

namespace ReviewQueueV1\Entity;

/**
 * Class BaseEntity
 * @package ReviewQueueV1\Entity
 */
class BaseEntity
{
    /**
     * @param \stdClass|array|null $parameters
     */
    public function __construct($parameters = null)
    {
        if (!$parameters) {
            return;
        }

        if ($parameters instanceof \stdClass) {
            $parameters = get_object_vars($parameters);
        }

        $this->createParameters($parameters);
    }

    /**
     * @param array $parameters
     */
    protected function createParameters(Array $parameters)
    {
        foreach ($parameters as $property => $value) {
            $property = self::camelize($property);

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @param $word
     * @return mixed
     */
    public static function camelize($word)
    {
        return str_replace(' ', '', lcfirst(ucwords(preg_replace('/[^A-Za-z0-9]+/', ' ', $word))));
    }
}
