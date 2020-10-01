<?php

namespace App\Domain\Mapper;

/**
 * Interface Mapper
 *
 * @package App\Domain
 */
interface Mapper
{
    /**
     * Map data into entity
     *
     * @param $data
     * @return array
     */
    public function mapData($data): array;
}
