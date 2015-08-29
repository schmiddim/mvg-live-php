<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 11:00
 */

namespace Mvg;

/**
 * Class TextOutput
 * @package Mvg
 */
class TextOutput {

	/**
	 * @var array
	 */
	protected $departures = array();

	/**
	 * @param array $data
	 */
	public function __construct($data = array()) {
		$this->setDepartures($data);
	}

	/**
	 * @return array
	 */
	protected function getDepartures() {
		return $this->departures;
	}

	/**
	 * @param array $departures
	 */
	protected function setDepartures($departures) {
		$this->departures = $departures;
	}

	public function getOutput() {
		$maxLenLineNumber = 0;
		$maxLenDestination = 0;
		$maxLenTime = 0;

		foreach ($this->getDepartures() as $departureObject) {
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
		foreach ($this->getDepartures() as $departureObject) {
			$str .= str_pad($departureObject->lineNumber, $maxLenLineNumber + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->destination, $maxLenDestination + 3, ' ', STR_PAD_RIGHT);
			$str .= str_pad($departureObject->time, $maxLenTime + 3, ' ', STR_PAD_RIGHT);
			$str .= "\n";
		}
		return $str;
	}


}