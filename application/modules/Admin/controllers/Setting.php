<?php
/** 用户管理 */
class SettingController extends CommonController
{
	public function init()
	{
		parent::init();
		$this->models['settingModel'] = new SettingModel();
	}
	
	//获取信息
	public function indexAction()
	{
		$settings = $this->models['settingModel']->getSettings();
		$this->getView()->assign('settings', $settings);
	}
	
	//更新系统设置
	public function editAction()
	{
		$settings = $this->getRequest()->getPost('setting');
		foreach ($settings as $key => $value)
		{
			$data = array();
			$data['settingid'] = $key;
			$data['value'] = $value['value'];
			$data['sort'] = $value['sort'];
			
			//更新数据
			$this->models['settingModel']->saveData($data);
			unset($data);
			
			// 更新缓存
			$setting = $this->models['settingModel']->getSettings();
			Local\Util\Cache::setCache(CACHE_PATH. '/setting.json', $setting);
		}
		
		$this->redirect('/admin/setting/index');
	}
}