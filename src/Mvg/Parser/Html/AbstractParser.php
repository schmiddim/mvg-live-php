<?php
/**
 * User: ms
 * Date: 29.08.15
 * Time: 10:14
 */

namespace  Mvg\Parser\Html;

/**
 * Class AbstractParser
 * @package Mvg\Parser\Html
 */
class AbstractParser {
	/**
	 * @var string
	 */
	protected $htmlResponse;

	public function __construct($response) {
		$this->setHtmlResponse($response);
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