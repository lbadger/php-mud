<?php
class ViewType {

   public static function Message($template, $arr = array()) {
	return json_encode(["type" => "message", "data" => (string)View::make('greeting')]);
   }	
}
