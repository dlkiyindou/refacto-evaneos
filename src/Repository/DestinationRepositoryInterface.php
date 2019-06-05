<?php

namespace Refacto\Test\Repository;

use Refacto\Test\Entity\Destination;

interface DestinationRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id);
}