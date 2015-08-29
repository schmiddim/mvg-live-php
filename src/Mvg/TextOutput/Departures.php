<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 11:00
 */

namespace Mvg\TextOutput;

/**
 * Class Departures
 * @package Mvg
 */
class Departures {

	/**
	 * @var \Mvg\Factories\Departures
	 */
	protected $departuresFactory = null;

	/**
	 * @param \Mvg\Factories\Departures $departuresFactory
	 */
	public function __construct($departuresFactory) {
		$this->setDeparturesFactory($departuresFactory);
	}

	/**
	 * @return \Mvg\Factories\Departures
	 */
	protected function getDeparturesFactory() {
		return $this->departuresFactory;
	}


	/**
	 * @param \Mvg\Factories\Departures $departuresFactory
	 */
	protected function setDeparturesFactory($departuresFactory) {
		$this->departuresFactory = $departuresFactory;
	}

	public function getOutput() {
		$maxLenLineNumber = 0;
		$maxLenDestination = 0;
		$maxLenTime = 0;
		foreach ($this->getDeparturesFactory()->getItems() as $departureObject) {

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
			$this->getDeparturesFactory()->getStation()
			, $this->getDeparturesFactory()->getCurrentTime()
		);

		$str .= "\n";

		foreach ($this->getDeparturesFactory()->getItems() as $departureObject) {
			$str .= str_pad($departureObject->lineNumber, $maxLenLineNumber + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->destination, $maxLenDestination + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->time, $maxLenTime + 3, ' ', STR_PAD_RIGHT);
			$str .= "\n";
		}
		return $str;
	}


}