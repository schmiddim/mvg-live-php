<?php
namespace Mvg\LedMatrixOutput;

class Departures
{

	/**
	 * @var \Mvg\Factories\Departures
	 */
	protected $departuresFactory = null;

	/**
	 * @var mixed
	 */
	protected $filter = null;

	/**
	 * @param \Mvg\Factories\Departures $departuresFactory
	 * @param mixed $filter
	 */
	public function __construct($departuresFactory, $filter = null)
	{
		$this->setDeparturesFactory($departuresFactory);
		$this->setFilter($filter);
	}

	/**
	 * @return mixed
	 */
	protected function getFilter()
	{
		return $this->filter;
	}

	/**
	 * @param mixed $filter
	 */
	protected function setFilter($filter)
	{
		$this->filter = $filter;
	}


	/**
	 * @return \Mvg\Factories\Departures
	 */
	protected function getDeparturesFactory()
	{
		return $this->departuresFactory;
	}


	/**
	 * @param \Mvg\Factories\Departures $departuresFactory
	 */
	protected function setDeparturesFactory($departuresFactory)
	{
		$this->departuresFactory = $departuresFactory;
	}

	public function getOutput()
	{


		$returnValue = array();
		$returnValue['departures'] = array();
		$departuresItems = $this->getDeparturesFactory()->getItems($this->getFilter());
		if(count($departuresItems) == 0 )  {
			return null;
		}
		foreach ($departuresItems as $departureObject) {
			$returnValue['departures'][] = intval($departureObject->time);

		}
		$returnValue['name'] = $departureObject->lineNumber;
		$returnValue['color'] = self::getColorForLineNumber($departureObject->lineNumber);
		$returnValue['departureCount'] = count($departuresItems);

		return $returnValue;
	}


	public static function getColorForLineNumber($lineNumber)
	{
		if ($lineNumber === 'U3') {
			return array(
				'red' => 255,
				'green' => 50,
				'blue' => 0);
		} else {
			return array(
				'red' => 0,
				'green' => 0,
				'blue' => 255);
		}
	}
}