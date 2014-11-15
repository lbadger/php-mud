<?php

class HomeController extends BaseController {

	public static function showWelcome()
	{
		return View::make('greeting', [ 'name' => 'wakka']);
	}

}
