<?php

/**
 * User: ms
 * Date: 14.09.15
 * Time: 21:06
 */

namespace tests;

use \ Mvg\Parser\Html\NewsTicker as NewsTickerParser;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

class TestNewsTicker extends \PHPUnit_Framework_TestCase {

	const RESPONSE_1_RESULTS_2 = 'newsTickerServiceResponse2';
	const RESPONSE_2_RESULTS_2 = 'newsTickerServiceResponse1';
	const RESPONSE_3_RESULT_1 = 'newsTickerServiceResponse1Item';
	const FIXTURE_FOLDER = 'fixtures';

	/**
	 * @param $fileName
	 * @return string
	 */
	protected static function getResponse($fileName) {
		$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . self::FIXTURE_FOLDER . DIRECTORY_SEPARATOR . $fileName;
		return file_get_contents($file);
	}

	public function test2Results1() {
		$response = self::getResponse(self::RESPONSE_1_RESULTS_2);
		$newsTickerParser = new NewsTickerParser($response);
		$interferences = $newsTickerParser->getInterferences();
		$this->assertCount(2, $interferences);
		$this->assertEquals('Linie(n) 58, 100: Umleitung im Bereich Hauptbahnhof', $interferences[0]->lines);
		$this->assertEquals('Linie(n) 27, 28, 100: Behinderungen wegen Großdemonstration', $interferences[1]->lines);

		$this->assertCount(3,$interferences[1]->affectedLines);
		$this->assertEquals('27', $interferences[1]->affectedLines[0]);
		$this->assertEquals('28', $interferences[1]->affectedLines[1]);
	}

	public function test2Results2() {
		$response = self::getResponse(self::RESPONSE_2_RESULTS_2);
		$newsTickerParser = new NewsTickerParser($response);
		$interferences = $newsTickerParser->getInterferences();
		$this->assertCount(2, $interferences);
		$this->assertEquals('Linie(n) 58, 100: Umleitung im Bereich Hauptbahnhof', $interferences[0]->lines);
		$this->assertEquals('Linie(n) 27, 28, 100: Behinderungen wegen Großdemonstration', $interferences[1]->lines);
		$this->assertCount(2,$interferences[0]->affectedLines);
		$this->assertEquals('58', $interferences[0]->affectedLines[0]);
		$this->assertEquals('100', $interferences[0]->affectedLines[1]);

		$this->assertCount(3,$interferences[1]->affectedLines);
		$this->assertEquals('27', $interferences[1]->affectedLines[0]);
		$this->assertEquals('28', $interferences[1]->affectedLines[1]);
	}

	public function test1Result() {
		$response = self::getResponse(self::RESPONSE_3_RESULT_1);
		$newsTickerParser = new NewsTickerParser($response);
		$interferences = $newsTickerParser->getInterferences();
		$this->assertCount(1, $interferences);
		$this->assertEquals('Linie(n) 58, 100: Umleitung im Bereich Hauptbahnhof', $interferences[0]->lines);


		$this->assertCount(2,$interferences[0]->affectedLines);
		$this->assertEquals('58', $interferences[0]->affectedLines[0]);
		$this->assertEquals('100', $interferences[0]->affectedLines[1]);
	}
}
