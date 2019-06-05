<?php

namespace Refacto\Test\Context;

use Faker\Factory;
use Refacto\Test\Entity\Site;
use Refacto\Test\Entity\User;
use Refacto\Test\Helper\SingletonTrait;

class ApplicationContext
{
    use SingletonTrait;

    /**
     * @var Site
     */
    private $currentSite;
    /**
     * @var User
     */
    private $currentUser;

    private function __construct()
    {
        $faker = Factory::create();
        $this->currentSite = new Site($faker->randomNumber(), $faker->url);
        $this->currentUser = new User($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
    }

    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
