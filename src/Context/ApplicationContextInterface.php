<?php

namespace Refacto\Test\Context;

interface ApplicationContextInterface
{
    public function getCurrentSite();

    public function getCurrentUser();
}