#!/bin/bash
<?php
/**
 * User: ms
 * Date: 28.08.15
 * Time: 23:34
 * @todo what is this shit? http://www.mvg-live.de/MvgLive/MvgLive.jsp <- GWT RPC Response
 * @see this ruby application https://github.com/rmoriz/mvg-live/blob/master/lib/mvg/live.rb
 * http://www.mvg-live.de/ims/dfiStaticAuswahl.svc?haltestelle=Karl-Theodor-Stra%dfe&ubahn=checked&bus=checked&tram=checked&sbahn=checked
 */
use Mvg\Http;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';


$http = new Http('http', 'www.mvg-live.de', 'ims/dfiStaticAuswahl.svc');
$result = $http->getDeparturesForStation('Karl-Theodor-Straße');
$parser = new \Mvg\DeparturesParser($result);
$parser->getDepartures();

foreach ($parser->getDepartures() as $departureObject) {
	echo $departureObject->lineNumber . '   ' . $departureObject->destination . '   ' . $departureObject->time . "\n";
}

