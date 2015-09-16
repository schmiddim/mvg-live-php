<?php
/**
 * User: ms
 * Date: 14.09.15
 * Time: 22:05
 */

namespace Mvg\TextOutput;

use  Mvg\Parser\Html\NewsTicker as NewsTickerParser;

class NewsTicker {

	/**
	 * @va  Mvg\Parser\Html\NewsTicker
	 */
	protected $newsTickerParser = null;


	/**
	 * @param  Mvg\Parser\Html\NewsTicker $newsTickerParser
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
	 * @return  Mvg\Parser\Html\NewsTicker
	 */
	protected function getNewsTickerParser() {
		return $this->newsTickerParser;
	}

	/**
	 * @param   Mvg\Parser\Html\NewsTicker
	 */
	protected function setNewsTickerParser($newsTickerParser) {
		$this->newsTickerParser = $newsTickerParser;
	}

}