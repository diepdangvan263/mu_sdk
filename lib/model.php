<?php
/**********************/
/* Model Class        */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class Model
{
	public function setDB($name)
	{
		$path = 'config' . DS . 'database' . DS . $name . '.json';
		if (!file_exists($path)) {
			throw new Exception('Config file for database `' . $name .'` does not exists!');
		}
		$db = json_decode(file_get_contents($path), true);
		$this->stm = new Database($db);
	}

	public function setTable($name)
	{
		$this->table = $name;
	}

	public function find($select, $where, $bind = '', $ext = '')
	{
		if (empty($select)) {
			$select = '*';
		}

		$sql = "SELECT $select FROM $this->table WHERE $where[0] = $where[1] $ext";
		$this->stm->query($sql);
		$this->bind($bind);
		return $this->stm->single();
	}

	public function findBySql($sql, $bind)
	{
		$this->stm->query($sql);
		$this->bind($bind);
		return $this->stm->single();
	}

	public function findAll($select = '*', $where = '', $bind = '', $ext = '')
	{
		$sql = "SELECT $select FROM $this->table WHERE $where $ext";
		$this->stm->query($sql);
		$this->bind($bind);
		return $this->stm->resultSet();
	}

	public function findAllBySql($sql, $bind)
	{
		$this->stm->query($sql);
		$this->bind($bind);
		return $this->stm->resultSet();
	}

	public function insert($data)
	{
		$intoSql = null;
		$dataSql = null;
		foreach ($data as $key => $value) {
			$intoSql .= ", $key";
			$dataSql .= ", '$value'";
		}
		$intoSql = ltrim($intoSql, ', ');
		$dataSql = ltrim($dataSql, ', ');
		$sql = 'INSERT INTO '.$this->table.'('.$intoSql.') VALUES ('.$dataSql.')';
		$this->stm->query($sql);
		$this->stm->execute();
		return $this->stm->lastInsertId();
	}

	public function update($data, $where)
	{
		$updateSql = null;
		foreach ($data as $key => $value) {
			$updateSql .= ", $key = '$value'";
		}
		$updateSql = ltrim($updateSql, ', ');
		$sql = 'UPDATE '.$this->table.' SET '.$updateSql.' WHERE '.$where[0].' = '.$where[1];
		$this->stm->query($sql);
		return $this->stm->execute();
	}

	public function delete($where)
	{
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$where[0].' = '.$where[1];
		$this->stm->query($sql);
		return $this->stm->execute();
	}

	public function execBySql($sql, $bind = array())
	{
		$this->stm->query($sql);
		$this->bind($bind);
		return $this->stm->execute();
	}

	public function bind($data = array())
	{
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$this->stm->bind($key, $value);
			}
		}
	}
}
