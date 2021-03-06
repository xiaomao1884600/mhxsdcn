<?php

/**
 * 选课报班
 *
 */
class ClassesController extends Local\Controller\Base
{

	/**
	 * 初始化方法
	 */
	public function init()
	{
		$this->models = array(
			'classModel' => new ClassModel(),
			'orderModel' => new OrderModel(),
			'orderCourseModel' => new OrderCourseModel(),
			'classmobileModel' => new ClassmobileModel(),
		);
	}

	/**
	 * 选课报班首页
	 */
	public function indexAction()
	{
		$classid = (int) $this->getRequest()->getparam('classid');

		if(34==$classid)
		{
			header("location:".SYSTEMURL."/topic/pm2014/index.php");exit();
		}
		elseif (1071==$classid)
		{
			header("location:".SYSTEMURL."/topic/ui2014/index.php");exit();
		}
		elseif (48==$classid)
		{
			header("location:".SYSTEMURL."/topic/illustration2014/index.php");exit();
		}
        elseif (1087==$classid)
        {
            header("location:".SYSTEMURL."/topic/jzdh2014/index.php");exit();
        }
        elseif (1123==$classid)
        {
            header("location:".SYSTEMURL."/topic/snsj2014/index.php");exit();
        }		
        elseif (1119==$classid)
        {
            header("location:".SYSTEMURL."/topic/yxdhds2014/index.php");exit();
        }

		$courseinfo = $this->models['classModel']->getOneClass($classid);
		if (!empty($courseinfo))
		{
			$courseinfo['begintime'] = unserialize($courseinfo['begintime']);
			$courseinfo['satisfaction'] = unserialize($courseinfo['satisfaction']);
			$courseinfo['newcourses'] = unserialize($courseinfo['newcourses']);
			$courseinfo['relatenews'] = unserialize($courseinfo['relatenews']);
			$courseinfo['extrainfo'] = unserialize($courseinfo['extrainfo']);
			$courseinfo['classcourses'] = $this->models['classModel']->getClassCourses($classid);
		}


		$rank = array();
		$extrainfo = (empty($courseinfo['extrainfo'][$i])) ? ' ' : "({$courseinfo['extrainfo'][$i]})";
		// 报名状态
		$state_array = array(
			1 => '报名中',
			2 => '紧　张',
			3 => '报　满',
		);

		$this->getView()->assign('courseinfo', $courseinfo);
		$this->getView()->assign('state_array', $state_array);
	}

	/**
	 * 课程报名
	 *
	 */
	public function payonlineAction($classid)
	{
		$classid = (int) $classid;
		//获取班级信息
		$classInfo = $this->models['classmobileModel']->getClassById($classid);
		$price = $classInfo['price'] ? $classInfo['price'] : 0.01;
		//时间
		define(TIMENOW, $_SERVER['REQUEST_TIME']);
		//选课 课程id
		$time = TIMENOW;

		//生成订单 返回订单号
		$orderid = $this->models['orderModel']->createOrder($price, $time);

		//写入订单课程表
		$res = $this->models['orderCourseModel']->createOrderCourse($orderid, $classid);

		header("location:" . ROOT . "/alipayapi/index/orderid/" . $orderid);
	}

}