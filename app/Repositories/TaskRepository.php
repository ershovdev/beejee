<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TaskRepository extends EntityRepository
{
    public function getPaginator($offset, string $column, string $order)
    {
        try {
            $dql = "SELECT p FROM \Src\Task p ORDER BY p.{$column} {$order}";
            $query = $this->getEntityManager()
                ->createQuery($dql)
                ->setMaxResults(3)
                ->setFirstResult(3 * ($offset - 1));

            return new Paginator($query, $fetchJoinCollection = true);
        } catch (\Exception $e) {
            echo $e;
        }
    }
}