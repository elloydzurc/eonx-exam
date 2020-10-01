<?php

use App\Jobs\CustomersImportJob;
use Illuminate\Support\Facades\Bus;

/**
 * Class CustomerApiTest
 */
class CustomerApiTest extends TestCase
{
    /**
     * /api/customers [GET]
     *
     * @return void
     */
    public function testShouldReturnAllCustomers()
    {
        $this->get('/api/customers');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'full_name',
                    'email',
                    'country'
                ]
            ],
            'meta' => [
                '*' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links',
                ]
            ]
        ]);
    }

    /**
     * /api/customers/{customerId} [GET]
     *
     * @return void
     */
    public function testShouldReturnCustomer()
    {
        $this->get("/api/customers/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'full_name',
                    'email',
                    'username',
                    'gender',
                    'country',
                    'city',
                    'phone'
                ]
            ]
        );
    }

    /**
     * /api/customers/{customerId} [GET]
     *
     * @return void
     */
    public function testShouldNotReturnCustomer()
    {
        $this->get("/api/customers/999999", []);
        $this->seeStatusCode(404);
    }

    /**
     * /api/customers [POST]
     */
    public function testShouldImportCustomers()
    {
        Bus::fake();
        $this->artisan('import:customers');
        Bus::assertDispatched(CustomersImportJob::class);
    }
}
