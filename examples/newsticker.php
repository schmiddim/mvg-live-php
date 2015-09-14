<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 20:09
 */
use Zend\Http\Client;

error_reporting(E_ALL);


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$url = 'http://www.mvg-live.de/MvgLive/mvglive/rpc/newstickerService';
$client = new Client();
$client->setUri($url);
$client->setMethod(\Zend\Http\Request::METHOD_POST);

$headers = array(
	'Origin' => 'http://www.mvg-live.de'
, 'Accept-Encoding' => 'gzip, deflate'
, 'Accept-Language' => 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4,da;q=0.2'
, 'X-GWT-Module-Base' => 'http://www.mvg-live.de/MvgLive/mvglive/'
, 'Connection' => 'keep-alive'
, 'Cache-Control' => 'no-cache'
, 'Pragma' => 'no-cache'
, 'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36'
, 'Content-Type' => 'text/x-gwt-rpc; charset=UTF-8'
, 'Accept' => '*/*'
, 'X-GWT-Permutation' => '1DD521F1FA9966B50432692AB421CD55'
, 'Referer' => 'http://www.mvg-live.de/MvgLive/MvgLive.jsp'
, 'DNT' => '1'

);
$client->setHeaders($headers);
$client->setRawBody('7|0|4|http://www.mvg-live.de/MvgLive/mvglive/|7690A2A77A0295D3EC713772A06B8898|de.swm.mvglive.gwt.client.newsticker.GuiNewstickerService|getNewsticker|1|2|3|4|0|');
$response = $client->send();


//Parsen
###############

$jsonString = str_replace('//OK', '', $response->getBody());
$array = json_decode($jsonString);

$payload = null;
//Find the interesting part
foreach ($array as $item) {
	if (is_array($item)) {
		$payload = $item;
		break;
	}
}
if (null === $payload) {
	throw new \Exception('unable to parse payload from ' . $jsonString);
}

//Remove the Javastuff
foreach ($payload as $key => $item) {
	if (preg_match('/de.swm.mvglive.gwt.client.newsticker.NewstickerItem/', $item)) {
		unset($payload[$key]);
	}
	if (preg_match('/java.util.ArrayList/', $item)) {
		unset($payload[$key]);
	}
}
#var_dump($payload);

if (0 != (count($payload) % 2)) {
	throw new \Exception('Item count is odd! ' . $jsonString);

}

$objects =array();

foreach ($payload as $key => $item) {
	if (0 == ($key % 2)) {
		$object = new \stdClass();
		$object->lines = $item;
	} else {
		$object->messages = $item;
		$objects[] = $object;
	}

}

var_dump($objects);