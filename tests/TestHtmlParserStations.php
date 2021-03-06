<?php

/**
 * User: ms
 * Date: 01.09.15
 * Time: 22:04
 */
namespace tests;

use  Mvg\Parser\Html\Stations;
use Mvg\TextOutput\Stations as TextOutputStations;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

class TestParserStations extends \PHPUnit_Framework_TestCase {
	const RESPONSE_FOR_TEST_KARL = 'testStationsKarl.html';

	public function testWithResults() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_KARL;
		$response = utf8_encode(file_get_contents($file));

		$stationParser = new Stations($response);
		$stations = $stationParser->getStationsForTerm();
		$this->assertCount(35, $stations);

	}


}
