<?php
/** 基类文件 */
class CommonController extends Local\Controller\Base
{
	public function init()
	{
		//加载模型
		$this->models['blogPostModel'] = new BlogpostModel();
		$this->models['bannersModel'] = new BannersModel();
		$this->models['userModel'] = new UserModel();
		$this->models['userGroupModel'] = new UsergroupModel();
		$blogposts = $this->models['blogPostModel']->getBlogPost(3);
		$banners = $this->models['bannersModel']->getBanner();
		
		//判断用户是否登录
		$this->adminInfo = $this->models['userModel']->getAdminInfo();
		if (empty($this->adminInfo))
		{
			$this->redirect('/admin/login/index');
		}
		else
		{
			// 管理员信息
			$this->getView()->assign('adminInfo', $this->adminInfo);
		}
		//定义导航数组
		$breadCrumb = array(
			'setting' => '系统设置',
			'content' => '内容管理',
			'usergroup' => '用户组管理',
			'user' => '用户管理',
			'permission' => '权限管理',
		);
		$title = $breadCrumb[CONTROLLER_NAME];
		//默认显示系统设置
		if ('index' == CONTROLLER_NAME) 
		{
			$title = $breadCrumb['setting'];
		}
		
		//面包屑导航
		$this->getView()->assign('title', $title);
		$this->getView()->assign('breadCrumb', Local\Util\Page::dispayBreadCrumb($title, array(), TRUE));
		//导航栏
		$this->_view->assign('navbar', $breadCrumb);
		//火星看点
		$this->_view->assign('blogposts', $blogposts);
		$this->_view->assign('banners', $banners);
		if ('index' == CONTROLLER_NAME)
		{
			$this->redirect('/admin/setting/index');
		}
	}
}