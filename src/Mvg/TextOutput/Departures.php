<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 11:00
 */

namespace Mvg\TextOutput;


use Mvg\Parser\Departures as DeparturesParser;

/**
 * Class Departures
 * @package Mvg
 */
class Departures {

	/**
	 * @var \Mvg\Parser\Departures
	 */
	protected $departuresParser = null;

	/**
	 * @param \Mvg\Parser\Departures $departuresParser
	 */
	public function __construct($departuresParser) {
		$this->setDeparturesParser($departuresParser);
	}

	/**
	 * @return \Mvg\Parser\Departures
	 */
	protected function getDeparturesParser() {
		return $this->departuresParser;
	}


	/**
	 * @param \Mvg\Parser\Departures $departuresParser
	 */
	protected function setDeparturesParser($departuresParser) {
		$this->departuresParser = $departuresParser;
	}

	public function getOutput() {
		$maxLenLineNumber = 0;
		$maxLenDestination = 0;
		$maxLenTime = 0;
		foreach ($this->getDeparturesParser()->getItems() as $departureObject) {

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
		$str = sprintf('Abfahrtzeiten %s %s',
			$this->getDeparturesParser()->getStation()
			, $this->getDeparturesParser()->getCurrentTime()
		);

		$str .= "\n";

		foreach ($this->getDeparturesParser()->getItems() as $departureObject) {
			$str .= str_pad($departureObject->lineNumber, $maxLenLineNumber + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->destination, $maxLenDestination + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->time, $maxLenTime + 3, ' ', STR_PAD_RIGHT);
			$str .= "\n";
		}
		return $str;
	}


}