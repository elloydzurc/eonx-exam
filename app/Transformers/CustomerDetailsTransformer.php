<?php

namespace App\Transformers;

use App\Entities\Customer;
use League\Fractal\TransformerAbstract;

/**
 * Class CustomerDetailsTransformer
 *
 * @package App\Transformers
 */
class CustomerDetailsTransformer extends TransformerAbstract
{
    /**
     * @param Customer $customer
     * @return array
     */
    public function transform(Customer $customer)
    {
        return [
            'full_name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone()
        ];
    }
}
