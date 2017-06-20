<?php
/**********************/
/* Registry Class     */
/* @version: 0.1      */
/* @author: DiepPK    */
/**********************/

if (!defined('ALLOWED_ACCESS')) die('No access permission');

class Registry Implements ArrayAccess
{
    private $_var;

    public function set($name, $value)
    {
        if (empty($name)) throw new Exception('You must set name for object!');
        if (empty($value)) throw new Exception('You must set value for  object `' . $name . '`!');
        if (isset($this->_var[$name]) == true) throw new Exception('Unable to set var `' . $name .'`! Already set.');

        $this->_var[$name] = $value;
        return true;
    }

    public function get($name)
    {
        if (isset($this->_var[$name]) == false) {
            throw new Exception('Object `' . $name . '` does not exists!');
        }

        return $this->_var[$name];
    }

    public function remove($name)
    {
        unset($this->_var[$name]);
    }

    public function offsetExists($name)
    {
        return isset($this->_var[$name]);
    }

    public function offsetGet($name)
    {
        return $this->get($name);
    }

    public function offsetSet($name, $value)
    {
        $this->set($name, $value);
    }

    public function offsetUnset($name)
    {
        $this->remove($name);
    }
}
