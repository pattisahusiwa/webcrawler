<?php declare(strict_types=1);

namespace Pts\Lib;

use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

final class MainPageExtractor
{

    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function csrfToken(): string
    {
        return $this->crawler->filter('input.csrftoken')->attr('value');
    }

    public function pid(): string
    {
        return $this->crawler->filter('#pid')->attr('value');
    }

    /**
     * @return array{name: string, value: string}
    */
    public function getSizeByText(string $text): array
    {
        $btn = $this->getButton($text);
        return [
                'name'  => $btn->attr('data-name'),
                'value' => $btn->attr('data-value')
               ];
    }

    private function getButton(string $text): Crawler
    {
        $buttons = $this->crawler->filter('#va-size > button');
        $idx     = 0;
        $count   = $buttons->count();
        for ($idx = 0; $idx < $count; $idx++) {
            if ($buttons->eq($idx)->text() === $text) {
                return $buttons->eq($idx);
            }
        }

        throw new InvalidArgumentException('Cannot find button with text ' . $text);
    }
}
