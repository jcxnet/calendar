<?php

namespace App\Utils;

/**
 * Class Month
 *
 * @package \App\Utils
 */
class Month
{
	/**
	 * @var string
	 */
	private $name = '';
	/**
	 * @var int
	 */
	private $number = 0;
	/**
	 * @var int
	 */
	private $year =0;
	/**
	 * @var int
	 */
	private $days = 0;
	/**
	 * @var array
	 */
	private $startDay = [];
	/**
	 * @var array
	 */
	private $endDay = [];
	/**
	 * @var array
	 */
	private $holidays = [];

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @param int $number
	 */
	public function setNumber($number)
	{
		$this->number = $number;
	}

	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->year;
	}

	/**
	 * @param int $year
	 */
	public function setYear($year)
	{
		$this->year = $year;
	}

	/**
	 * @return int
	 */
	public function getDays()
	{
		return $this->days;
	}

	/**
	 * @param int $days
	 */
	public function setDays($days)
	{
		$this->days = $days;
	}

	/**
	 * @return array
	 */
	public function getStartDay()
	{
		return $this->startDay;
	}

	/**
	 * @param array $startDay
	 */
	public function setStartDay($startDay)
	{
		$this->startDay = $startDay;
	}

	/**
	 * @return array
	 */
	public function getEndDay()
	{
		return $this->endDay;
	}

	/**
	 * @param array $endDay
	 */
	public function setEndDay($endDay)
	{
		$this->endDay = $endDay;
	}

	/**
	 * @param $holidays
	 */
	public function setHolidays($holidays)
	{
		if(array_key_exists($this->year,$holidays)){
			if($holidays[$this->year]['status'] == 200){
				$this->holidays = $this->findHolidays($this->year,$this->number,$holidays[$this->year]['holidays']);
			}
		}
	}

	/**
	 * @param $year
	 * @param $month
	 * @param $holidays
	 *
	 * @return array
	 */
	private function findHolidays($year, $month, $holidays)
	{
		$list = [];
		foreach ($holidays  as $day => $holiday){
			if(date('Y',strtotime($day)) == $year && date('n',strtotime($day)) == $month){
				$name = '';
				foreach($holiday as $item){
					$name .= sprintf("%s%s",($name==''?'':'<br/>'),$item['name']);
				}
				$list[date('j',strtotime($day))] = $name;
			}
		}
		return $list;
	}

}
