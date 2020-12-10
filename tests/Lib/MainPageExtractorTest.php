<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pts\Lib\MainPageExtractor;
use Symfony\Component\DomCrawler\Crawler;

final class MainPageExtractorTest extends TestCase
{

    /** @var MainPageExtractor */
    private $page;

    protected function setUp(): void
    {
        /** @var string */
        $content    = file_get_contents(dirname(__DIR__) . '/Data/step-01.html');
        $crawler    = new Crawler($content);
        $this->page = new MainPageExtractor($crawler);
    }

    public function testShouldRetrieveCsrfToken()
    {
        // phpcs:disable Generic.Files.LineLength.TooLong
        $expected = 'FVD1i9kUnAtDF5uoAb2AOUXQ-4Htb0brbdiUTzNehXSU47l4k6m9oqSpdmJoI-iSeXWNSUXjD1HsyggDi8ytP6TPugeZQZzAUyf5fMI1Ra5o1EONIt3bGXmn5p03oxbP-GgxxvT_quYARbQH81B_I8Vb0HZF4VedZ1ryNj_F4FzSXJhLNvg=';
        $this->assertSame($expected, $this->page->csrfToken());
    }

    public function testShouldRetrieveFormPID()
    {
        $expected = '2841047080168M';
        $this->assertSame($expected, $this->page->pid());
    }

    public function testRetrieveInvalidButtonText()
    {
        $text = 'not-found';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot find button with text ' . $text);

        $this->page->getSizeByText($text);
    }

    public function testRetrieveSizeValues()
    {
        $value = '5-6 YEARS';
        $name  = 'dwvar_2841047080168M_size';

        $data = $this->page->getSizeByText('5-6 Y');

        $this->assertSame($name, $data['name']);
        $this->assertSame($value, $data['value']);
    }
}
