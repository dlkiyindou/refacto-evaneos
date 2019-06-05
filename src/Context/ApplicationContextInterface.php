<?php

namespace Refacto\TechnicalTest\Context;

interface ApplicationContextInterface
{
    public function getCurrentSite();

    public function getCurrentUser();
}