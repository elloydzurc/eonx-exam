<?php

namespace App\Domain\Mapper;

use App\Domain\DTO\Customer;

/**
 * Class CustomerJSONMapper
 *
 * @package App\Domain\Mapper
 */
class CustomerJSONMapper implements Mapper
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
        if (!is_array($data)) {
            return null;
        }

        foreach ($data as $customer) {
            $entity = new Customer();
            $this->mapCustomer($customer, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * Map customer data
     *
     * @param array $customerData
     * @param Customer $customer
     */
    protected function mapCustomer(array $customerData, Customer $customer)
    {
        $customer->firstname = $customerData['name']['first'];
        $customer->lastname = $customerData['name']['last'];

        $customer->email = $customerData['email'];
        $customer->username = $customerData['login']['username'];
        $customer->password = md5($customerData['login']['password']);

        $customer->gender = $customerData['gender'];
        $customer->country = $customerData['location']['country'];
        $customer->city = $customerData['location']['city'];
        $customer->phone = $customerData['phone'];
    }
}
