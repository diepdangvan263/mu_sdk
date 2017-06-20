<?php
class Model_Log extends Model
{
	public function __construct()
	{
		$this->setDB('admin_qltk');
		$this->setTable('log');
	}

	public function add($type, $account, $msg)
	{
		$data = array(
			'type' => $type,
			'account' => $account,
			'msg' => $msg,
			'time' => date('Y-m-d H:i:s', time())
		);
		return $this->insert($data);
	}
}
