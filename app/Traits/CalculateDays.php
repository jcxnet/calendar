<?php

namespace App\Traits;

use App\Utils\Month;
use Illuminate\Support\Collection;

/**
 * Trait CalculateDays
 *
 * @package App\Traits
 */
trait CalculateDays
{

	/**
	 * @var \Illuminate\Support\Collection|null
	 */
	private $monthList = null;
	/**
	 * @var string
	 */
	private $start = '';
	/**
	 * @var string
	 */
	private $end = '';
	/**
	 * @var int
	 */
	private $months = 0;
	/**
	 * @var int
	 */
	private $days = 0;
	/**
	 * @var array
	 */
	private $years = [];

	/**
	 * CalculateDays constructor.
	 */
	public function __construct()
	{
		$this->monthList = new Collection();
	}

	/**
	 * @param $values
	 */
	public function setValues($values)
	{
		$this->start = $values['date'];
		$this->days = $values['days'];
		$this->end = $this->addDays($this->start, $this->days);
		$this->months = $this->calculateMonths($this->start, $this->end);
		$this->addMonths();
	}

	/**
	 * @param $holidays
	 */
	public function setHolidays($holidays)
	{
		$this->monthList->transform(function ($month) use ($holidays) {
			$month->setHolidays($holidays);
			return $month;
		});
	}

	/**
	 * @return array
	 */
	public function getYears()
	{
		return $this->years;
	}

	/**
	 * @return array
	 */
	public function getMonthList()
	{
		return $this->monthList->toArray();
	}

	/**
	 * generate the months collection
	 */
	private function addMonths()
	{
		$end = '';
		for ($month = 0; $month < $this->months + 1; $month++) {
			if ($month == 0) {
				$start = $this->start;
			} else {
				$start = $this->addDays($end, 1);
			}
			$end = $this->lastMonthDay($start);
			$end = $this->fixLastDate($end, $this->end);

			$this->monthList->push($this->createMonth($start, $end));
		}
	}

	/**
	 * @param $ini
	 * @param $end
	 *
	 * @return \App\Utils\Month
	 */
	private function createMonth($ini, $end)
	{
		$month = new Month();
		$month->setName(date('F', strtotime($ini)));
		$month->setNumber(date('n', strtotime($ini)));
		$month->setYear(date('Y', strtotime($ini)));
		$month->setStartDay(['day' => date('D', strtotime($ini)), 'number' => date('j', strtotime($ini))]);
		$month->setEndDay(['day' => date('D', strtotime($end)), 'number' => date('j', strtotime($end))]);
		$month->setDays($month->getEndDay()['number'] - $month->getStartDay()['number'] + 1);
		$this->addYear($month->getYear());
		return $month;
	}

	/**
	 * @param $year
	 */
	private function addYear($year)
	{
		if (!in_array($year, $this->years)) {
			$this->years[] = $year;
		}
	}

	/**
	 * @param $date
	 * @param $end
	 *
	 * @return mixed
	 */
	private function fixLastDate($date, $end)
	{
		if ($this->diffDates($date, $end) < 0) {
			return $end;
		}
		return $date;
	}

	/**
	 * @param $date
	 *
	 * @return false|string
	 */
	private function lastMonthDay($date)
	{
		return date('m/d/Y', strtotime('last day of this month', strtotime($date)));
	}

	/**
	 * @param $ini
	 * @param $end
	 *
	 * @return false|int
	 */
	private function diffDates($ini, $end)
	{
		return strtotime($end) - strtotime($ini);
	}

	/**
	 * @param $date
	 * @param $days
	 *
	 * @return false|string
	 */
	private function addDays($date, $days)
	{
		return date('m/d/Y', strtotime($date . " + $days days"));
	}

	/**
	 * @param $date
	 * @param $days
	 *
	 * @return false|string
	 */
	private function restDays($date, $days)
	{
		return date('m/d/Y', strtotime($date . " - $days days"));
	}

	/**
	 * @param $start
	 * @param $end
	 *
	 * @return false|string
	 */
	private function calculateMonths($start, $end)
	{
		$ts1 = strtotime($start);
		$ts2 = strtotime($end);

		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);

		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);

		return (($year2 - $year1) * 12) + ($month2 - $month1);
	}
}
