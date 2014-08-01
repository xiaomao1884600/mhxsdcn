<?php

/* * *
 * 导航模型
 */

class BannersModel extends Local\Db\Base
{

	protected $table = 'banners';

	/**
	 * 获取banner
	 */
	public function getBanner()
	{
		$sql = "SELECT
			*
			FROM " . $this->q("" . PREFIX . $this->table) . "
			WHERE type =0
			ORDER BY dateline desc";
		return $this->queryArray($sql);
	}

	/**
	 * 获取banner
	 */
	public function getAllBanners()
	{
		$sql = "SELECT
			*
			FROM " . $this->q("" . PREFIX . $this->table) . "
			ORDER BY dateline desc";
		return $this->queryArray($sql);
	}
	
}