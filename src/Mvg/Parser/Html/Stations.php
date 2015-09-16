<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 12:37
 */

namespace  Mvg\Parser\Html;

use phpQuery;

/**
 * Class Stations
 * @package Mvg
 */
class Stations extends AbstractParser {

	/**
	 * @param $searchTerm
	 */
	public function getStationsForTerm() {
		$html = $this->getHtmlResponse();
		$stationObjects = [];
		phpQuery::newDocumentHTML($html);
		$listItems = pq('li a');
		foreach ($listItems as $listItem) {
			$stationObject = new \stdClass();
			$stationObject->name = trim(pq($listItem)->html());
			$stationObjects[] = $stationObject;
		}
		return $stationObjects;
	}
}