<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pts\Lib\VariationExtractor;
use Symfony\Component\DomCrawler\Crawler;

final class VariationExtractorTest extends TestCase
{

    /** @var VariationExtractor */
    private $extractor;

    protected function setUp(): void
    {
        /** @var string */
        $content         = file_get_contents(dirname(__DIR__) . '/Data/step-02.html');
        $crawler         = new Crawler($content);
        $this->extractor = new VariationExtractor($crawler);
    }

    public function testShouldRetrieveActionUrl()
    {
        $expected = 'https://www.shopdisney.co.uk/on/demandware.store/Sites-disneyuk-Site/en_GB/Cart-AddProduct';
        $this->assertSame($expected, $this->extractor->actionUrl());
    }

    public function testShouldRetrieveCsrfToken()
    {
        // phpcs:disable Generic.Files.LineLength.TooLong
        $expected = '4ySeG_CZ0MR07ztI8sZ_2rqev1lI3Ngp_gt5c4LE-JFT0ait3B5HYP6HWwZmN56ATIgbcPbuev6ZnznHSbNILikAdMe-tNk8blW6vMfHaMJLxm7zthEmzYE699Vl6Ybbx34eKD6kNuTSANqrGKvdydWRqQt02wXYCOgbkfg7dzcCr_0bJSk=';
        $this->assertSame($expected, $this->extractor->csrfToken());
    }

    public function testShouldRetrieveQuantity()
    {
        $expected = 1;
        $this->assertSame($expected, $this->extractor->quantity());
    }

    public function testShouldRetrievePID()
    {
        $expected = '428411448899';
        $this->assertSame($expected, $this->extractor->pid());
    }
}
