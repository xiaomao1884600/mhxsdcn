<?php

/**
 * 缓存类
 *
 * @author $Author: 5590548@qq.com $
 *
 */

namespace Local\Util;

class Mem
{
	//memcache对象
	static protected $memcache;

	public  function __construct($driver)
	{
		self::$memcache = new \Memcache;
		self::$memcache->connect($driver['host'],$driver['port']) or die('Could not connect');

	}

	/**
	 * 查询memcache中是否已经存储
	 *
	 */
	public static function queryMem($sql)
	{

		$key = self::getKey($sql);

		if(!$value = self::getMem($key))
		{
			return FALSE;
		}
		else
		{
			return $value;
		}
	}

	/**
	 * memcache查询
	 *
	 */
	public static function getMem($key)
	{
		return self::$memcache->get($key);
	}


	/**
	 * memcache写操作
	 *
	 */
	public static function setMem($avgArr)
	{
		if($avgArr)
		{
			return self::$memcache->set($avgArr['key'],$avgArr['value'],0,(int)$avgArr['Expire']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 对key值加密
	 *
	 */
	public static function getKey($sql)
	{
		return md5($sql);
	}

}