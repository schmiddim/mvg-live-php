<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 21:55
 */

namespace Mvg\RequestHandler;

use Zend\Http\Client;

class HttpPostNewsTicker {

	public function doPostRequest() {
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
		return $response->getBody();
	}
}