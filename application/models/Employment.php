<?php

/**
 * 就业模型
 */
class EmploymentModel extends Local\Db\Base
{

    protected $table = 'employment';

    /**
     * 获取星明学员信息
     * @return Array
     */
    public function getStarStudents($offset = 0, $limit = 20)
    {
        $sql = "
            SELECT
                name, photo, employment, link
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE isstar = 1 
            AND school IN (0,1)
            ORDER BY ordernum
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
     * 获取明星学员数量
     * @return integer
     */
    public function getStarStudentsNum()
    {
        $sql = "
            SELECT
                COUNT(*)
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE isstar = 1 
            AND school IN (0,1)
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
