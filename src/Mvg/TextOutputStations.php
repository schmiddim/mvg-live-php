<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 14:34
 */

namespace Mvg;


class TextOutputStations {

	/**
	 * @var StationParser
	 */
	protected $stationsParser =null;

	/**
	 * @param StationParser $stationsParser
	 */
	public function __construct(StationParser $stationsParser) {
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
	 * @return StationParser
	 */
	protected function getStationsParser() {
		return $this->stationsParser;
	}

	/**
	 * @param StationParser $stationsParser
	 */
	protected function setStationsParser($stationsParser) {
		$this->stationsParser = $stationsParser;
	}


}