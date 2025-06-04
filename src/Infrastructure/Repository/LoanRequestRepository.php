<?php
namespace App\Infrastructure\Repository;

use App\Domain\LoanRequest\LoanRequest;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Repository\CrudTrait;
use App\Domain\LoanRequest\LoanRequestRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<LoanRequest>
 */
final class LoanRequestRepository extends ServiceEntityRepository implements LoanRequestRepositoryInterface
{
    use CrudTrait;
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, LoanRequest::class);
    }
}
