<?php
/**********************/
/* Router Class       */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class Route
{
	private $path;

	public function __construct($config)
	{
		$this->getURL();
		$this->run($config);
	}

	/*
	 *	Get path
	 *
	 */
	private function getURL()
	{
		$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
		$this->path = strtolower(rtrim($url, '/\\'));
		unset($url);
	}

	/*
	 *	Call class and method in config from path
	 *
	 */
	private function run($config)
	{
		$class = $config['defaultApp']; // if class not exist call default class
		$action = $config['defaultAction']; // if method not exist call default method

		foreach ($config as $key => $value) {
			if ($this->path == $key) {
				$func = explode('@', $value);
				$class = $func[0];
				$action = $func[1];
			}
		}

		// call class and function
		if (class_exists($class)) {
			$run = new $class;

			if (method_exists($class, 'init')) {
				$run->init();
			}

			if (method_exists($class, $action)) {
				$run->$action();
			} else {
				throw new Exception('Action `' . $action . '` does not exists!');
			}
		} else {
			throw new Exception('Class `' . $class . '` does not exists!');
		}
	}
}
