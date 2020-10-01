<?php

namespace App\Domain;

use App\Domain\Mapper\CustomerJSONMapper;
use App\Domain\Mapper\CustomerXMLMapper;

/**
 * Class MapperFactory
 *
 * @package App\Domain
 */
class MapperFactory
{
    /**
     * Mapper Factory
     *
     * @param string $entity
     * @param string $format
     * @return mixed
     */
    public static function create(string $entity, string $format)
    {
        if ($entity == 'customer') {
            return self::customerMapper($format);
        }

        return null;
    }

    /**
     * Customer Mapper factory
     *
     * @param string $format
     * @return mixed
     */
    public static function customerMapper(string $format)
    {
        switch ($format) {
            case 'json':
                return new CustomerJSONMapper();
                break;
            default:
                return new CustomerXMLMapper();
        }
    }
}
