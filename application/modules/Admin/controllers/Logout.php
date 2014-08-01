<?php

/**
 * 管理员注销控制器
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class LogoutController extends Local\Controller\Base
{
	public function init()
	{
		$this->models['userModel'] = new UserModel();
	}
	/**
	 * 管理员注销
	 *
	 */
	public function indexAction()
	{
		$userid = $this->getRequest()->getParam('userid');
		if ($userid)
		{
			//获取用户信息
			$userInfo = $this->models['userModel']->getUserById($userid);
			if (empty($userInfo))
			{
				Local\Util\Page::displayError('用户不存在', ROOT . '/admin');
			}
			//清除 COOKIE
			Local\Header\Cookies::clearCookie('email');
			Local\Header\Cookies::clearCookie('password');
			Local\Header\Cookies::clearCookie('adminemail');
			Local\Header\Cookies::clearCookie('adminpassword');
			
			//清除全局数据
			Yaf\Registry::del('userInfo');
			Yaf\Registry::del('adminInfo');
			//跳转后台登陆页
			$this->redirect('/admin/login/index');
		}
		return false;
	}

}