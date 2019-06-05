<?php

use Faker\Factory;
use Refacto\TechnicalTest\Context\ApplicationContext;
use Refacto\TechnicalTest\Entity\Quote;
use Refacto\TechnicalTest\Entity\Template;
use Refacto\TechnicalTest\Repository\DestinationRepository;
use Refacto\TechnicalTest\Repository\QuoteRepository;
use Refacto\TechnicalTest\Repository\SiteRepository;
use Refacto\TechnicalTest\TemplateManager;

class TemplateManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $applicationContext = ApplicationContext::getInstance();
        $quoteRepository = QuoteRepository::getInstance();
        $siteRepository = SiteRepository::getInstance();
        $destinationRepository = DestinationRepository::getInstance();

        $templateManager = new TemplateManager($applicationContext, $quoteRepository, $siteRepository, $destinationRepository);

        $faker = Factory::create();
        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date());

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

        $message = $templateManager->getTemplateComputed($template, ['quote' => $quote]);

        ////////////// Expected
        $expectedDestination = DestinationRepository::getInstance()->getById($faker->randomNumber());
        $expectedUser = ApplicationContext::getInstance()->getCurrentUser();

        $this->assertEquals('Votre voyage avec une agence locale ' . $expectedDestination->getCountryName(), $message->getSubject());
        $this->assertEquals("
Bonjour " . $expectedUser->getFirstname() . ",

Merci d'avoir contacté un agent local pour votre voyage " . $expectedDestination->getCountryName() . ".

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
", $message->getContent());
    }
}
