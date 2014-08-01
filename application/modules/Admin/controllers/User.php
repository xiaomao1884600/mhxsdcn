<?php
/** 用户管理 */
class UserController extends CommonController
{
	public function init()
	{
		parent::init();
		// 获取用户组缓存
		if (is_file(CACHE_PATH . '/usergroup.json'))
		{
			$userGroups =  Local\Util\Cache::getCache(CACHE_PATH . '/usergroup.json');
		}
		else 
		{
			$userGroups = $this->models['userGroupModel']->getAllUserGroups();
		}
		//用户组信息
		$this->_view->assign('userGroups', $userGroups);
	}
 
	//获取信息
	public function indexAction()
	{
		$perpage = PERPAGE;
		$perpage = 10;
		//获取页码
		$page = $this->getRequest()->getParam('page');
		$page = max(1, $page);
		//用户总数量
		$userCount = $this->models['userModel']->getAllUsers(TRUE);
		//偏移量
		$offset = ($page - 1) * $perpage;
		//总页数
		$pageTotal = ceil($userCount / $perpage);
		$users = $this->models['userModel']->getAllUsers(FALSE, FALSE, 'lasttime DESC', $offset, $perpage);
		$this->getView()->assign('users', $users);
		$this->getView()->assign('page', $page);
		//分页
		$this->getView()->assign('pageNav', Local\Util\Page::pageNav($page, $pageTotal, ADMINURL . '/user/index'));
	}
	
	//编辑用户
	public function editAction()
	{
		//$userid = (int) $userid;
		$userid = $this->getRequest()->getParam('userid');
		$userInfo = $this->models['userModel']->getUserById($userid);
		$page = $this->getRequest()->getParam('page');
		$action = $this->getRequest()->getParam('action');
		//错误提示
		if (empty($action) && empty($userInfo))
		{
			Local\Util\Page::displayError('该用户不存在');
		}
		
		$this->getView()->assign('userInfo', $userInfo);
		$this->getView()->assign('page', $page);
	}
	
	public function doeditAction()
	{
		//获取表单数据
		$data = array();
		$userid = $this->getRequest()->getPost('userid');
		$data['usergroupid'] = $this->getRequest()->getPost('usergroupid');
		$password = $this->getRequest()->getPost('password');
		$repassword = $this->getRequest()->getPost('repassword');
		$page = $this->getRequest()->getPost('page');
		$action = $this->getRequest()->getPost('action');
		$username = $this->getRequest()->getPost('username');
		$email = $this->getRequest()->getPost('email');
		$age = $this->getRequest()->getPost('age');
		if ($userid)
		{
			$userInfo = $this->models['userModel']->getUserById($userid);
			//检测用户是否存在
			if (empty($action) && empty($userInfo))
			{
				Local\Util\Page::displayError('该用户不存在');
			}
			$data['userid'] = $userid;
		}
		
		if ($action)
		{
			if (empty($email))
			{
				Local\Util\Page::displayError('邮箱不能为空');
			}
			else
			{
				$regex = preg_match(USER_EMAILREGEX, $email);
				if (empty($regex))
				{
					Local\Util\Page::displayError('邮箱格式不符');
				}
			}
			if (empty($username))
			{
				Local\Util\Page::displayError('用户名不能为空');
			}
			$data['username'] = $username;
			$data['age'] = $age;
			$data['email'] = $email;
		}
		//若是修改密码，必须都填写密码，不写密码则只修改用户组
		if ($action || $password || $repassword)
		{
			//检测两次密码是否一致
			if ($password !== $repassword)
			{
				Local\Util\Page::displayError('两次密码不一致');
			}
			
			if ($password)
			{
				if (USER_PASSWORD_MIN > strlen($password) || USER_PASSWORD_MAX < strlen($password))
				{
					Local\Util\Page::displayError('密码长度不符');
				}
				if ($action)
				{
					//获取随机字符串
					$salt = Local\Util\String::randString(4);
				}
				elseif ($userInfo)
				{
					$salt = $userInfo['salt'];
				}
				$data['password'] = md5(md5($password) . $salt);
			}
		}
		
		unset($userInfo);
		//保存数据
		if ($action)
		{
			$userid = $this->models['userModel']->insertData($data);
			if ($userid)
			{
				$this->redirect('/admin/user/index');
			}
		}
		else 
		{
			$this->models['userModel']->saveData($data);
			$this->redirect('/admin/user/edit/userid/' . $data['userid']);
		}
		
		return FALSE;
	}
	
	/** 禁用\激活用户 */
	public function disabledAction ($userid)
	{
		$userid = (int) $userid;
		$userInfo = $this->models['userModel']->getUserById($userid);
		$page = $this->getRequest()->getParam('page');
		//错误提示
		if (empty($userInfo))
		{
			Local\Util\Page::displayError('该用户不存在');
		}
		
		$data = array();
		$data['userid'] = $userid;
		$data['disabled'] = $userInfo[0]['disabled'] ? 0 : 1; 
		
		//保存数据
		$this->models['userModel']->saveData($data);
		$this->redirect('/admin/user/index/page/' . $page);
		return FALSE;
		
	}
}