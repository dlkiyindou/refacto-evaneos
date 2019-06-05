<?php

namespace Refacto\Test\Repository;

use Refacto\Test\Entity\Site;

interface SiteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id);
}