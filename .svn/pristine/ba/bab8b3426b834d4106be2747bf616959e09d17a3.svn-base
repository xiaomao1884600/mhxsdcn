<?php

/**
 * 首页控制器
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class IndexController extends Local\Controller\Base
{

	/**
	 * 初始化方法
	 *
	 */
	public function init()
	{
		$this->models['blogPostModel'] = new BlogpostModel();
		$this->models['bannersModel'] = new BannersModel();
		$this->models['facultiesModel'] = new facultiesModel();
		$this->models['classmobileModel'] = new classmobileModel();
	}

	/**
	 * 首页
	 *
	 */
	public function indexAction()
	{
		$blogposts = $this->models['blogPostModel']->getBlogPost(9);
		$banners = $this->models['bannersModel']->getBanner();
		$faculties = $this->models['facultiesModel']->getAllFaculties();
		$classesmobile = $this->models['classmobileModel']->getAllClassesmobile();

		if(!empty($faculties))
		{
			foreach ($faculties as $key => &$value) 
			{
				foreach ($classesmobile as $k => $v) 
				{
					if($value['id'] == $v['facultieid'])
					{
						$value['class'][] = $v;
					}
				}
			}
		}
		$this->_view->assign('faculties',$faculties);
		$this->_view->assign('blogposts',$blogposts);
		$this->_view->assign('banners',$banners);
	}

}