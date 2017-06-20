<?php
/**********************/
/* Template Class     */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class View
{
	private $config;
	private $placeholder;
	private $layout;
	private $title;
	private $site_name;
	private $base_url;

	public function __construct($config)
	{
		$this->config = $config;
		$this->base_url = $config['base_url'];
		$this->site_name = $config['name'];
		$this->setLayout($config['defaultLayout']);
		$this->setTitle($config['title']);
	}

	public function render($tpl)
	{
		$this->placeholder = $tpl;
		$file = $this->getFile('layout/' . $this->layout);
		$this->file($file);
	}

	public function renderPartial($name)
	{
		$file = $this->getFile($name);
		$this->file($file);
	}

	public function placeholder()
	{
		$file = $this->getFile($this->placeholder);
		$this->file($file);
	}

	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		$name = !empty($this->site_name) ? ' - ' . $this->site_name : '';
		return $this->title . $name;
	}

	public function getFile($name)
	{
		$path = str_replace('/', DS, $this->config['path']);
		$name = str_replace('/', DS, $name);
		return $path . DS . $name . '.php';
	}

	public function file($file)
	{
		if (file_exists($file)) {
			require $file;
		} else {
			throw new Exception('Template `' . $file .'` does not exists!');
		}
	}
}
