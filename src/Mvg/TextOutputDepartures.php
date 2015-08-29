<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 11:00
 */

namespace Mvg;

/**
 * Class TextOutputDepartures
 * @package Mvg
 */
class TextOutputDepartures {

	/**
	 * @var DeparturesParser
	 */
	protected $departuresParser = null;

	/**
	 * @param DeparturesParser $departuresParser
	 */
	public function __construct($departuresParser) {
		$this->setDeparturesParser($departuresParser);
	}

	/**
	 * @return DeparturesParser
	 */
	protected function getDeparturesParser() {
		return $this->departuresParser;
	}


	/**
	 * @param DeparturesParser $departuresParser
	 */
	protected function setDeparturesParser(DeparturesParser $departuresParser) {
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