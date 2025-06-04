<?php
namespace App\Domain\SharedRepository;

use Doctrine\DBAL\LockMode;

interface EntityRepositoryInterface{
    public function add(object $entity,bool $flush=false):object;
    public function remove(object|int $entityOrId): void;
    public function update(object $entityOld,object|array $newData):object;
    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null):?object;
}