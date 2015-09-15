<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 21:15
 */
namespace Mvg\Factories;


use Mvg\Parser\Departures as ParserDepartures;

class Departures implements FactoryInterface {
	/**
	 * @var ParserDepartures null
	 */
	protected $parserDepartures = null;

	/**
	 * @var array
	 */
	protected $departures = array();

	public function __construct(ParserDepartures $parserDepartures) {
		$this->setParserDepartures($parserDepartures);
		$this->departures = $parserDepartures->getDepartures();
		usort($this->departures, array("Mvg\Factories\Departures", "cmpObjects"));

	}

	protected static function cmpObjects($a, $b) {

		if ($a->time === $b->time) {
			return 0;
		}
		return ($a->time > $b->time) ? +1 : -1;
	}

	/**
	 * Filter By Destination
	 * @param mixed $filter
	 * @return array
	 */
	public function getItems($filter = '') {
		if ('' === $filter) {
			return $this->departures;
		}
		if (null === $filter) {
			return $this->departures;
		}

		if (false === is_array($filter)) {
			$filter = [$filter];
		}

		$departures = array();

		foreach ($this->departures as $departure) {
			if (true === in_array($departure->destination, $filter)) {
				$departures[] = $departure;
			}
		}
		return $departures;
	}

	/**
	 * @return string
	 */
	public function getCurrentTime() {
		return $this->parserDepartures->getCurrentTime();
	}

	/**
	 * @return string
	 */
	public function getStation() {
		return $this->parserDepartures->getStation();
	}

	/**
	 * @return array
	 */
	protected function getParserDepartures() {
		return $this->parserDepartures;
	}

	/**
	 * @param ParserDepartures $parserDepartures
	 */
	protected function setParserDepartures(ParserDepartures $parserDepartures) {
		$this->parserDepartures = $parserDepartures;
	}


}