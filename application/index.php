<?php
class Application_Index extends Application_Base
{
	public function index()
	{
		$this->registry['view']->setTitle('Test');
		$this->registry['view']->render('index/index');
	}

	public function test()
	{
		echo "pleu";
	}
}
