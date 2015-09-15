<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 22:05
 */

namespace Mvg\TextOutput;

use Mvg\Parser\NewsTicker as NewsTickerParser;

class NewsTicker {

	/**
	 * @va Mvg\Parser\NewsTicker
	 */
	protected $newsTickerParser = null;


	/**
	 * @param Mvg\Parser\NewsTicker $newsTickerParser
	 */
	public function __construct(NewsTickerParser $newsTickerParser) {

		$this->setNewsTickerParser($newsTickerParser);

	}

	public function getOutput() {
		$str = '';
		foreach ($this->getNewsTickerParser()->getInterferences() as $interference) {

			$str .= '===' . $interference->lines . '===' . "\n";
			$str .= $interference->messages . "\n";
		}
		return $str;
	}

	/**
	 * @return Mvg\Parser\NewsTicker
	 */
	protected function getNewsTickerParser() {
		return $this->newsTickerParser;
	}

	/**
	 * @param  Mvg\Parser\NewsTicker
	 */
	protected function setNewsTickerParser($newsTickerParser) {
		$this->newsTickerParser = $newsTickerParser;
	}

}