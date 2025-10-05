<?php

declare(strict_types=1);
namespace App\Domain\LoanRequest;

use App\Domain\LoanRequest\LoanRequest;

interface LoanRequestRepositoryInterface {

    public function add(LoanRequest $entity, bool $flush = false): void;
}