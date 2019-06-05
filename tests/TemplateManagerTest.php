<?php

use Faker\Factory;
use Refacto\Test\Context\ApplicationContext;
use Refacto\Test\Repository\DestinationRepository;
use Refacto\Test\Repository\QuoteRepository;
use Refacto\Test\Repository\SiteRepository;
use Refacto\Test\TemplateManager;
use Refacto\Test\Entity\Quote;
use Refacto\Test\Entity\Template;

class TemplateManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Init the mocks
     */
    public function setUp()
    {
    }

    /**
     * Closes the mocks
     */
    public function tearDown()
    {
    }

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

        $expectedDestination = DestinationRepository::getInstance()->getById($faker->randomNumber());
        $expectedUser = ApplicationContext::getInstance()->getCurrentUser();

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

        $this->assertEquals('Votre voyage avec une agence locale ' . $expectedDestination->countryName, $message->subject);
        $this->assertEquals("
Bonjour " . $expectedUser->firstname . ",

Merci d'avoir contacté un agent local pour votre voyage " . $expectedDestination->countryName . ".

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
", $message->content);
    }
}
