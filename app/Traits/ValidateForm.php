<?php
namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait ValidateForm
 *
 * @package App\Traits
 */
trait ValidateForm {

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return bool
	 */
	private $countryCodes = ['AR','AO','AT','AU','AW','BE','BG','BO','BR','CA','CH','CN','CO','CZ','DE','DK','DO','EC','ES','FI','FR','GB','GB-ENG','GB-NIR','GB-SCT','GB-WLS','GR','GT','HK','HN','HR','HU','ID','IE','IN','IL','IT','JP','KZ','LS','LU','MG','MQ','MT','MU','MX','MZ','NL','NO','PE','PK','PH','PL','PR','PT','PY','RE','RU','SC','SE','SG','SI','ST','SK','TN','TR','UA','US','UY','VE',];
	public $hasError = false;
	public $messages = [];
	public $data = [];

	public function formIsValid(Request $request)
	{
		$this->extractInputs($request);
		if($this->data['date'] == ''){
			$this->hasError=true;
			$this->messages[] = 'Please, input the start date.';
		}elseif(!$this->validDate($this->data['date'])){
			$this->hasError=true;
			$this->messages[] = 'The start date is invalid.';
		}
		if($this->data['days'] == ''){
			$this->hasError=true;
			$this->messages[] = 'Please, input the number of days.';
		}elseif(!$this->validInteger($this->data['days'])){
			$this->hasError=true;
			$this->messages[] = 'The number of days must be a number or a value between 1 - 999';
		}
		if($this->data['code'] == ''){
			$this->hasError=true;
			$this->messages[] = 'Please, input the country code.';
		}elseif(!$this->validCountryCode($this->data['code']))
		{
			$this->hasError=true;
			$this->messages[] = 'The country code is incorrect.';
		}
	}

	private function extractInputs(Request $request)
	{
		$this->data['date'] = $request->input('date');
		$this->data['days'] = $request->input('days');
		$this->data['code'] = $request->input('code');
	}
	private function validDate($date)
	{
		if (preg_match("/([1-9]|1[0-2])\/([1-9]|[1-2][0-9]|3[0-1])\/([0-9]{4})/", $date, $matches)) {
			$day = $matches[2];
			$month = $matches[1];
			$year = $matches[3];
			return (checkdate($month, $day, $year));
		}else{
			return false;
		}
	}

	private function validInteger($number)
	{
		$options = array(
			'options' => array(
				'min_range' => 1,
				'max_range' =>999
			)
		);
		return (filter_var($number, FILTER_VALIDATE_INT, $options) !== false);
	}

	private function validCountryCode($code)
	{
		return (in_array(mb_strtoupper($code),$this->countryCodes,true));
	}
}
