<!doctype html >
<html>
	<head>
		<title>火星时代实训基地 | 中国动漫游戏高端教育品牌</title>
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link href="<?php echo SYSTEMURL; ?>/css/global.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo SYSTEMURL; ?>/css/layout.css" type="text/css" rel="stylesheet" />
		<script src="<?php echo SYSTEMURL; ?>/js/jquery-1.7.1.js"></script>

		<!--[if lt IE 9]>
			<script src="js/css3-mediaqueries.js"></script>
		<![endif]-->
	</head>

	<body >

		<!--header-->
		<div class="header">
			<a href="<?php echo SYSTEMURL; ?>/" class="logo"><img src="<?php echo SYSTEMURL; ?>/images/logo.jpg"></a>
			<a href="javascript:;" class="pc"></a>
		</div>
		<div class="return">
			<a href="<?php echo SYSTEMURL; ?>/"><img src="<?php echo SYSTEMURL; ?>/images/return.jpg" /></a>
		</div>
		<!--main-->
		<?php if ($postInfo) : ?>
			<div class="main">
				<div class="article_top">
					<h2 class="tt"><?php echo $postInfo['post_title']; ?></h2>
					<p class="author">发布时间：<?php echo $postInfo['post_date'][0]; ?>年<?php echo $postInfo['post_date'][1]; ?>月<?php echo $postInfo['post_date'][2]; ?>日 | 发表者：火星时代实训基地</p>
				</div>
				<div class="article article_cen" id="contents">
					<?php echo $postInfo['post_content']; ?>
				</div>
				<div class="article_fot">
					<a onclick="	creatshare()">分享</a>
				</div>

				<div class="article_np">
					<p><?php echo $abc = $backInfo ? '上一篇：' : ''; ?><a href="<?php echo SYSTEMURL; ?>/<?php echo CONTROLLER_NAME; ?>/index/id/<?php echo $backInfo['id']; ?>"><?php echo $backInfo['post_title']; ?></a></p>
					<p><?php echo $abc = $nextInfo ? '下一篇：' : ''; ?><a href="<?php echo SYSTEMURL; ?>/<?php echo CONTROLLER_NAME; ?>/index/id/<?php echo $nextInfo['id']; ?>"><?php echo $nextInfo['post_title']; ?></a></p>
				</div>
			</div>

		<?php else : ?>
			<h2 class="error_blog">对不起!没有找到这篇日志!</h2>
		<?php endif; ?>
		<!--main end-->


		<?php $this->display('layouts/footer.php'); ?>
		<script>
						$(document).ready(function() {
							var num = $("#contents  p").length - 1;
							$("#contents  p").eq(num).remove();
							$("#contents  p").eq(num - 1).remove();
							$("#contents  p").eq(num - 2).remove();
							$("#contents  p").eq(num - 3).remove();
							/*$("#contents").children().removeAttr("style width height");*/
						});

						var oContents = document.getElementById("contents");
						var aEl = oContents.getElementsByTagName("*");
						for (var i = 0; i < aEl.length; i++)
						{
							if (aEl[i].style)
							{
								aEl[i].style.color = "#333";
							}
							if (aEl[i].tagName == "IMG")
							{
								aEl[i].parentNode.className = "autoimg";
							}
						}

						$("#contents p span").each(function(i) {
							$(this).css({color: '#f90'})
						});
						$("#contents p span strong").each(function(i) {
							$(this).css({color: '#f90'})
						});

						$("img").each(function(i){
							$(this).removeAttr("height");
							$(this).removeAttr("width");

						});

		</script>
	</body>
</html>