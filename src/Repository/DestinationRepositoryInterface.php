<?php

namespace Refacto\TechnicalTest\Repository;

use Refacto\TechnicalTest\Entity\Destination;

interface DestinationRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id);
}