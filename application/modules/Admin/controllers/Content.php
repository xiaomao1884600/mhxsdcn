<?php
/** 内容管理  */
class ContentController extends CommonController
{
	public function init()
	{
		parent::init();
		//获取系
		$this->models['facultiesModel'] = new FacultiesModel();
		$this->models['classmobileModel'] = new ClassmobileModel();
		$faculties = $this->models['facultiesModel']->getFaculties();
		$this->_view->assign('faculties',$faculties);
	}
	//获取专业班
	public function indexAction()
	{
		$perpage = PERPAGE;
		$perpage = 10;
		$page = $this->getRequest()->getParam('page');
		$page = max(1, $page);
		//班级总数
		$classesmobileTotal = $this->models['classmobileModel']->getAllClasses(TRUE);
		//偏移量
		$offset = ($page - 1) * $perpage;
		//总页数
		$pageTotal = ceil($classesmobileTotal / $perpage);
		$classesmobile = $this->models['classmobileModel']->getAllClasses(false, false, ' rank ASC ', $offset, $perpage);
		//
		$this->getView()->assign('classesmobile', $classesmobile);
		$this->getView()->assign('page', $page);
		//分页
		$this->getView()->assign('pageNav', Local\Util\Page::pageNav($page, $pageTotal, ADMINURL . '/content/index'));
	
	}
	//编辑班级
	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		$classInfo = $this->models['classmobileModel']->getClassById($id);
		$page = $this->getRequest()->getParam('page');
		$action = $this->getRequest()->getParam('action');
		if (empty($action) && empty($classInfo))
		{
			Local\Util\Page:: displayError('该班级不存在');
		}
		//获取班级封面图
		//$imgpath = Local\Util\Page::getImageCacheURL($classInfo['imgpath'], '', 'jpg');
		
		$this->getView()->assign('classInfo', $classInfo);
		$this->getView()->assign('page', $page);
	}
	//保存数据
	public function doeditAction()
	{
		$data = array();
		$id = $this->getRequest()->getPost('id');
		$classInfo = $this->models['classmobileModel']->getClassById($id);
		$page = $this->getRequest()->getPost('page');
		$action = $this->getRequest()->getPost('action');
		$name = $this->getRequest()->getPost('name');
		$facultieid = $this->getRequest()->getPost('facultieid');
		$description = $this->getRequest()->getPost('description');
		$price = $this->getRequest()->getPost('price');
		//上传的文件
		$file = $_FILES['img'];
		if (0 == $file['error'])
		{
			//生成文件名
			$extname = explode('.', $file['name']);
			$filename = date('Ymd') . rand(1, 1000) . '.' . strtolower(end($extname));
			//判断文件格式
			$ext = strtolower(end($extname));
		
			if (!in_array($ext, explode(',', PICTYPE)))
			{
				Local\Util\Page:: displayError('文件格式不符');
			}

			//文件保存路径
			$filePath = '/' . Local\Util\Time::formatDate(TIMENOW, 'Ym') . '/';
			$fileDir = CLASSMOBILEPATH . PICDIR;
			// 通过在bootstrap 中初始化文件上传类
			Yaf\Registry::get('upload')->UploadFiles($file, $fileDir . $filePath, $filename);
			// 文件上传
			$uploadStatus = Yaf\Registry::get('upload')->upload();
		
			if ($uploadStatus)
			{
				//调用文件上传状态验证
				Local\Util\Page::checkUploadStatus();
			}
			else
			{
				//保存文件名
				$data['imgpath'] = PICDIR . $filePath . $filename;
			}
		}
		$data['facultieid'] = $facultieid;
		if ($name)
		{
			$data['name'] = $name;
		}
		
		$data['description'] = $description;
		$data['price'] = $price;

		if (empty($action) && empty($classInfo))
		{
			Local\Util\Page:: displayError('该班级不存在');
		}
		
		if ($action)
		{
			if (empty($name))
			{
				Local\Util\Page:: displayError('班级名称不能为空');
			}
			
			$insertId = $this->models['classmobileModel']->insertData($data);
			if ($insertId)
			{
				$id = $insertId;
			}
		}
		else 
		{
			$data['classes_mobileid'] = $id;
			$this->models['classmobileModel']->saveData($data);
		}
		unset($data);
		$this->redirect('/admin/content/edit/id/' . $id);
	}
	
	//禁用班级
	public function disabledAction()
	{
		$data = array();
		$id = $this->getRequest()->getParam('id');
		$classInfo = $this->models['classmobileModel']->getClassById($id);
		if (empty($classInfo))
		{
			Local\Util\Page:: displayError('该班级不存在');
		}
		$data['classes_mobileid'] = $id;
		$data['isclose'] = $classInfo['isclose'] ? 0 : 1;
		$this->models['classmobileModel']->saveData($data);
		unset($data);
		$this->redirect('/admin/content/index');
	}
	
	//排序
	public function rankAction()
	{
		$rank = $this->getRequest()->getPost('rank');
		if (!is_array($rank))
		{
			Local\Util\Page::displayError('班级不存在');
		}
		
		$this->models['classmobileModel']->rankClasses($rank);
		unset($rank);
		$this->redirect('/admin/content/index');
	}
}