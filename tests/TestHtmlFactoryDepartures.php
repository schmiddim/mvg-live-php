<?php
/**
 * User: ms
 * Date: 01.09.15
 * Time: 22:09
 */
namespace tests;
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use  Mvg\Parser\Html\Departures;
use Mvg\Factories\Departures as DeparturesFactory;


class TestHtmlFactoryDepartures extends \PHPUnit_Framework_TestCase {
	const RESPONSE_FOR_TEST_WITH_RESULTS = 'testWithResults.html';
	const RESPONSE_FOR_TEST_WITHOUT_RESULTS = 'testWithoutResults.html';

	public function testWithResultsAndWithoutFilter() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITH_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('Karl-Theodor-Straße', $parser->getStation());
		$this->assertEquals('21:46', $parser->getCurrentTime());

		$factory = new DeparturesFactory($parser);


		$departures = $factory->getItems();

		$this->assertEquals('Karl-Theodor-Straße', $factory->getStation());
		$this->assertEquals('21:46', $factory->getCurrentTime());
		$firstDeparture = new \stdClass();
		$firstDeparture->lineNumber = "12";
		$firstDeparture->destination = "Romanplatz";
		$firstDeparture->time = "6";

		$this->assertEquals($firstDeparture->lineNumber, $departures[0]->lineNumber);
		$this->assertEquals($firstDeparture->destination, $departures[0]->destination);
		$this->assertEquals($firstDeparture->time, $departures[0]->time);


	}

	public function testWithResultsAndWFilter() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITH_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('Karl-Theodor-Straße', $parser->getStation());
		$this->assertEquals('21:46', $parser->getCurrentTime());

		$factory = new DeparturesFactory($parser);


		$departures = $factory->getItems('Romanplatz');

		$this->assertEquals('Karl-Theodor-Straße', $factory->getStation());
		$this->assertEquals('21:46', $factory->getCurrentTime());
		$firstDeparture = new \stdClass();
		$firstDeparture->lineNumber = "12";
		$firstDeparture->destination = "Romanplatz";
		$firstDeparture->time = "6";
		$this->assertCount(3, $departures);
		$this->assertEquals($firstDeparture->lineNumber, $departures[0]->lineNumber);
		$this->assertEquals($firstDeparture->destination, $departures[0]->destination);
		$this->assertEquals($firstDeparture->time, $departures[0]->time);

	}

	/**
	 * Test multiple Filters
	 */
	public function testArrayFilter(){
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITH_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('Karl-Theodor-Straße', $parser->getStation());
		$this->assertEquals('21:46', $parser->getCurrentTime());
		$factory = new DeparturesFactory($parser);
		$departures = $factory->getItems(['Romanplatz','Sendlinger Tor' ]);
		$this->assertCount(4, $departures);


	}
	public function testWithOuthResultsAndWithFilter() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITHOUT_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('', $parser->getStation());
		$this->assertEquals('', $parser->getCurrentTime());

		$factory = new DeparturesFactory($parser);


		$departures = $factory->getItems('Romanplatz');

		$this->assertEquals('', $factory->getStation());
		$this->assertEquals('', $factory->getCurrentTime());
		$this->assertCount(0, $departures);

	}

	public function testWithOuthResultsAndWithoutFilter() {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . self::RESPONSE_FOR_TEST_WITHOUT_RESULTS;
		$response = utf8_encode(file_get_contents($file));
		$parser = new Departures($response);

		$this->assertEquals('', $parser->getStation());
		$this->assertEquals('', $parser->getCurrentTime());

		$factory = new DeparturesFactory($parser);


		$departures = $factory->getItems();

		$this->assertEquals('', $factory->getStation());
		$this->assertEquals('', $factory->getCurrentTime());
		$this->assertCount(0, $departures);

	}
}
