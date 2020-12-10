<?php declare(strict_types=1);

namespace Pts\Lib;

use Symfony\Component\DomCrawler\Crawler;

final class VariationExtractor
{

    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function actionUrl(): string
    {
        return $this->crawler->filter('form')->attr('action');
    }

    public function csrfToken(): string
    {
        return $this->crawler->filter('input.csrftoken')->attr('value');
    }

    public function quantity(): int
    {
        return (int) $this->crawler->filter('input[name="Quantity"]')->attr('value');
    }

    public function pid(): string
    {
        return $this->crawler->filter('#pid')->attr('data-variant-id');
    }
}
