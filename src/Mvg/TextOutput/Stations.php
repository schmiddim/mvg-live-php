<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 14:34
 */

namespace Mvg\TextOutput;

use Mvg\Parser\Stations as StationsParser;
class Stations {

	/**
	 * @var Stations
	 */
	protected $stationsParser =null;

	/**
	 * @param StationsParser $stationsParser
	 */
	public function __construct(StationsParser $stationsParser) {
		$this->setStationsParser($stationsParser);
	}

	public function getOutput(){
		$str='';
		foreach($this->getStationsParser()->getStationsForTerm() as $station) {
			$str.= $station->name ."\n";
		}
		return $str;
	}

	/**
	 * @return Stations
	 */
	protected function getStationsParser() {
		return $this->stationsParser;
	}

	/**
	 * @param StationsParser $stationsParser
	 */
	protected function setStationsParser(StationsParser $stationsParser) {
		$this->stationsParser = $stationsParser;
	}


}