<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 11:00
 */

namespace Mvg\TextOutput;


use Mvg\Parser\Departures as DepaturesParser;
/**
 * Class Departures
 * @package Mvg
 */
class Departures {

	/**
	 * @var Departures
	 */
	protected $departuresParser = null;

	/**
	 * @param DepaturesParser $departuresParser
	 */
	public function __construct(DepaturesParser $departuresParser) {
		$this->setDeparturesParser($departuresParser);
	}

	/**
	 * @return Departures
	 */
	protected function getDeparturesParser() {
		return $this->departuresParser;
	}


	/**
	 * @param Departures $departuresParser
	 */
	protected function setDeparturesParser(DepaturesParser $departuresParser) {
		$this->departuresParser = $departuresParser;
	}

	public function getOutput() {
		$maxLenLineNumber = 0;
		$maxLenDestination = 0;
		$maxLenTime = 0;
		foreach ($this->getDeparturesParser()->getDepartures() as $departureObject) {

			if (strlen($departureObject->lineNumber) > $maxLenLineNumber) {
				$maxLenLineNumber = strlen($departureObject->lineNumber);
			}

			if (strlen($departureObject->destination) > $maxLenDestination) {
				$maxLenDestination = strlen($departureObject->destination);
			}
			if (strlen($departureObject->time) > $maxLenTime) {
				$maxLenTime = strlen($departureObject->time);
			}
		}
		$str = '';
		foreach ($this->getDeparturesParser()->getDepartures() as $departureObject) {
			$str .= str_pad($departureObject->lineNumber, $maxLenLineNumber + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->destination, $maxLenDestination + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->time, $maxLenTime + 3, ' ', STR_PAD_RIGHT);
			$str .= "\n";
		}
		return $str;
	}


}