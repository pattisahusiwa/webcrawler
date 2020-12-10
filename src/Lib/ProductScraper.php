<?php declare(strict_types=1);

namespace Pts\Lib;

use Goutte\Client;

final class ProductScraper
{
    // phpcs:disable Generic.Files.LineLength.TooLong
    private const VARIATION = 'https://www.shopdisney.co.uk/on/demandware.store/Sites-disneyuk-Site/en_GB/Product-Variation';

    private $client;

    private $url;

    private $size;

    public function __construct(string $url, string $size)
    {
        $this->client = new Client();
        $this->url    = $url;
        $this->size   = $size;
    }

    public function execute()
    {
        printf("Sending request to %s\n", $this->url);
        $crawler = $this->client->request('GET', $this->url);

        printf("Extract product page\n");
        $page = new MainPageExtractor($crawler);

        printf("Select product size\n");
        $variation = $this->selectSize($page);

        printf("Add product to bag\n");
        $bag = $this->addToBag($variation);

        printf("Item in the bag: %d\n", $bag->itemCount());
    }

    private function selectSize(MainPageExtractor $page): VariationExtractor
    {
        $sizeData = $page->getSizeByText($this->size);

        $queries['format']          = 'ajax';
        $queries['csrf_token']      = $page->csrfToken();
        $queries['pid']             = $page->pid();
        $queries[$sizeData['name']] = $sizeData['value'];
        $queries['_']               = $this->timestamp();

        $url = self::VARIATION . '?' . http_build_query($queries);

        $crawler = $this->client->request('GET', $url);
        return new VariationExtractor($crawler);
    }

    private function addToBag(VariationExtractor $variation): BracketExtractor
    {
        $url = $variation->actionUrl();

        $queries['format']     = 'ajax';
        $queries['Quantity']   = $variation->quantity();
        $queries['pid']        = $variation->pid();
        $queries['csrf_token'] = $variation->csrfToken();

        $crawler = $this->client->xmlHttpRequest('POST', $url, $queries);
        return new BracketExtractor($crawler);
    }

    private function timestamp(): int
    {
        return (int) round(microtime(true) * 1000);
    }
}
