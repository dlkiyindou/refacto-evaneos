<?php

namespace Refacto\Test\Repository;

interface QuoteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id);
}