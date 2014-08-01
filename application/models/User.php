<?php

/**
 * 教师信息模型
 */
class UserModel extends Local\Db\Base
{

    protected $table = 'user';

    /**
     * 获取用户信息
     * @param $count      bool    是否统计总数
     * @param $condition  array   查询条件
     * @param order       string  排序
     * @param $offset     int     起始位置
     * @param $limit 	  int     偏移量
     * @return Array
     */
    public function getAllUsers($count = FALSE,$condition = array(), $order = 'dateline ASC', $offset = 0, $limit = 10)
    {
    	//统计用户总数
    	if ($count)
    	{
    		return $this->queryOne("
			SELECT
				COUNT(*)
			FROM " . $this->q("" . PREFIX  . $this->table) . " AS user
			WHERE user.deleted = 0
           " . (is_array($condition) ? implode('AND', $condition): '' ) . "
		");
    	}
    	
    	//获取用户
        $sql = "
            SELECT 
                *
            FROM " . $this->q("" . PREFIX . $this->table) . " AS user
            WHERE user.deleted = 0
           " . (is_array($condition) ? implode('AND', $condition): '' ) . "
            ORDER BY " . $order . "
            LIMIT {$offset},{$limit}
            ";

        return $this->queryArray($sql);
//        //查看memcache是否存储该条sql
//        $memcache = Local\Util\Mem::queryMem($sql);
//        if (!$memcache)
//        {
//            $memcache = $this->queryArray($sql);
//            $array = array(
//                'key' => Local\Util\Mem::getKey($sql),
//                'value' => $memcache,
//                'Expire' => 300
//            );
//            Local\Util\Mem::setMem($array);
//        }
//        return $memcache;
    }
    
    /** 获取用户信息 
     *  @param $userid  INT 用户id
     *  
     * */
	public function getUserById ($userid)
	{
		if (empty($userid))
		{
			return array();
		}
		if (is_array($userid))
		{
			$userid[] = -1;
			return $this->queryArray("
			SELECT * FROM " . ($this->q(PREFIX . $this->table)) . " AS user
			WHERE user.deleted = 0
			AND user.userid IN(" . implode(',', $userid) . ")
		");
		}
		else
		{
			$userid = (int) $userid;
			return $this->queryFirst("
			SELECT * FROM " . ($this->q(PREFIX . $this->table)) . " AS user
			WHERE user.deleted = 0
			AND user.userid = {$userid}
		");
		}
		
	}
	
	/**
	 *  通过邮箱获取用户信息 
	 * @param $email   STRING  邮箱 
	 * 
	 * */
	public function getUserByEmail($email)
	{
		if (empty($email))
		{
			return array();
		}
		$email = "'$email'";
		$adminInfo = array();	
		$adminInfo = $this->queryFirst("
			SELECT * 
			FROM " . ($this->q(PREFIX . $this->table)) ." AS user
			WHERE user.email = {$email}
			LIMIT 1
		");
		return $adminInfo;
	}
	
	/** 获取用户信息 */
	public function getAdminInfo()
	{
		$adminInfo = array();
		$httpRequest = new Yaf\Request\Http();
		//获取cookie
		$email = $httpRequest->getCookie('adminemail');
		$password = $httpRequest->getCookie('adminpassword');
		
		if ($email)
		{
			$adminInfoQuery = $this->getUserByEmail($email);
			if ($adminInfoQuery['password'] == $password)
			{
				$adminInfo = $adminInfoQuery;
			}
			unset($adminInfoQuery, $email, $password);
		}
		return $adminInfo;
	}
	
}
