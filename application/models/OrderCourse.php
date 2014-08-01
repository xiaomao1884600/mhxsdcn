<?php

/**
 * 订单课程模型
 */
class OrderCourseModel extends Local\Db\Base
{

	protected $table = 'ordercourse';

	public function createOrderCourse($orderid, $id)
	{
		// 保存订单课程表
		$sql = "
			INSERT INTO " . $this->q("" . PREFIX . $this->table) . " SET
			`orderid` =  '$orderid',
			`courseid` = '$id'
			";
		return $this->queryWrite($sql);
	}

	/**
	 *  获取课程信息
	 */
	public function getOrderCourse($orderid)
	{
		$sql = "SELECT
			*
			FROM " . $this->q("" . PREFIX . $this->table) . "
			WHERE orderid={$orderid}";
		return $this->queryFirst($sql);
	}

}