<?php

/**
 * 报名订单模型
 */
class OrderModel extends Local\Db\Base
{

	protected $table = 'order';

	public function createOrder($price, $time)
	{
		//创建订单
		$sql = "
				INSERT INTO " . $this->q("" . PREFIX . $this->table) . " SET
				`money` = '$price',
				`status` = '0',
				`dateline` = '$time'
			";
		return $this->insertOne($sql);
	}

	/**
	 *  获取订单信息
	 */
	public function getOrderInfo($orderid)
	{
		$sql = "SELECT
			*
			FROM " . $this->q("" . PREFIX . $this->table) . "
			WHERE orderid={$orderid}";
		return $this->queryFirst($sql);
	}

	/**
	 * 更新订单表
	 */
	public function updateOrder($trade_no, $time, $out_trade_no)
	{
		$sql = "
			UPDATE " . $this->q("" . PREFIX . $this->table) . " SET
			`status` = '1',
			`ordernumber` = '$trade_no',
			`completedateline` = '$time'
			 WHERE orderid = $out_trade_no
		";
		return $this->queryWrite($sql);
	}

	/**
	 * 更新订单表
	 */
	public function updatePayOrder($username, $phone, $orderid)
	{
		$sql = "
			UPDATE " . $this->q("" . PREFIX . $this->table) . " SET
			`username` = '$username',
			`telephone` = '$phone'
			 WHERE orderid = '$orderid'
		";
		return $this->queryWrite($sql);
	}

}