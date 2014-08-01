<?php

/**
 * 教师信息模型
 */
class TeachersModel extends Local\Db\Base
{

    protected $table = 'teachers';

    /**
     * 获取教师信息
     * @return Array
     */
    public function getTeachers($offset = 0, $limit = 8)
    {
        $sql = "
            SELECT 
                *
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE school IN (0,1)
            ORDER BY displayorder ASC, dateline ASC
            LIMIT {$offset},{$limit}
            ";

        //查看memcache是否存储该条sql
        $memcache = Local\Util\Mem::queryMem($sql);
        if (!$memcache)
        {
            $memcache = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $memcache,
                'Expire' => 300
            );
            Local\Util\Mem::setMem($array);
        }
        return $memcache;
    }

    /**
     * 获取老师数量
     * @return integer
     */
    public function getTeachersNum()
    {
        $sql = "
            SELECT 
                COUNT(*)
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE school IN (0,1)
            ";

        //查看memcache是否存储该条sql
        $memcache = Local\Util\Mem::queryMem($sql);
        if (!$memcache)
        {
            $memcache = $this->queryOne($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $memcache,
                'Expire' => 300
            );
            Local\Util\Mem::setMem($array);
        }
        return $memcache;
    }

}
