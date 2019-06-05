<?php

namespace Refacto\Test\Helper;

use Refacto\Test\Entity\Quote;

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