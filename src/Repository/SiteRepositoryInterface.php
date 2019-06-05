<?php

namespace Refacto\Test\Repository;

interface SiteRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id);
}