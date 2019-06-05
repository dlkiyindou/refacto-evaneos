<?php

namespace Refacto\Test\Repository;

use Faker; // cause of "DO NOT MODIFY THIS METHOD"
use Refacto\Test\Entity\Site;
use Refacto\Test\Helper\SingletonTrait;


class SiteRepository implements SiteRepositoryInterface
{
    use SingletonTrait;

    private $url;

    /**
     * SiteRepository constructor.
     *
     */
    public function __construct()
    {
        // DO NOT MODIFY THIS METHOD
        $this->url = Faker\Factory::create()->url;
    }

    /**
     * @param int $id
     *
     * @return Site
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Site($id, $this->url);
    }
}
