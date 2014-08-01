<?php

/**
 * 课程班级模型
 */
class ClassModel extends Local\Db\Base
{

    protected $table = 'classes';

    /**
     * 获取所有班级信息
     */
    public function getAllClasses()
    {
        $sql = "SELECT
                id,facultieid as parentid,name,workimgpath,coursenum,imagenum,videonum,rank,hour,begintime,view,school
			FROM " . $this->q("" . PREFIX . $this->table) . "

            ORDER BY rank ASC
            ";

        //查看memcache是否存储该条sql
        $allClasses = Local\Util\Mem::queryMem($sql);
        if (!$allClasses)
        {
            $allClasses = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $allClasses,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        return $allClasses;
    }

    /**
     * 根据课程ID来获取班级信息
     */
    public function getOneClass($id)
    {
        // 专业名称
        $sql = "
			SELECT
                c.*, f.id as fid, f.name as fname
            FROM edu_classes AS c
			LEFT JOIN edu_faculties AS f ON (c.facultieid = f.id)
			WHERE c.id = '$id'
            ";

        //查看memcache是否存储该条sql
        $oneClasses = Local\Util\Mem::queryMem($sql);
        if (!$oneClasses)
        {
            $oneClasses = $this->queryFirst($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $oneClasses,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        return $oneClasses;
    }

    /**
     * 获取该班级下的课程
     */
    public function getClassCourses($id)
    {
        $sql = '
                SELECT
                    id,name,description,imgpath
                FROM edu_courses
                WHERE classid = ' . $id . '
                ORDER BY id
                ';

        //查看memcache是否存储该条sql
        $classCourses = Local\Util\Mem::queryMem($sql);
        if (!$classCourses)
        {
            $classCourses = $this->queryArray($sql);
            $array = array(
                'key' => Local\Util\Mem::getKey($sql),
                'value' => $classCourses,
                'Expire' => EXPIRE
            );
            Local\Util\Mem::setMem($array);
        }
        return $classCourses;
    }

    /**
     * 获取课程信息
     */
    public function getClass($courseId)
    {
        // 专业名称
        $sql = "
            SELECT
                *
            FROM " . $this->q("" . PREFIX . $this->table) . "
            WHERE id={$courseId}
            ";

        return $this->queryFirst($sql);
    }

	/***
	 * 获取订单课程ID
	 */
	public function getClassId($orderid)
	{
		$sql  = "
			SELECT
				classes.id
			FROM
			edu_order AS ord
			LEFT JOIN edu_ordercourse AS ordercourse ON ord.orderid = ordercourse.orderid
			LEFT JOIN edu_classes AS classes ON ordercourse.courseid = classes.id
			WHERE
			ord.orderid = {$orderid}
		";
		return $this->queryFirst($sql);
	}

}
