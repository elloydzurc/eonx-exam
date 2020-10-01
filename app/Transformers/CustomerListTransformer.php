<?php

namespace App\Transformers;

use App\Entities\Customer;
use League\Fractal\TransformerAbstract;

/**
 * Class CustomerListTransformer
 *
 * @package App\Transformers
 */
class CustomerListTransformer extends TransformerAbstract
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
            'country' => $customer->getCountry()
        ];
    }
}
