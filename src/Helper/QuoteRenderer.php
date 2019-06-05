<?php

namespace Refacto\TechnicalTest\Helper;

use Refacto\TechnicalTest\Entity\Quote;

class QuoteRenderer
{

    public static function toHtml(Quote $quote)
    {
        return '<p>' . $quote->getId() . '</p>';
    }

    public static function toText(Quote $quote)
    {
        return (string) $quote->getId();
    }
}