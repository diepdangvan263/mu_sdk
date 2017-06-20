<?php
/**********************/
/* Helper Class       */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class Helper
{
	public static function curlSendPost($param, $url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, count($param));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
