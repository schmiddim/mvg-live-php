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
	 * @var mixed
	 */
	protected $filter = null;

	/**
	 * @param \Mvg\Factories\Departures $departuresFactory
	 * @param mixed $filter
	 */
	public function __construct($departuresFactory, $filter = null) {
		$this->setDeparturesFactory($departuresFactory);
		$this->setFilter($filter);
	}

	/**
	 * @return mixed
	 */
	protected function getFilter() {
		return $this->filter;
	}

	/**
	 * @param mixed $filter
	 */
	protected function setFilter($filter) {
		$this->filter = $filter;
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

	/**
	 * found here http://stackoverflow.com/a/11871948
	 * @param $input
	 * @param $pad_length
	 * @param string $pad_string
	 * @param int $pad_type
	 * @return string
	 */
	public static function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT) {
		mb_internal_encoding('utf-8'); // @important
		$diff = strlen($input) - mb_strlen($input);
		return str_pad($input, $pad_length + $diff, $pad_string, $pad_type);
	}

	public function getOutput() {
		$maxLenLineNumber = 0;
		$maxLenDestination = 0;
		$maxLenTime = 0;
		$departuresItems = $this->getDeparturesFactory()->getItems($this->getFilter());
		foreach ($departuresItems as $departureObject) {

			if (mb_strlen($departureObject->lineNumber) > $maxLenLineNumber) {
				$maxLenLineNumber = mb_strlen($departureObject->lineNumber);
			}

			if (mb_strlen($departureObject->destination) > $maxLenDestination) {
				$maxLenDestination = mb_strlen($departureObject->destination);
			}
			if (mb_strlen($departureObject->time) > $maxLenTime) {
				$maxLenTime = mb_strlen($departureObject->time);
			}
		}
		$str = sprintf('Abfahrtzeiten %s %s',
			$this->getDeparturesFactory()->getStation()
			, $this->getDeparturesFactory()->getCurrentTime()
		);

		$str .= "\n";

		foreach ($departuresItems as $departureObject) {
			$str .= self::mb_str_pad($departureObject->lineNumber, $maxLenLineNumber + 3, ' ', STR_PAD_RIGHT);
			$str .= self::mb_str_pad($departureObject->destination, $maxLenDestination + 3, ' ', STR_PAD_RIGHT);
			$str .= self::mb_str_pad($departureObject->time, $maxLenTime + 3, ' ', STR_PAD_RIGHT);
			$str .= "\n";
		}
		return $str;
	}


}