<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Factory;
use Refacto\Test\Context\ApplicationContext;
use Refacto\Test\Entity\Quote;
use Refacto\Test\Entity\Template;
use Refacto\Test\Repository\DestinationRepository;
use Refacto\Test\Repository\QuoteRepository;
use Refacto\Test\Repository\SiteRepository;
use Refacto\Test\TemplateManager;

$applicationContext = ApplicationContext::getInstance();
$quoteRepository = QuoteRepository::getInstance();
$siteRepository = SiteRepository::getInstance();
$destinationRepository = DestinationRepository::getInstance();

$templateManager = new TemplateManager($applicationContext, $quoteRepository, $siteRepository, $destinationRepository);
$faker = Factory::create();

$template = new Template(
    1,
    'Votre voyage avec une agence locale [quote:destination_name]',
    "
Bonjour [user:first_name],

Merci d'avoir contacté un agent local pour votre voyage [quote:destination_name].

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
");


$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date())
    ]
);

echo $message->getSubject() . "\n" . $message->getContent();
