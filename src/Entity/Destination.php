<?php

namespace Refacto\TechnicalTest\Entity;

class Destination
{
    private $id;
    private $countryName;
    private $conjunction;
    private $computerName;

    public function __construct($id, $countryName, $conjunction, $computerName)
    {
        $this->id = $id;
        $this->countryName = $countryName;
        $this->conjunction = $conjunction;
        $this->computerName = $computerName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return mixed
     */
    public function getConjunction()
    {
        return $this->conjunction;
    }

    /**
     * @return mixed
     */
    public function getComputerName()
    {
        return $this->computerName;
    }
}
