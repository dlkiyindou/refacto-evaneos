<?php

namespace Refacto\TechnicalTest\Repository;

use Refacto\TechnicalTest\Entity\Site;

interface SiteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id);
}