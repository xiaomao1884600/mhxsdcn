<?php

/**
 * 教师信息模型
 */
class UsergroupModel extends Local\Db\Base
{

	protected $table = 'usergroup';

	 /**
     * 获取用户组信息
     * @param $count      bool    是否统计总数
     * @param $condition  array   查询条件
     * @param order       string  排序
     * @param $offset     int     起始位置
     * @param $limit 	  int     偏移量
     * @return Array
     */
	public function getAllUserGroups($count = FALSE,$condition = array(), $order = '', $offset = 0, $limit = 10)
	{
		if ($count)
		{
			return $this->queryOne("
				SELECT 
					COUNT(*) AS total
				FROM " . $this->q(PREFIX . $this->table) ."
			");
		}
		$userGroups = array();
		$query = $this->queryArray("
			SELECT
				*
			FROM " . $this->q(PREFIX . $this->table) . "
			LIMIT {$offset}, {$limit}
		");

		if(!empty($query))
		{
			foreach ($query as $value)
			{
				$userGroups[$value['usergroupid']] = $value;
			}
		}
		return $userGroups;
	}
	
	/** 获取用户信息 
     *  @param $userid  INT 用户id
     *  
     * */
	public function getUserGroupById ($usergroupid)
	{
		if (empty($usergroupid))
		{
			return array();
		}
		
		return $this->queryFirst("
			SELECT * FROM " . ($this->q(PREFIX . $this->table)) . " AS usergroup
			WHERE usergroup.usergroupid = {$usergroupid}
		");
	}
}
