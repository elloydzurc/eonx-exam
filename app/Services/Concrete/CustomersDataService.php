<?php

namespace App\Services\Concrete;

use App\Jobs\CustomersImportJob;
use App\Repositories\CustomersRepository;
use App\Services\CustomersDataService as CustomersDataServiceInterface;
use App\Transformers\CustomerDetailsTransformer;
use App\Transformers\CustomerListTransformer;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class CustomersDataService
 *
 * @package App\Services\Concrete
 */
class CustomersDataService implements CustomersDataServiceInterface
{
    /**
     * @var CustomersRepository $customersRepository
     */
    protected $customersRepository;

    /**
     * @var Manager $manager
     */
    protected $manager;

    /**
     * CustomersDataService constructor.
     *
     * @param CustomersRepository $customersRepository
     * @param Manager $manager
     */
    public function __construct(CustomersRepository $customersRepository, Manager $manager)
    {
        $this->customersRepository = $customersRepository;
        $this->manager = $manager;
    }

    /**
     * Get list of customers
     *
     * @param array $queryParams
     * @return array
     */
    public function getPaginatedList(array $queryParams): array
    {
        $perPage = $queryParams['perPage'] ?? 15;
        $page = $queryParams['page'] ?? 1;

        $paginator = $this->customersRepository
            ->paginatedRecords($perPage, $page);

        $customers = $paginator->getCollection();
        $resources = new Collection($customers, new CustomerListTransformer());
        $resources->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->manager
            ->createData($resources)
            ->toArray();
    }

    /**
     * Get customer details
     *
     * @param int $customerId
     * @return array
     */
    public function getDetails(int $customerId): array
    {
        $customer = $this->customersRepository
           ->findRecord($customerId);

        if (!$customer) {
            return [];
        }

        $resources = new Item($customer, new CustomerDetailsTransformer());
        return $this->manager
            ->createData($resources)
            ->toArray();
    }

    /**
     * Import customers from API provider
     *
     * @return void
     */
    public function import(): void
    {
        dispatch(new CustomersImportJob());
    }
}
