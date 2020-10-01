<?php

namespace App\Services;

/**
 * Interface CustomersDataService
 *
 * @package App\Services
 */
interface CustomersDataService
{
    /**
     * Get list of customers
     *
     * @param array $queryParams
     * @return array
     */
    public function getPaginatedList(array $queryParams): array;

    /**
     * Get customer details
     *
     * @param int $customerId
     * @return array
     */
    public function getDetails(int $customerId): array;

    /**
     * Import customers from API provider
     *
     * @return void
     */
    public function import(): void;
}
