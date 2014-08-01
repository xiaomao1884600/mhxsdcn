<?php

/**
 * 就业控制器
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class EmploymentController extends Local\Controller\Base
{
    /**
	 * 初始化方法
	 */
	public function init()
	{
		$this->models = array(
			'employmentModel' => new EmploymentModel()
		);
	}
    
    /**
     * 首页
     */
    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page');
        $page = max(1, $page);

        //获取学员留影数量
        $starStudentNum = $this->models['employmentModel']->getStarStudentsNum();
        //总页数
        $pageTotal = ceil($starStudentNum / 16);
        //查询偏移量
        $page = $page > $pageTotal ? $pageTotal : $page;
        $offset = ($page - 1) * 16;
        
        //获取明星学员信息
        $data = $this->models['employmentModel']->getStarStudents($offset, 16);
        
        $this->getView()->assign('data', $data);
        $this->getview()->assign('pageNav', $this->models['employmentModel']->pageNav($page, $pageTotal, '/employment/index', 1));
    }
}
