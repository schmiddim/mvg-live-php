#!/bin/bash
<?php
/**
 * User: ms
 * Date: 28.08.15
 * Time: 23:34
 * @todo what is this shit? http://www.mvg-live.de/MvgLive/MvgLive.jsp
 * @see this ruby application https://github.com/rmoriz/mvg-live/blob/master/lib/mvg/live.rb
 * GWT RPC Response
 * http://www.mvg-live.de/ims/dfiStaticAuswahl.svc?haltestelle=Karl-Theodor-Stra%dfe&ubahn=checked&bus=checked&tram=checked&sbahn=checked
 */


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
//wget

$url = 'http://www.mvg-live.de/ims/dfiStaticAuswahl.svc?haltestelle=Karl-Theodor-Stra%dfe&ubahn=checked&bus=checked&tram=checked&sbahn=checked';
$html = iconv('ISO-8859-1', 'UTF-8', file_get_contents($url));
phpQuery::newDocumentHTML($html);
$container = pq('.departureView tr');

$departureObjects = [];
foreach ($container as $departure) {
	$tableRows = pq($departure)->find('td');

	if (count($tableRows) === 3) {
		$tdCtr = 0;
		$departureObject = new stdClass();
		foreach ($tableRows as $tableRow) {
			$str = pq($tableRow)->html();
			if ($tdCtr == 0) {
				$departureObject->lineNumber = trim($str);
			}
			if ($tdCtr == 2) {
				$departureObject->time = trim($str);
			}
			if ($tdCtr == 1) {
				$dest = explode("\n", $str);
				$destination = trim($dest[1]);
				$departureObject->destination = $destination;
			}
			$tdCtr++;
		}
		$departureObjects[] = $departureObject;
	}

}

foreach ($departureObjects as $departureObject) {
	echo $departureObject->lineNumber . '   ' . $departureObject->destination . '   ' . $departureObject->time . "\n";
}