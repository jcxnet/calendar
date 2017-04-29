<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CalculateDays;
use App\Traits\ValidateForm;

class CalendarController extends Controller
{
	use CalculateDays, ValidateForm;

    public function generate(Request $request)
    {

    }

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
