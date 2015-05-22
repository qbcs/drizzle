<?php

class Util_Mysql
{
	private static $_handle = false;

	public static function init()
	{
		// 如果连接可用，直接返回
		if (self::$_handle && mysqli_ping(self::$_handle))
		{
			return true;
		}

		self::$_handle = false;

		$db_config = System_Config::load('db_config');

		if (!self::_check_db_config($db_config))
		{
			return false;
		}

		$try_times = 0;
		while (FALSE == self::$_handle || $try_times++ < 3)
		{
			self::$_handle = @mysqli_connect(
					$db_config['host'],
					$db_config['user'],
					$db_config['pass'],
					$db_config['db'],
					$db_config['port']
				);
		}

		if (!self::$_handle)
		{
			return false;
		}

		if (false == mysqli_set_charset(self::$_handle, "utf8"))
		{
			mysqli_close(self::$_handle);
			self::$_handle = false;
			return false;
		}

		return true;
	}

	/**
	 * 执行sql语句（INSERT, UPDATE, REPLACE or DELETE 等）
	 * @return 执行成功返回影响的行数(int)，执行失败返回false
	 */
	public static function execute($sql)
	{
		if (!self::init())
		{
			return false;
		}

		if (mysqli_query(self::$_handle, $sql))
		{
			return mysqli_affected_rows(self::$_handle);
		}

		return false;
	}

	/**
	 * 执行INSERT语句
	 * @return 执行成功返回插入的id，执行失败返回false
	 */
	public static function insert($sql)
	{
		if (!self::init())
		{
			return false;
		}

		if (mysqli_query(self::$_handle, $sql))
		{
			return mysqli_insert_id(self::$_handle);
		}

		return false;
	}

	/**
	 * 执行SELECT语句
	 * @return 执行成功返回查询结果的关联数组，执行失败返回false
	 */
	public static function query($sql)
	{
		if (!self::init())
		{
			return false;
		}

		$result = mysqli_query(self::$_handle, $sql);
		if ($result === false)
		{
			return false;
		}

		$res = array();
		while ($row = mysqli_fetch_assoc($result))
		{
			$res[] = $row;
		}
		mysqli_free_result($result);

		return $res;
	}

	/**
	 * 获取上一次错误信息
	 * @return 如果有，返回错误信息字符串；否则返回false
	 */
	public static function last_error()
	{
		if (!self::init())
		{
			return false;
		}

		if (mysqli_errno(self::$_handle))
		{
			return mysqli_errno(self::$_handle) . ' ' . mysqli_error(self::$_handle);
		}

		return false;
	}

	private static function _check_db_config($db_config)
	{
		$need_keys = array('user', 'pass', 'host', 'port', 'db');
		
		foreach ($need_keys as $key)
		{
			if (!isset($db_config[$key]) || empty($db_config[$key]))
			{
				return false;
			}
		}

		if ($db_config['port'] < 1024 || $db_config['port'] > 65535)
		{
			return false;
		}

		return true;
	}
}
