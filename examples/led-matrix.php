<?php

/*
-s '' -e '' -n

*/
use  Mvg\Parser\Html\Departures;
use  Mvg\Parser\Html\Stations;
use Mvg\TextOutput\Departures as TextOutputDepartures;
use Mvg\TextOutput\Stations as TextOutputStations;
use Mvg\Factories\Departures as DeparturesFactory;
use Mvg\RequestHandler\Html\HttpGetDepartures;
use Mvg\LedMatrixOutput\Departures as LedMatrixOutPutDepartues;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$searchForStations = array(
	'Bonner Platz',
	'Karl-Theodor-Straße'
);
$filterForStations = array(
	'Fürstenried West',
	'Sendlinger Tor',
	'Einsteinstraße'
);
#$filterForStations = [];
$outputArrays = array();
$outputArrays['lines'] = array();
foreach ($searchForStations as $searchForStation) {
	$searchForStation = trim($searchForStation);
	$http = new HttpGetDepartures('http', 'www.mvg-live.de', 'ims/dfiStaticAuswahl.svc');
	$result = $http->getDeparturesForStation($searchForStation);
	$parser = new Departures($result);
	$departures = $parser->getDepartures();


	$factory = new DeparturesFactory($parser);

	$lineArray = (new LedMatrixOutPutDepartues($factory, $filterForStations))->getOutput();
	if (null !== $lineArray) {
		$outputArrays['lines'][] = $lineArray;
	}

}
$outputArrays['lineCount'] = count($outputArrays['lines']);

echo json_encode($outputArrays);
$break = true;