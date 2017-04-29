<?php

namespace App\Http\Controllers;

use App\Traits\ApiHolidays;
use Illuminate\Http\Request;
use App\Traits\CalculateDays;
use App\Traits\ValidateForm;

/**
 * Class CalendarController
 *
 * @package App\Http\Controllers
 */
class CalendarController extends Controller
{
	use CalculateDays, ValidateForm, ApiHolidays;

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return bool|\Illuminate\Http\JsonResponse
	 */
	public function generate(Request $request)
    {
	    if($request->ajax()){
		    $date = $request->input('date');
		    $days = $request->input('days');
		    $code = $request->input('code');
			$this->setValues(['date'=>$date,'days' => $days,'code' => $code]);
			$holidays = $this->getHolidays($this->getYears(),$code);
			$this->setHolidays($holidays);
		    $view = view('calendar',['months' => $this->getMonthList() ])->render();
		    return response()->json(['status'=>'ok','html'=>$view]);
		    return true;
	    }else{
		    $message = ['status' => 'error',  'message' => 'Invalid request'];
		    return response()->json($message);
	    }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function validation(Request $request)
    {
    	if($request->ajax()){
			$this->formIsValid($request);
			if($this->hasError){
				$message = ['status'=>'error', 'message' => $this->messages];
				return response()->json($message);
			}else{
				$message = ['status'=>'ok', 'values' => $this->data];
				return response()->json($message);
			}
	    }else{
    		$message = ['status' => 'error',  'message' => 'Invalid request'];
    		return response()->json($message);
	    }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function alert(Request $request)
    {
	    if($request->ajax()){
			$type = mb_strtolower($request->input('type'));
			$title= $request->input('title');
			$messages = $this->formatMessage($request->input('message'));
			$view = view('component.alert',['type' => $type, 'title' => $title, 'content' => $messages])->render();
			return response()->json(['status'=>'ok','html'=>$view]);
	    }else{
		    $message = ['status' => 'error',  'message' => 'Invalid request'];
		    return response()->json($message);
	    }
    }

	/**
	 * @param $messages
	 *
	 * @return string
	 */
	private function formatMessage($messages)
    {
    	if($messages!=''){
    		if(is_array($messages)){
    			$text = '';
    			foreach ($messages as $message){
    				$text .= sprintf("%s%s",(($text !='')?'<br/>':''),$message);
			    }
			    return $text;
		    }elseif (is_string($messages)){
    			return $messages;
		    }
	    }
	    return 'No message!';
    }
}
