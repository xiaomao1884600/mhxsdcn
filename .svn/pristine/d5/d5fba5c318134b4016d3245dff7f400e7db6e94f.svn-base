<?php

/**
 * 学习生活模型
 * 
 */
class CampusLifeModel extends Local\Db\Base
{

    protected $table = 'campus_life';

    /**
     * 获取毕业班级学生留影信息
     * @param type $type
     * @param type $offset
     * @param type $limit
     * @param type $category
     * @return type
     */
    public function getStudentPictures($type, $offset = 0, $limit = 21, $category = '')
    {
        $category = $category ? 'AND category=' . $category : '';
        $sql = "
                SELECT
                    *
                FROM " . $this->q("" . PREFIX . $this->table) . "
                WHERE type={$type}
                $category
                AND school IN (0,1)
                ORDER BY iscommend desc,ordernum,dateline desc 
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
     * 获取数据总数
     * @return type
     */
    public function getStudentPicturesNum($type, $category = '')
    {
        $category = $category ? 'AND category=' . $category : '';
        $sql = "
                SELECT 
                    COUNT(*)
                FROM " . $this->q("" . PREFIX . $this->table) . "
                WHERE type={$type}
                $category
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
