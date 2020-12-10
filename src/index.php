<?php declare(strict_types=1);

use Pts\Lib\ProductScraper;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$testUrl  = 'https://www.shopdisney.co.uk/disney-store-disney-princess-costume-collection-for-kids-2841047080168M.html';
$testSize = '5-6 Y';

$scraper = new ProductScraper($testUrl, $testSize);
$scraper->execute();
