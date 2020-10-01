<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface CustomersRepository
 *
 * @package App\Repositories
 */
interface CustomersRepository
{
    /**
     * Paginate records
     *
     * @param int $limit
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginatedRecords(int $limit = 15, int $page = 1): LengthAwarePaginator;

    /**
     * Find record by Id
     *
     * @param int $customerId
     * @return object|null
     */
    public function findRecord(int $customerId): ?object;

    /**
     * Populate records
     *
     * @param array $records
     * @param int $perBatch
     */
    public function populateRecords(array $records, int $perBatch = 20): void;
}
