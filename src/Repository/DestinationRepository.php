<?php

namespace Refacto\TechnicalTest\Repository;

use Faker\Factory;
use Refacto\TechnicalTest\Entity\Destination;
use Refacto\TechnicalTest\Helper\SingletonTrait;

class DestinationRepository implements DestinationRepositoryInterface
{
    use SingletonTrait;

    private $country;
    private $conjunction;
    private $computerName;

    /**
     * DestinationRepository constructor.
     */
    private function __construct()
    {
        $this->country = Factory::create()->country;
        $this->conjunction = 'en';
        $this->computerName = Factory::create()->slug();
    }

    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Destination(
            $id,
            $this->country,
            $this->conjunction,
            $this->computerName
        );
    }
}
