<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 10:14
 */

namespace Mvg;

/**
 * Class AbstractParser
 * @package Mvg
 */
class AbstractParser {
	/**
	 * @var string
	 */
	protected $htmlResponse;

	public function __construct($htmlResponse) {
		$this->setHtmlResponse($htmlResponse);
	}

	/**
	 * @return string
	 */
	protected function getHtmlResponse() {
		return $this->htmlResponse;
	}

	/**
	 * @param string $htmlResponse
	 */
	protected function setHtmlResponse($htmlResponse) {
		$this->htmlResponse = $htmlResponse;
	}
}