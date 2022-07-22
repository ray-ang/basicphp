<?php

class HomeController
{

	public function index()
	{
		$page_title = 'Starter Application';

		Basic::view('home', compact('page_title'));
	}
}
