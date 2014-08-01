<?php 

/**
 * 手机版专业班级模型
 */

class ClassmobileModel extends Local\Db\Base
{

	protected $table = 'classes_mobile';


	/**
	 * 获取所有的班级
	 */
	public function getAllClassesmobile()
	{
		$sql = "SELECT
                *
			FROM " . $this->q("" . PREFIX . $this->table) . "
			WHERE isclose = 0
            ORDER BY rank ASC
            ";
            
 		 //查看memcache是否存储该条sql
        $allClassesmobile = Local\Util\Mem::queryMem($sql);
        if (!$allClassesmobile)
        {
            $allClassesmobile = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $allClassesmobile,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        $allClassesmobile = $this->queryArray($sql);
        return $allClassesmobile;
	}

	  /**
     * 获取用户信息
     * @param $count      bool    是否统计总数
     * @param $condition  array   查询条件
     * @param order       string  排序
     * @param $offset     int     起始位置
     * @param $limit 	  int     偏移量
     * @return Array
     */
    public function getAllClasses($count = FALSE,$condition = array(), $order = '', $offset = 0, $limit = 10)
    {
    	//统计班级总数
    	if ($count)
    	{
    		return $this->queryOne("
			SELECT
				COUNT(*)
			FROM " . $this->q("" . PREFIX  . $this->table) . " AS class
			WHERE class.classes_mobileid >= 1
           " . (is_array($condition) ? implode('AND', $condition): '' ) . "
		");
    	}
    	
    	//获取班级
        $sql = "
            SELECT 
                *
            FROM " . $this->q("" . PREFIX . $this->table) . " AS class
          	WHERE class.classes_mobileid >= 1
           " . (is_array($condition) ? implode('AND', $condition): '' ) . "
            " . ($order ? "ORDER BY " . $order . "" : '') . "
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
    
    /** 获取某个班级 */
    public function getClassById($id)
    {
    	if (empty($id))
    	{
    		return array();
    	}
    	if (is_array($id))
    	{
    		$id[] = -1;
    		return $this->queryArray("
    			SELECT * 
    			FROM " . ($this->q(PREFIX . $this->table)) . " AS class
    			WHERE class.classes_mobileid IN(" . (implode(',', $id)) . ")
    		");
    	}
    	else 
    	{
    		$id = (int) $id;
    		return $this->queryFirst("
    			SELECT *
    			FROM " . ($this->q(PREFIX . $this->table)) . " AS class
    			WHERE class.classes_mobileid = {$id}
    		");
    	}
    }
    
    /** 批量更新班级排序 */
    public function rankClasses($rank)
    {
    	if (!is_array($rank))
    	{
    		return ;
    	}
    	$ids = implode(',', array_keys($rank));
    	$sql = "UPDATE " .($this->q(PREFIX . $this->table)). " AS class 
    		SET class.rank= CASE class.classes_mobileid ";
    	foreach ($rank as $id => $value)
    	{
    		$sql .= sprintf("WHEN %d THEN %d ", $id, $value);
    	}
    	$sql .= "END WHERE class.classes_mobileid IN (" . ($ids) .")" ;
    	$this->queryWrite($sql);
    }
}