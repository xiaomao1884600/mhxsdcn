<?php 

/**
 * 课程模型
 */
class FacultiesModel extends Local\Db\Base
{
	protected $table = 'faculties_mobile';

	/**
     * 获取所有专业信息
     */
	public function getAllFaculties()
	{
		$sql = "SELECT
                id,name
			FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE isclose = 0
            ORDER BY rank ASC
            ";

         //查看memcache是否存储该条sql
        $allFaculties = Local\Util\Mem::queryMem($sql);
        if (!$allFaculties)
        {
            $allFaculties = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $allFaculties,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        $allFaculties = $this->queryArray($sql);
        return $allFaculties;
	}
	
	public function getFaculties()
	{
		$sql = "SELECT
                id,name
			FROM " . $this->q("" . PREFIX . $this->table) . "
            ORDER BY rank ASC
            ";

         //查看memcache是否存储该条sql
        $allFaculties = Local\Util\Mem::queryMem($sql);
        if (!$allFaculties)
        {
            $allFaculties = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $allFaculties,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        $allFaculties = $this->queryArray($sql);
        return $allFaculties;
	}
}

