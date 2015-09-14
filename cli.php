<?php
/**
 * User: ms
 * Date: 28.08.15
 * Time: 23:34
 * @see this ruby application https://github.com/rmoriz/mvg-live/blob/master/lib/mvg/live.rb
 *
 * Departures
 * http://www.mvg-live.de/ims/dfiStaticAnzeige.svc?haltestelle=Karl-Theodor-Stra%DFe&ubahn=checked&bus=checked&tram=checked&sbahn=checked
 *
 * Select Station
 * http://www.mvg-live.de/ims/dfiStaticAuswahl.svc?haltestelle=Karl&ubahn=checked&bus=checked&tram=checked&sbahn=checked
 */

use Mvg\HttpGetDepartures;
use Mvg\Parser\Departures;
use Mvg\Parser\Stations;
use Mvg\TextOutput\Departures as TextOutputDepartures;
use Mvg\TextOutput\Stations as TextOutputStations;
use Mvg\Factories\Departures as DeparturesFactory;
use Mvg\HttpPostNewsTicker;
use Mvg\TextOutput\NewsTicker as NewsTickerOutput;


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

unset($argv[0]);
$searchForStation = implode(' ', $argv);



$responseForNewsTicker = (new HttpPostNewsTicker())->doPostRequest();
$newsTickerParser = new \Mvg\Parser\NewsTicker($responseForNewsTicker);
$interferences = $newsTickerParser->getInterferences();
if (0 < count($interferences)) {
	echo "Interferences\n";
	echo (new NewsTickerOutput($newsTickerParser))->getOutput();

}

if (1 === $argc) {
	die("Please enter a station name\n");
}

$http = new HttpGetDepartures('http', 'www.mvg-live.de', 'ims/dfiStaticAuswahl.svc');
$result = $http->getDeparturesForStation($searchForStation);
$parser = new Departures($result);
$departures = $parser->getDepartures();
if (0 === count($departures)) {
	echo "Station unknown\n";
	echo "Did you mean?\n";
	$stationParser = new Stations($result);
	echo (new TextOutputStations($stationParser))->getOutput();


} else {
	$factory = new DeparturesFactory($parser);
	echo (new TextOutputDepartures($factory))->getOutput();

}


