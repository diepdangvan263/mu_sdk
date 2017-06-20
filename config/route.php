<?php
if (!defined('ALLOWED_ACCESS')) die('No access permission');

return array(
	'defaultApp' => 'Application_Index',
	'defaultAction' => 'index',

	'api' => 'Application_User@login',
	'api/login.html' => 'Application_User@login',
	'api/register.html' => 'Application_User@register',

);
