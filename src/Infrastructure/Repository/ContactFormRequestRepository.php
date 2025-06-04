<?php
namespace App\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Contact\ContactFormRepositoryInterface;
use App\Domain\Contact\ContactFormRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ContactFormRequest>
 */
final class ContactFormRequestRepository extends ServiceEntityRepository implements ContactFormRepositoryInterface
{
    use CrudTrait;
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, ContactFormRequest::class);
    }
}
