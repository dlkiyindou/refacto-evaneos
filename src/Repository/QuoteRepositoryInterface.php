<?php

namespace Refacto\Test\Repository;

use Refacto\Test\Entity\Quote;

interface QuoteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id);
}