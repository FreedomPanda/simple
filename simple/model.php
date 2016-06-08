<?php

namespace Simple;

class Model
{
	public static $_instance = NULL;

	/**
	 * @param $pk_value int 主键
	 * @return Model;
	 */
	public static function instance($pk_value = 0)
	{
		if (empty(self::$_instance))
		{
			self::$_instance = new self($pk_value);
		}
		return self::$_instance;
	}

	protected $table = NULL;
	protected $pk = 'id';
	protected $pk_value = 0;

	protected function __construct($pk_value)
	{
		$this->pk_value = $pk_value;
	}

	protected function _make_where($where)
	{
		if (!is_array($where))
		{
			$where = [
				$this->pk	=> $where,
			];
		}
		return $where;
	}

	//获取一条记录
	public function get($where)
	{
		$where = $this->_make_where($where);
		if (empty($where))
		{
			return false;
		}
		return ORM::factory($this->table)->where($where)->find();
	}

	//删除一条记录
	public function del($where)
	{
		$where = $this->_make_where($where);
		if (empty($where))
		{
			return false;
		}
		return ORM::factory($this->table)->where($where)->delete();
	}

	//修改一条记录	TODO 参数检查
	public function save($data)
	{
		if (empty($this->pk_value) || empty($data))
		{
			return FALSE;
		}

		$where = $this->_make_where($this->pk_value);
		return ORM::factory($this->table)->where($where)->save($data);
	}

	//新增一条记录	TODO 参数检查
	public function add($data)
	{
		if (empty($data))
		{
			return FALSE;
		}

		return ORM::factory($this->table)->add($data);
	}

	//批量插入记录	TODO 参数检查
	public function add_all($data)
	{
		if (empty($data))
		{
			return FALSE;
		}

		return ORM::factory($this->table)->add_all($data);
	}
}