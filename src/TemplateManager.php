<?php

namespace Refacto\Test;

use Refacto\Test\Context\ApplicationContextInterface;
use Refacto\Test\Entity\Quote;
use Refacto\Test\Entity\Template;
use Refacto\Test\Entity\User;
use Refacto\Test\Helper\QuoteRenderer;
use Refacto\Test\Repository\DestinationRepositoryInterface;
use Refacto\Test\Repository\QuoteRepositoryInterface;
use Refacto\Test\Repository\SiteRepositoryInterface;

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

            // No need to look for these reasons before replacing them
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
