<?php

namespace App\Repositories\Concrete;

use App\Entities\Customer;
use App\Repositories\CustomersRepository as CustomersRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;
use ReflectionException;

/**
 * Class CustomersRepository
 *
 * @package App\Repositories\Concrete
 */
class CustomersRepository implements CustomersRepositoryInterface
{
    use PaginatesFromParams;

    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * @var ObjectRepository $repository
     */
    protected $repository;

    /**
     * @var Customer $entity
     */
    protected $entity;

    /**
     * CustomersRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entity = Customer::class;
        $this->repository = $entityManager->getRepository($this->entity);
    }

    /**
     * Customers list
     *
     * @param int $limit
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginatedRecords(int $limit = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->paginateAll($limit, $page);
    }

    /**
     * Find customer by Id
     *
     * @param int $customerId
     * @return object|null
     */
    public function findRecord(int $customerId): ?object
    {
        return $this->entityManager
            ->find($this->entity, $customerId);
    }

    /**
     * Populate records
     *
     * @param array $records
     * @param int $perBatch
     * @throws ReflectionException
     */
    public function populateRecords(array $records, int $perBatch = 20): void
    {
        foreach ($records as $c => $customer) {
            $entity = $this->repository
                ->findOneBy(['email' => $customer->email]);

            if (!$entity) {
                $entity = new Customer($customer);
            } else {
                $entity->setFirstname($customer->firstname);
                $entity->setLastname($customer->lastname);
                $entity->setUsername($customer->username);
                $entity->setPassword($customer->password);
                $entity->setGender($customer->gender);
                $entity->setCountry($customer->country);
                $entity->setCity($customer->city);
                $entity->setPhone($customer->phone);
            }

            $this->entityManager->persist($entity);
            if (($c  % $perBatch) == 0) {
                $this->flushAndClear();
            }
        }

        $this->flushAndClear();
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->entityManager
            ->getRepository($this->entity)
            ->createQueryBuilder($alias);
    }

    /**
     * Flush and clear entity manager
     */
    private function flushAndClear()
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
