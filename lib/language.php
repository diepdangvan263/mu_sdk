<?php
/**********************/
/* Language Class     */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class Language
{
	private static $lang;

	public static function setLanguage($lang)
	{
		self::$lang = $lang;
	}

	public static function get($text)
	{
		$registry = new Registry();
		$file = 'config' . DS . 'lang' . DS . self::$lang . '.php';
		if (file_exists($file)) {
			$language = require $file;
			return $language[$text];
		} else {
			throw new Exception('Language file does not exists!');
		}
	}
}
