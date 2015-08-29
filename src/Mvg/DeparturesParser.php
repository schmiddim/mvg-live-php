<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 09:36
 */

namespace Mvg;

use ForceUTF8\Encoding;
use phpQuery;

/**
 * Class DeparturesParser
 * @package Mvg
 */
class DeparturesParser extends AbstractParser {


	public function getDepartures() {

		$html = $this->getHtmlResponse();

		$departureObjects = [];

		phpQuery::newDocumentHTML($html);
		$tableRows = pq('.departureView> tbody .rowEven, .rowOdd');

		foreach ($tableRows as $tableRow) {
			$tableRow = pq($tableRow)->remove('.spacer');
			/*var_dump(pq($tableRow)->find('.lineColumn')->html());
			var_dump(pq($tableRow)->find('.stationColumn')->html());
			var_dump(pq($tableRow)->find('.inMinColumn')->html());*/
			$departureObject = new \stdClass();
			$departureObject->lineNumber = trim(pq($tableRow)->find('.lineColumn')->html());
			$departureObject->destination = trim(preg_replace("(<([a-z]+).*?>.*?</\\1>)is", "", pq($tableRow)->find('.stationColumn')->html()));
			$departureObject->time = trim(pq($tableRow)->find('.inMinColumn')->html());
			$departureObjects[] = $departureObject;

		}
		return $departureObjects;
	}

}