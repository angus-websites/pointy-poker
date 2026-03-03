<?php

namespace App\Contracts\Repository;

/**
 * Interface for repositories that handle entities identified by a code.
 */
interface CodeRepositoryInterface
{
    public function findByCode(string $code);
}
