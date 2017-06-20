<?php
class Controller
{
	public function __construct()
	{
		$this->registry = $GLOBALS['registry'];
		$this->registry['view'] = new View($this->registry['config']['template']);
		$this->registry['log'] = new Model_Log();
	}
}
