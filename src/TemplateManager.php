<?php

namespace Refacto\TechnicalTest;

use Refacto\TechnicalTest\Context\ApplicationContextInterface;
use Refacto\TechnicalTest\Entity\Quote;
use Refacto\TechnicalTest\Entity\Template;
use Refacto\TechnicalTest\Entity\User;
use Refacto\TechnicalTest\Helper\QuoteRenderer;
use Refacto\TechnicalTest\Repository\DestinationRepositoryInterface;
use Refacto\TechnicalTest\Repository\QuoteRepositoryInterface;
use Refacto\TechnicalTest\Repository\SiteRepositoryInterface;

class TemplateManager
{
    /** @var ApplicationContextInterface */
    private $applicationContext;

    /** @var QuoteRepositoryInterface */
    private $quoteRepository;

    /** @var SiteRepositoryInterface */
    private $siteRepository;

    /** @var DestinationRepositoryInterface */
    private $destinationrepository;


    public function __construct(
        ApplicationContextInterface $applicationContext,
        QuoteRepositoryInterface $quoteRepository,
        SiteRepositoryInterface $siteRepository,
        DestinationRepositoryInterface $destinationRepository
    )
    {
        $this->applicationContext = $applicationContext;
        $this->quoteRepository = $quoteRepository;
        $this->siteRepository = $siteRepository;
        $this->destinationrepository = $destinationRepository;
    }

    /**
     * @param Template $tpl
     * @param array $data
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, array $data)
    {
        return new Template(
            $tpl->getId(),
            $this->computeText($tpl->getSubject(), $data),
            $this->computeText($tpl->getContent(), $data)
        );
    }

    /**
     * @param string $text
     * @param array $data
     * @return mixed|string
     */
    private function computeText($text, array $data)
    {
        /** @var Quote|null $quoteParam */
        $quoteParam = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;
        if (null !== $quoteParam)
        {
            // get entity from repository
            $quote = $this->quoteRepository->getById($quoteParam->getId());
            $site = $this->siteRepository->getById($quoteParam->getSiteId());
            $destination = $this->destinationrepository->getById($quoteParam->getDestinationId());

            // No need to search for these placeholders before replacing them
            // If they do not exist, they will not be replaced
            $text = str_replace('[quote:summary_html]', QuoteRenderer::toHtml($quote), $text);
            $text = str_replace('[quote:summary]', QuoteRenderer::toText($quote), $text);

            $text = str_replace('[quote:destination_link]', $site->getUrl() . '/' . $destination->getCountryName() . '/quote/' . $quote->getId(), $text);
            $text = str_replace('[quote:destination_name]', $destination->getCountryName(), $text);
        }

        /** @var $user */
        $user  = (isset($data['user'])  && ($data['user']  instanceof User))  ? $data['user']  : $this->applicationContext->getCurrentUser();
        $text = str_replace('[user:first_name]' , ucfirst(mb_strtolower($user->getFirstname())), $text);

        return $text;
    }
}
