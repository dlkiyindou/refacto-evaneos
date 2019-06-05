<?php

namespace Refacto\Test\Repository;

interface DestinationRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id);
}