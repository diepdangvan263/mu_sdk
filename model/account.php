<?php
class Model_Account extends Model
{
	public function __construct()
	{
		$this->setDB('admin_qltk');
		$this->setTable('account');
	}

	public function read($id)
	{
		return $this->find(null, array('account_id', $id));
	}

	public function edit($data, $id)
	{
		return $this->update($data, array('account_id', $id));
	}

	public function add($data)
	{
		return $this->insert($data);
	}
}
