<?php
/** 管理员登陆 */
class LoginController extends Local\Controller\Base
{
	public function init()
	{
		$this->models['userModel'] = new UserModel();
		//判断用户是否登录
		$this->adminInfo = $this->models['userModel']->getAdminInfo();
		if (!empty($this->adminInfo))
		{
			$this->redirect('/admin');
		}
	}
	
	//用户登录
	public function indexAction()
	{
		$title = '管理员登陆';
		$this->_view->assign('title', $title);
	} 
	
	//处理用户登录
	public function accountAction()
	{
		$email = $this->getRequest()->getPost('email');
		$password = $this->getRequest()->getPost('password');
		if (empty($email))
		{
			Local\Util\Page::displayError('邮箱不能为空');
		}
		if (empty($password))
		{
			Local\Util\Page::displayError('密码不能为空');
		}
		if ($email)
		{
			$adminInfo = $this->models['userModel']->getUserByEmail($email);
			if (empty($adminInfo))
			{
				Local\Util\Page::displayError('该用户不存在');
			}
			//验证密码
			if ($adminInfo['password'] == md5(md5($password) . $adminInfo['salt']))
			{
				//写入COOKIE
				if (in_array($adminInfo['usergroupid'], array(
						USERGROUP_ID_SUPERADMIN,
						USERGROUP_ID_ADMIN
				)))
				{
					Local\Header\Cookies::setCookie('email', $adminInfo['email']);
					Local\Header\Cookies::setCookie('password', $adminInfo['password']);
					Local\Header\Cookies::setCookie('adminemail', $adminInfo['email']);
					Local\Header\Cookies::setCookie('adminpassword', $adminInfo['password']);
					//登陆成功跳转后台首页
					$this->redirect('/admin');
				}
				else 
				{
					Local\Util\Page::displayError('无访问权限');
				}
			}
			else 
			{
				Local\Util\Page::displayError('密码不正确');
			}
		}
		return false;
	}
}