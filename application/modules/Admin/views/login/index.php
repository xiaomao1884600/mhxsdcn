<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="description" content=""/>
<title><?php echo $title; ?> - Github 优秀项目推荐</title>
<link rel="stylesheet" href="<?php echo ROOT;?>/css/bootstrap.min.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="<?php echo ROOT;?>/css/admin.css" type="text/css" media="screen,print" />
<script src="<?php echo ROOT;?>/js/jquery.min.js"></script>
<script src="<?php echo ROOT;?>/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="adminlogin">
		<form class="form-signin" role="form" method="post" action="<?php echo ADMINURL;?>/login/account">
			<h2 class="form-signin-heading"><?php echo $title; ?></h2>
			<input type="text" name="email" class="form-control" placeholder="邮箱" maxlength="30" required autofocus />
			<input type="password" name="password" maxlength="16" class="form-control" placeholder="密码" required />
			<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
		</form>
	</div>

</body>
</html>