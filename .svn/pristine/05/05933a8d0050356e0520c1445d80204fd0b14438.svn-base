
<?php
/* *
 * 功能：即时到账交易接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(dirname(__FILE__)."/../include/tree.class.php");
require_once(dirname(__FILE__)."/alipay.config.php");
require_once(dirname(__FILE__)."/lib/alipay_submit.class.php");

// 订单ID

$orderid = $_GET['orderid'];

// 订单信息

$orderInfo = $dsql->GetOne("select * from #@__order where orderid={$orderid}");



// 获取课程信息

$ordercourse = $dsql->GetOne("select * from #@__ordercourse where orderid={$orderid}");

$courseid = $ordercourse['courseid'];

$courseInfoes = $dsql->GetOne("select * from #@__classes where id={$courseid}");


/**************************请求参数**************************/

//支付类型
$payment_type = "1";
//必填，不能修改
//服务器异步通知页面路径
$notify_url = $cfg_clihost."/alipay/notify_url.php";
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
$return_url = $cfg_clihost."/alipay/return_url.php";
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

//卖家支付宝帐户
$seller_email = "edu@hxsd.cn";
//必填

//商户订单号
$out_trade_no = "$orderid";
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
$show_url = $cfg_clihost . "/class-" . $courseid . ".html";
//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

//防钓鱼时间戳
$anti_phishing_key = "";
//若要使用请调用类文件submit中的query_timestamp函数

//客户端的IP地址
$exter_invoke_ip = $_SERVER['REMOTE_ADDR'];
//非局域网的外网IP地址，如：221.0.0.1


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"seller_email"	=> $seller_email,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

// 定义类型为重定向提交
//$type = ALIPAY_REDIRECT_SUBMIT;

//include $cfg_basedir.$cfg_templets_dir."/eduhtml/pay_success.html";

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
echo $html_text;

?>
