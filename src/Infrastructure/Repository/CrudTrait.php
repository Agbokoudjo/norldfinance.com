<?php
namespace App\Infrastructure\Repository;

use Doctrine\DBAL\LockMode;

trait CrudTrait{
    public function add(object $entity, bool $flush = false):object
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $entity;
    }
    public function remove(object|int $entityOrId): void{

    }
    public function update(object $entityOld, object|array $newData): object{
        return $entityOld;
    }
    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?object{
        return null;
    }
}