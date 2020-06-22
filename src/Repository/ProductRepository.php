<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class ProductRepository extends EntityRepository
{
    public function findProducts(EntityManager $em)
    {
        $qb = $em->createQueryBuilder();
        $qb->select('p.id, 
                     p.name, 
                     p.cost'
            )
            ->from('App\Entity\Product', 'p');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findProductsCost(EntityManager $em, array $products)
    {
        $result = 0;

        $qb = $em->createQueryBuilder();
        $qb->select('SUM(p.cost) AS price')
            ->from('App\Entity\Product', 'p')
            ->where('p.id IN (:products)')
            ->setParameter('products', $products, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);

        $query = $qb->getQuery();
        if ($results = $query->getResult()) {
            $result = $results[0]['price'];
        }

        return $result;
    }
}
