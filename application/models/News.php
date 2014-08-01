<?php

/**
 * 课程班级模型
 */
class NewsModel extends Local\Db\Base
{

    protected $table = 'news';

    public function getNews($type, $num)
    {
        //火星看点
        $sql = "
			SELECT
				title, pic, link, description
			FROM" . $this->q("" . PREFIX . $this->table) . "
			WHERE type = {$type}
			AND school IN (0, 1)
			ORDER BY ordernum
			LIMIT 0 , {$num}
		";

        //查看memcache是否存储该条sql
        $getnews = Local\Util\Mem::queryMem($sql);
        if (!$getnews)
        {
            $getnews = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $getnews,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        return $getnews;
    }

}
