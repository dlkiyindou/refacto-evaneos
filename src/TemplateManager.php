<?php

namespace Refacto\Test;

use Refacto\Test\Context\ApplicationContext;
use Refacto\Test\Entity\Quote;
use Refacto\Test\Entity\Template;
use Refacto\Test\Entity\User;
use Refacto\Test\Repository\DestinationRepository;
use Refacto\Test\Repository\QuoteRepository;
use Refacto\Test\Repository\SiteRepository;
use Refacto\Test\Helper\QuoteRenderer;

class TemplateManager
{
    /** @var ApplicationContext */
    private $applicationContext;

    /** @var QuoteRepository */
    private $quoteRepository;

    /** @var SiteRepository */
    private $siteRepository;

    /** @var DestinationRepository */
    private $destinationrepository;


    public function __construct(
        ApplicationContext $applicationContext,
        QuoteRepository $quoteRepository,
        SiteRepository $siteRepository,
        DestinationRepository $destinationRepository
    )
    {
        $this->applicationContext = $applicationContext;
        $this->quoteRepository = $quoteRepository;
        $this->siteRepository = $siteRepository;
        $this->destinationrepository = $destinationRepository;
    }

    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    /**
     * @param string $text
     * @param array $data
     * @return mixed|string
     */
    private function computeText($text, array $data)
    {
        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;
        if ($quote)
        {
            $quoteFromRepository = $this->quoteRepository->getById($quote->id);
            $site = $this->siteRepository->getById($quote->siteId);
            $destination = $this->destinationrepository->getById($quote->destinationId);

            $text = str_replace('[quote:summary_html]', QuoteRenderer::toHtml($quoteFromRepository), $text);
            $text = str_replace('[quote:summary]', QuoteRenderer::toText($quoteFromRepository), $text);

            $text = str_replace('[quote:destination_link]', $site->url . '/' . $destination->countryName . '/quote/' . $quoteFromRepository->id, $text);
            $text = str_replace('[quote:destination_name]', $destination->countryName, $text);
        }

        /** @var $user */
        $user  = (isset($data['user'])  && ($data['user']  instanceof User))  ? $data['user']  : $this->applicationContext->getCurrentUser();
        $text = str_replace('[user:first_name]' , ucfirst(mb_strtolower($user->firstname)), $text);

        return $text;
    }
}
