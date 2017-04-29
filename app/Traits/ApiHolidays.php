<?php

namespace App\Traits;

/**
 * Trait ApiHolidays
 *
 * @package App\Traits
 */
trait ApiHolidays
{
	/**
	 * @param array $years
	 * @param string $code
	 *
	 * @return array
	 */
	public function getHolidays($years, $code)
	{
		$list = [];
		foreach($years as $year){
			$list[$year] = $this->getApiData($year,$code);
		}
		return $list;
	}

	/**
	 * @param $year
	 * @param $code
	 *
	 * @return mixed|string
	 */
	private function getApiData($year, $code)
	{

		$key = '828becf3-d04f-4ee4-8ea6-420f9169eb80';
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://holidayapi.com/v1/holidays",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "key=$key&country=$code&year=$year",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return  "cURL Error #:" . $err;
		} else {
			if(is_string($response))
				return json_decode($response,true);
			return $response;
		}
	}
}
