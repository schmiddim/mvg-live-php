<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 21:24
 */

namespace  Mvg\Parser\Html;

/**
 * Class NewsTicker
 * @package Mvg\Parser\Html
 */
class NewsTicker extends AbstractParser {

	/**
	 * @var array
	 */
	protected $interferences = array();

	/**
	 * @param $response
	 */
	public function __construct($response) {
		parent::__construct($response);
		$this->parse();

	}

	protected function parse() {
		$jsonString = str_replace('//OK', '', $this->getHtmlResponse());
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

		if (0 != (count($payload) % 2)) {
			throw new \Exception('Item count is odd! ' . $jsonString);

		}
		$object = new \stdClass();
		foreach ($payload as $key => $item) {
			if (0 == ($key % 2)) {
				$object = new \stdClass();
				$object->lines = $item;

				//get Lines with problems
				$stringToAnalyze = trim(str_replace('Linie(n)', '', $item));
				$linesString = explode(':', $stringToAnalyze)[0];
				$object->affectedLines = explode(',', $linesString);
				array_walk($object->affectedLines, function (&$item) {
					$item = trim($item);
				});

			} else {
				$object->messages = $item;
				$this->interferences[] = $object;
			}

		}

	}

	public function getInterferences() {
		return $this->interferences;
	}
}