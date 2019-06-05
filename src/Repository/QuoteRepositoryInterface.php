<?php

namespace Refacto\TechnicalTest\Repository;

use Refacto\TechnicalTest\Entity\Quote;

interface QuoteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id);
}