<?php

namespace Refacto\TechnicalTest\Context;

use Faker\Factory;
use Refacto\TechnicalTest\Entity\Site;
use Refacto\TechnicalTest\Entity\User;
use Refacto\TechnicalTest\Helper\SingletonTrait;

class ApplicationContext implements ApplicationContextInterface
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
