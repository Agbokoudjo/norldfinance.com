<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

trait CrudTrait{
    public function add(object $entity, bool $flush = false):void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

    }
    

   
}