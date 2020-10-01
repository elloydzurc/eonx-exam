<?php

namespace App\Domain\Mapper;

use App\Domain\DTO\Customer;
use SimpleXMLElement;

/**
 * Class CustomerXMLMapper
 *
 * @package App\Domain\Mapper
 */
class CustomerXMLMapper implements Mapper
{
    /**
     * Map data into entity
     *
     * @param $data
     * @return array
     */
    public function mapData($data): array
    {
        $entities = [];
        if (!$data instanceof SimpleXMLElement) {
            return null;
        }

        foreach ($data as $simpleXMLElement) {
            $entity = new Customer();
            $this->mapCustomer($simpleXMLElement, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * @param SimpleXMLElement $customerData
     * @param Customer $customer
     */
    protected function mapCustomer(SimpleXMLElement $customerData, Customer $customer)
    {
        $customer->firstname = (string) $customerData->name->first;
        $customer->lastname = (string) $customerData->name->last;

        $customer->email = (string) $customerData->email;
        $customer->username = (string) $customerData->login->username;
        $customer->password = md5((string) $customerData->login->password);

        $customer->gender = (string) $customerData->gender;
        $customer->country = (string) $customerData->location->country;
        $customer->city = (string) $customerData->location->city;
        $customer->phone = (string) $customerData->phone;
    }
}
