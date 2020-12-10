<?php declare(strict_types=1);

namespace Pts\Lib;

use Symfony\Component\DomCrawler\Crawler;

final class BracketExtractor
{

    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function itemCount(): int
    {
        return (int) $this->crawler->filter('.count > .bag-count')->text();
    }
}
