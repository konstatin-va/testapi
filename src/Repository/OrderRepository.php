<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class OrderRepository extends EntityRepository
{
    public function findOrders(EntityManager $em)
    {
        $qb = $em->createQueryBuilder();
        $qb->select('o.id, 
                     o.products, 
                     o.status, 
                     o.price'
            )
            ->from('App\Entity\Order', 'o');

        return $query->getResult();
    }
}
