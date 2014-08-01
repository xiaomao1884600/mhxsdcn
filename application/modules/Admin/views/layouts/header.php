<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<!-- 该选项通知window internet explorer 以最高模式显示内容，实际破坏了'锁定'模式 
		可以使用 <meta http-equive="X-UA-Compatible" content="IE=7"/>
	-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" href="<?php echo ROOT;?>/css/bootstrap.min.css" type="text/css" media="screen,print"/>
	<link rel="stylesheet" href="<?php echo ROOT;?>/css/admin.css" type="text/css" media="screen,print"/>
<!--	<link href="<?php echo SYSTEMURL; ?>/css/global.css" type="text/css" rel="stylesheet" />-->
	<script type="text/javascript" src="<?php echo SYSTEMURL; ?>/js/jquery-1.7.1.js"></script>
	<script src="<?php echo ROOT;?>/js/bootstrap.min.js"></script>
<!--	<script type="text/javascript" src="<?php echo SYSTEMURL; ?>/js/doyoo.js"></script>-->
<!--	<script type="text/javascript" charset="utf-8" src="http://gate.looyu.com/11464/115695.js"></script>-->
<!--		-->
	<script>
		<!--
		//alert('欢迎来访');
		//-->
		</script>
</head>
<body>
	<?php if(Yaf\Registry::get('setting')['closesite']) :?>
	<div class="alert alert-warning text-center"> <strong>警告<a href="http://tphpcms.sinaapp.com" target="_blank">站点处于关闭中</a></strong></div>
	<?php endif;?>
	<div class="navbar navbar-default" role="navigation">
		<div class="navbar-collapse collapse">
			<a href="<?php echo SYSTEMURL;?>" class="navbar-brand"">YAF项目</a>
			<ul class="nav navbar-nav navbar-right">
				<li><p class="navbar-text navbar-right">您好，<a href="#" class="navbar-link"><?php echo $adminInfo['email'];?></a></p></li>
				<li><a href="<?php echo ROOT;?>" target="_blank">站点首页</a></li>
				<li><a href="<?php echo ADMINURL;?>/logout/index/userid/<?php echo $adminInfo['userid'];?>">退出</a></li>
			</ul>
		</div>
	</div>
	
<div class="adminmain">
	<div class="col-xs-6 col-sm-3 leftbox" role="navigation">
		<ul class="list-group">
		<?php foreach ($navbar as $key => $value) :?>
			<li><a href="<?php echo ROOT; ?>/admin/<?php echo $key?>/index" class="list-group-item <?php if ($key == CONTROLLER_NAME || ('index' == CONTROLLER_NAME && 'setting' == $key)) : ?> active <?php endif; ?>"><?php echo $value;?></a></li>
		<?php endforeach;?>
	</div>
	
	<div class="rightbox">
		<div class="panel panel-default">
			<ol class="breadcrumb"><?php echo $breadCrumb;?></ol>