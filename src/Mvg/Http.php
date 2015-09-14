<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 09:35
 */
namespace Mvg;

use Zend\Http\Client;

/**
 * Class Http
 * @package Mvg
 */
class Http {
	/**
	 * @var string
	 */
	protected $schema;
	/**
	 * @var string
	 */
	protected $host;
	/**
	 * @var string
	 */
	protected $path;
	/**
	 * @var array
	 */
	protected $parameter;

	/**
	 * @param $schema
	 * @param $host
	 * @param $path
	 */
	public function __construct($schema, $host, $path) {
		$this->setHost($host);
		$this->setSchema($schema);
		$this->setPath($path);

		$this->setParameter(
			[
				'ubahn' => 'checked'
				, 'bus' => 'checked'
				, 'tram' => 'checked'
				, 'sbahn' => 'checked'
			]
		);

	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	protected function doGetRequest() {

		$url = sprintf('%s://%s/%s?%s'
			, $this->getSchema()
			, $this->getHost()
			, $this->getPath()
			, http_build_query($this->getParameter(), PHP_QUERY_RFC3986)
		);
		$client = new Client();
		$client->setUri($url)
			->setMethod(\Zend\Http\Request::METHOD_GET);
		$response = $client->send();
		if ($response->getStatusCode() !== 200) {
			throw new \Exception(sprintf('Request Response: Status Code %d', $response->getStatusCode()));
		}
		return utf8_encode($response->getBody());
	}

	/**
	 * @return string
	 */
	public function getStations() {
		//@todo implement me
	}

	/**
	 * @param $station
	 * @return string
	 */
	public function getDeparturesForStation($station) {
		$this->addParameter('haltestelle', $station);
		$htmlResponse = $this->doGetRequest();
		return $htmlResponse;
	}

	public function getNewsTicker() {

	}

	/**
	 * @return string
	 */
	protected function getSchema() {
		return $this->schema;
	}

	/**
	 * @param string $schema
	 */
	protected function setSchema($schema) {
		$this->schema = $schema;
	}

	/**
	 * @return string
	 */
	protected function getHost() {
		return $this->host;
	}

	/**
	 * @param string $host
	 */
	protected function setHost($host) {
		$this->host = $host;
	}

	/**
	 * @return string
	 */
	protected function getPath() {
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	protected function setPath($path) {
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getParameter() {
		return $this->parameter;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	protected function addParameter($key, $value) {
		$this->parameter[$key] = utf8_decode($value);
	}

	/**
	 * @param array $parameter
	 */
	protected function setParameter($parameter) {
		$this->parameter = $parameter;
	}


}