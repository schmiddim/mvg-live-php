<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 14:34
 */

namespace Mvg\TextOutput;

use  Mvg\Parser\Html\Stations as StationsParser;

class Stations {

	/**
	 * @var \ Mvg\Parser\Html\Stations
	 */
	protected $stationsParser = null;

	/**
	 * @param  \ Mvg\Parser\Html\Stations $stationsParser
	 */
	public function __construct(StationsParser $stationsParser) {
		$this->setStationsParser($stationsParser);
	}

	public function getOutput() {
		$str = '';
		foreach ($this->getStationsParser()->getStationsForTerm() as $station) {
			$str .= $station->name . "\n";
		}
		return $str;
	}

	/**
	 * @return \ Mvg\Parser\Html\Stations
	 */
	protected function getStationsParser() {
		return $this->stationsParser;
	}

	/**
	 * @param \ Mvg\Parser\Html\Stations $stationsParser
	 */
	protected function setStationsParser(StationsParser $stationsParser) {
		$this->stationsParser = $stationsParser;
	}


}