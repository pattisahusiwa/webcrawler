<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pts\Lib\BracketExtractor;
use Symfony\Component\DomCrawler\Crawler;

final class BracketExtractorTest extends TestCase
{

    /** @var BracketExtractor */
    private $extractor;

    protected function setUp(): void
    {
        /** @var string */
        $content         = file_get_contents(dirname(__DIR__) . '/Data/step-03-01.html');
        $crawler         = new Crawler($content);
        $this->extractor = new BracketExtractor($crawler);
    }

    public function testShouldRetrieveItemCount()
    {
        $expected = 2;
        $this->assertSame($expected, $this->extractor->itemCount());
    }
}
