<?php
/**
 * User: ms
 * Date: 01.09.15
 * Time: 22:57
 */
use Mvg\Http;
use  Mvg\Parser\Html\Departures;
use Mvg\Factories\Departures as DeparturesFactory;

error_reporting(E_ALL);


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$station = null;
$filter = '';
if (isset($_GET['station'])) {
	$station = $_GET['station'];

}

if (isset($_GET['filter'])) {
	$filter = $_GET['filter'];

}

if (null == $station) {
	die (json_encode([]));
}


$http = new Http('http', 'www.mvg-live.de', 'ims/dfiStaticAuswahl.svc');
$result = $http->getDeparturesForStation($station);
$parser = new Departures($result);
$departures = $parser->getDepartures();
if (count($departures) > 0) {
	$factory = new DeparturesFactory($parser);
	die(json_encode($factory->getItems($filter)));

}


die (json_encode([]));
