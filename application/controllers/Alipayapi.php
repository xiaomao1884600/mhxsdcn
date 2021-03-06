<?php

/**
 * 首页控制器
 *
 * @author $Author: 5590548@qq.com $
 *
 */
class AlipayapiController extends Local\Controller\Base
{

	/**
	 * 初始化方法
	 *
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
	 * 首页
	 *
	 */
	public function indexAction()
	{
		/*		 *
		 * 功能：即时到账交易接口接入页
		 * 版本：3.3
		 * 修改日期：2012-07-23
		 */

		Yaf\Loader::import("Third/Alipay/alipay.config.php");
		Yaf\Loader::import("Third/Alipay/lib/alipay_submit.class.php");

		//订单号
		$orderId = (int)$this->getRequest()->getParams('orderid')['orderid'];
		// 订单信息
		$orderInfo = $this->models['orderModel']->getOrderInfo($orderId);
		// 获取订单课程表信息
		$orderCourse = $this->models['orderCourseModel']->getOrderCourse($orderId);

		$courseId = $orderCourse['courseid'];

		//$courseInfoes = $this->models['classModel']->getClass($courseId);
		$courseInfoes = $this->models['classmobileModel']->getClassById($courseId);
		/*		 * ************************请求参数************************* */

		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = ROOT . "/" . CONTROLLER_NAME . "/notifyurl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数
		//页面跳转同步通知页面路径
		$return_url = ROOT . "/" . CONTROLLER_NAME . "/returnurl";
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
		//卖家支付宝帐户
		$seller_email = "edu@hxsd.cn";
		//必填
		//商户订单号
		$out_trade_no = "$orderId";
		//商户网站订单系统中唯一订单号，必填
		//订单名称
		$subject = "在线报名";
		//必填
		//付款金额
		$total_fee = $orderInfo['money'];
		//必填
		//订单描述

		$body = trim("在线报名");
		//商品展示地址
		$show_url = SYSTEMURL . "/curriculum/class/classid/{$courseId}";
		//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		//客户端的IP地址
		$exter_invoke_ip = $_SERVER['REMOTE_ADDR'];
		//非局域网的外网IP地址，如：221.0.0.1


		/*		 * ********************************************************* */

		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => "create_direct_pay_by_user",
			"partner" => trim($alipay_config['partner']),
			"payment_type" => $payment_type,
			"notify_url" => $notify_url,
			"return_url" => $return_url,
			"seller_email" => $seller_email,
			"out_trade_no" => $out_trade_no,
			"subject" => $subject,
			"total_fee" => $total_fee,
			"body" => $body,
			"show_url" => $show_url,
			"anti_phishing_key" => $anti_phishing_key,
			"exter_invoke_ip" => $exter_invoke_ip,
			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
		);

		// 定义类型为重定向提交
		//$type = ALIPAY_REDIRECT_SUBMIT;
		//include $cfg_basedir.$cfg_templets_dir."/eduhtml/pay_success.html";
		//建立请求
		$alipaySubmit = new \AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter, "post", "确认");
		echo $html_text;
	}

	public function notifyurlAction()
	{
		/*		 *
		 * 功能：支付宝服务器异步通知页面
		 * 版本：3.3
		 * 日期：2012-07-23
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


		 * ************************页面功能说明*************************
		 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
		 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
		 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
		 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
		 */

		Yaf\Loader::import("Third/Alipay/alipay.config.php");
		Yaf\Loader::import("Third/Alipay/lib/alipay_notify.class.php");

		//计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if ($verify_result)
		{//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号

			$trade_no = $_POST['trade_no'];

			//交易状态
			$trade_status = $_POST['trade_status'];


			if ($_POST['trade_status'] == 'TRADE_FINISHED')
			{
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS')
			{
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

			echo "success";  //请不要修改或删除
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else
		{
			//验证失败
			echo "fail";

			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}

	public function returnurlAction()
	{
		/*		 *
		 * 功能：支付宝页面跳转同步通知页面
		 * 版本：3.3
		 * 日期：2012-07-23
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

		 * ************************页面功能说明*************************
		 * 该页面可在本机电脑测试
		 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
		 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
		 */

		Yaf\Loader::import("Third/Alipay/alipay.config.php");
		Yaf\Loader::import("Third/Alipay/lib/alipay_notify.class.php");

		define(TIMENOW, $_SERVER['REQUEST_TIME']);
		$time = TIMENOW;
		//计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();

		//商户订单号

		$out_trade_no = $_GET['out_trade_no'];

		// 订单信息
		$orderInfo = $this->models['orderModel']->getOrderInfo($out_trade_no);
		//获取该订单课程ID
		$courseInfo = $this->models['classModel']->getClassId($out_trade_no);

		if ($verify_result)
		{//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			//支付宝交易号
			$trade_no = $_GET['trade_no'];

			//交易状态
			$trade_status = $_GET['trade_status'];

			if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS')
			{
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序

				if ("0" == $orderInfo['status'])
				{
					// 更新订单信息
					$orderInfo = $this->models['orderModel']->updateOrder($trade_no, $time, $out_trade_no);
				}
			}
			else
			{
				echo "trade_status=" . $_GET['trade_status'];
			}

			$type = ALIPAY_SUCCESS;

			//header("location:http://edu.hxsd.test/edu/pay_success.php?orderid={$out_trade_no}");
			//echo "验证成功<br />";
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else
		{
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			//echo "验证失败";
			$type = ALIPAY_FAIL;
		}

		$this->_view->assign('courseInfo', $courseInfo);
		$this->_view->assign('out_trade_no', $out_trade_no);
		$this->_view->assign('type', $type);
		$this->getView()->display('alipayapi/success.php');
		//$this->redirect('success');
		return false;
	}

	/**
	 * 支付成功提交用户信息
	 */
	public function paySuccessAction()
	{
		$phone = $this->getRequest()->getPost("phone");
		$username = $this->getRequest()->getPost("username");
		$orderid = $this->getRequest()->getPost("orderid");
		$courseid = $this->getRequest()->getPost("courseid");

		$this->models['orderModel']->updatePayOrder($username, $phone, $orderid);
		$this->redirect(SYSTEMURL . '/classes/index/classid/' . $courseid);
	}

}