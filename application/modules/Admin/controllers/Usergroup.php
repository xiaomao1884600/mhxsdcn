<?php
/** 用户组管理 */
class UsergroupController extends CommonController
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
		$perpage = 5;
		//获取页码
		$page = $this->getRequest()->getParam('page');
		$page = max(1, $page);
		//用户组总数量
		$userGroupCount = $this->models['userGroupModel']->getAllUserGroups(TRUE);
		//偏移量
		$offset = ($page - 1) * $perpage;
		//总页数
		$pageTotal = ceil($userGroupCount / $perpage);
		$userGroups = $this->models['userGroupModel']->getAllUserGroups(FALSE, FALSE, '', $offset, $perpage);
		$this->getView()->assign('userGroups', $userGroups);
		$this->getView()->assign('page', $page);
		//分页
		$this->getView()->assign('pageNav', Local\Util\Page::pageNav($page, $pageTotal, ADMINURL . '/usergroup/index'));
	
	}
	
	/** 添加用户组 */
	public function addAction ()
	{
		$usergroupid = (int) $usergroupid;
		$page = $this->getRequest()->getParam('page');
	}
	
	/** 编辑用户组 */
	public function editAction ()
	{
		$usergroupid = (int) $this->getRequest()->getParam('usergroupid');
		$userGroupInfo = $this->models['userGroupModel']->getUserGroupById($usergroupid);
		$page = $this->getRequest()->getParam('page');
		$action = $this->getRequest()->getParam('action');
		
		//错误提示
		if (empty($action) && empty($userGroupInfo))
		{
			Local\Util\Page::displayError('该用户组不存在');
		}
		$this->getView()->assign('userGroupInfo', $userGroupInfo);
	}
	
	/** 添加\编辑用户组 */
	public function doeditAction()
	{
		//获取表单数据
		$action = $this->getRequest()->getPost('action');
		$data = array();
		$usergroupid = $this->getRequest()->getPost('usergroupid');
		$groupname = $this->getRequest()->getPost('groupname');
		$page = $this->getRequest()->getPost('page');
		//检测用户组名是否为空
		if (empty($groupname))
		{
			Local\Util\Page::displayError('用户组名不能为空');
		}
		
		$userGroupInfo = $this->models['userGroupModel']->getUserGroupById($usergroupid);
		//检测用户组是否存在
		if (empty($action) && empty($userGroupInfo))
		{
			Local\Util\Page::displayError('该用户组不存在');
		}
		$data['groupname'] = $groupname;
		$data['dateline'] = TIMENOW;
		unset($userGroupInfo);
		//保存数据
		if ($action)
		{
			$usergroupid = $this->models['userGroupModel']->insertData($data);
		}
		else 
		{
			$data['usergroupid'] = $usergroupid;
			$this->models['userGroupModel']->saveData($data);
		}
		$this->redirect('/admin/usergroup/edit/usergroupid/' . $usergroupid);
		return FALSE;
		
	}
	
	/** 禁用\激活用户组 */
	public function disabledAction ($usergroupid)
	{
		$usergroupid = (int) $usergroupid;
		$page = $this->getRequest()->getParam('page');
		$userGroupInfo = $this->models['userGroupModel']->getUserGroupById($usergroupid);
		//错误提示
		if (empty($userGroupInfo))
		{
			Local\Util\Page::displayError('该用户组不存在');
		}
		
		$data = array();
		$data['usergroupid'] = $usergroupid;
		$data['disabled'] = $userGroupInfo['disabled'] ? 0 : 1; 
		$data['dateline'] = TIMENOW;
		unset($userGroupInfo);
		//保存数据
		$this->models['userGroupModel']->saveData($data);
		$this->redirect('/admin/usergroup/index/page/' . $page);
		return FALSE;
		
	}
}