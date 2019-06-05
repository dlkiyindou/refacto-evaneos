<?php

namespace Refacto\Test\Repository;

use Refacto\Test\Entity\Quote;
use Refacto\Test\Helper\SingletonTrait;
use Faker; // cause of "DO NOT MODIFY THIS METHOD"
use DateTime; // cause of "DO NOT MODIFY THIS METHOD"

class QuoteRepository implements Repository
{
    use SingletonTrait;

    private $siteId;
    private $destinationId;
    private $date;

    /**
     * QuoteRepository constructor.
     */
    private function __construct()
    {
        // DO NOT MODIFY THIS METHOD
        $generator = Faker\Factory::create();

        $this->siteId = $generator->numberBetween(1, 10);
        $this->destinationId = $generator->numberBetween(1, 200);
        $this->date = new DateTime();
    }

    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Quote(
            $id,
            $this->siteId,
            $this->destinationId,
            $this->date
        );
    }
}
