<?php
if (!defined('ALLOWED_ACCESS')) die('No access permission');
return array(
	'language' => 'vi', // site language

	'appkey' => array(
		'android' => 'd77a238697e63e5056810448d460c0d7',
		'ios' => 'ced3d169ffdb099ee6fede9d8f923f60'
	),

	'template' => array(
		'base_url' => 'http://subdomain.test1.ru/', // site url
		'title' => 'SDK For MU Origin', // site title
		'name' => 'MU VNZooM', // site name

		'path' => 'template' . DS .'default', // template path
		'defaultLayout' => 'main',
	),
);
