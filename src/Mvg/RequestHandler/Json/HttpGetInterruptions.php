<?php
/**
 * User: ms
 * Date: 17.09.15
 * Time: 00:22
 */
namespace Mvg\RequestHandler\Json;

use Zend\Http\Client;
use Zend\Json\Json as ZendJson;

class HttpGetInterruptions {

	/**
	 * @todo whats wrong with SSL?
	 * @return array
	 */
	public function doRequest() {
		$url = 'https://www.mvg.de/.rest/betriebsaenderungen/api/interruptions';
		$client = new Client($url, array(
				'adapter' => 'Zend\Http\Client\Adapter\Curl',
				'curloptions' => array(
					CURLOPT_FOLLOWLOCATION => TRUE,
					CURLOPT_SSL_VERIFYPEER => FALSE
				)
			)
		);
		$client->setMethod(\Zend\Http\Request::METHOD_GET);
		return ZendJson::decode($client->send()->getBody());
	}
}




