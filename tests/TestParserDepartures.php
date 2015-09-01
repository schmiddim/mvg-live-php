<?php
/**
 * User: ms
 * Date: 01.09.15
 * Time: 21:41
 */
namespace tests;

use Mvg\Parser\Departures;


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

class TestParserDepartures extends \PHPUnit_Framework_TestCase {

	const RESPONSE_FOR_TEST_WITH_RESULTS = 'testWithResults.html';
	const RESPONSE_FOR_TEST_WITHOUT_RESULTS = 'testWithoutResults.html';


	public function testWithResults() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test-assets' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITH_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('Karl-Theodor-Straße', $parser->getStation());
		$this->assertEquals('21:46', $parser->getCurrentTime());


		$departures = $parser->getDepartures();
		$this->assertCount(11, $departures);

		$firstDeparture = new stdClass();
		$firstDeparture->lineNumber = "12";
		$firstDeparture->destination = "Scheidplatz";
		$firstDeparture->time = "8";

		$this->assertEquals($firstDeparture->lineNumber, $departures[0]->lineNumber);
		$this->assertEquals($firstDeparture->destination, $departures[0]->destination);
		$this->assertEquals($firstDeparture->time, $departures[0]->time);

	}

	public function testWithoutResults() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test-assets' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITHOUT_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);
		$departures = $parser->getDepartures();
		$this->assertEquals('', $parser->getStation());
		$this->assertEquals('', $parser->getCurrentTime());
		$this->assertCount(0, $departures);
	}
}
