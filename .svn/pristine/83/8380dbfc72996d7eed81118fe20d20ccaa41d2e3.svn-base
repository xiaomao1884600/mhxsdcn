<?php

/**
 * 学生反馈信息模型
 */
class ReflectionsModel extends Local\Db\Base
{

    protected $table = 'reflections';

    public function getStudentReflections($offset = 0, $limit = 10)
    {
        $sql = "
            SELECT 
                *
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE school IN (0,1)
            ORDER BY dateline DESC
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
     * 获取学生反馈数量
     * @return integer
     */
    public function getStudentReflectionsNum()
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
