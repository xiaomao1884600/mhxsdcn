<?php

/**
 * 系统设置
 */
class SettingModel extends Local\Db\Base
{
	protected $table = 'setting';
	
	/** 获取系统设置信息 */
	public function getSettings()
	{
		return $this->queryArray("
			SELECT * 
			FROM " . $this->q(PREFIX. $this->table) . "setting
			ORDER BY setting.sort ASC
		");
	}
}
