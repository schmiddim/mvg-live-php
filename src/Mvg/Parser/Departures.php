<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 09:36
 */

namespace Mvg\Parser;


use phpQuery;

/**
 * Class Departures
 * @package Mvg
 */
class Departures extends AbstractParser {

	/**
	 * @var string
	 */
	protected $currentTime;

	/**
	 * @var string
	 */
	protected $station;

	public function getDepartures() {
		$html = $this->getHtmlResponse();
		$departureObjects = [];
		phpQuery::newDocumentHTML($html);
		$tableRows = pq('.rowEven,.rowOdd');
		foreach ($tableRows as $tableRow) {
			$tableRow = pq($tableRow)->remove('.spacer');
			$departureObject = new \stdClass();
			$departureObject->lineNumber = trim(pq($tableRow)->find('.lineColumn')->html());
			$departureObject->destination = trim(preg_replace("(<([a-z]+).*?>.*?</\\1>)is", "", pq($tableRow)->find('.stationColumn')->html()));
			$departureObject->time = trim(pq($tableRow)->find('.inMinColumn')->html());
			$departureObjects[] = $departureObject;

		}

		//Time + Station name
		$this->setStation(pq('.headerStationColumn')->html());
		$this->setCurrentTime(pq('.serverTimeColumn')->html());
		return $departureObjects;
	}

	/**
	 * @return string
	 */
	public function getCurrentTime() {
		return $this->currentTime;
	}

	/**
	 * @param string $currentTime
	 */
	protected function setCurrentTime($currentTime) {
		$this->currentTime = $currentTime;
	}

	/**
	 * @return string
	 */
	public function getStation() {
		return $this->station;
	}

	/**
	 * @param string $station
	 */
	protected function setStation($station) {
		$this->station = $station;
	}


}