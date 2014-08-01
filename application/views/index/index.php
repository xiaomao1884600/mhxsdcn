 <?php $this->display('layouts/header.php')?>
	<!--container star-->
	<div class="container">
		<div id="slides">
            <?php if(!empty($banners)):?>
                <?php foreach ($banners as $banner):?>
                    <?php $url = unserialize($banner['bannerinfo']);?>
                    <img src="<?php echo Local\Util\Page::getImageCacheURL($url['imgpath'], '', 'jpg');?>" alt="" onclick='openimg("<?php echo Local\Util\Page::getImageCacheURL($url['imgpath'], '', 'jpg');?>")'>
                <?php endforeach;?>
			<?php endif;?>
		  <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
		  <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
		</div>
	  </div>
	<!--container end-->
  <!--main-->
  <div class="main">
	<!--Category star-->
	<?php if (!empty($faculties)):?>
		<?php foreach($faculties as $faculties): ?>
		<h2 class="category_tit"><?php echo $faculties['name'];?></h2>
		<ul class="category_ch">
			<?php if(!empty($faculties['class'])):?>
				<?php foreach($faculties['class'] as $class):?>
					<li>
						<a href="<?php echo SYSTEMURL;?>/classes/index/classid/<?php echo $class['classid'];?>" class="icon" target="_blank"><img src="<?php echo Local\Util\Page::getImageCacheURL($class['imgpath'], '', 'jpg')?>" /></a><a href="<?php echo SYSTEMURL;?>/classes/index/classid/<?php echo $class['classid'];?>" class="t" target="_blank"><?php echo $class['name']?></a>
						<span>￥: <?php echo $class['price'];?> 元</span>
						<br />
						<a href="<?php ROOT?>/classes/payonline/classid/<?php echo $class['classes_mobileid']?>" target="_blank">购买</a>
					</li>
				<?php endforeach;?>
			<?php endif?>
		</ul>
		<?php endforeach;?>
	<?php endif?>
	<!--Category end-->
	<h2 class="category_tit">火星看点</h2>
	<ul class="aspect_list">
		<ul class="aspect_list">
		<?php foreach($blogposts as $post):?>
		<li><a href="<?php echo SYSTEMURL;?>/blog/index/id/<?php echo $post['ID'];?>" target="_blank"><?php echo $post['post_title'];?></a></li>
		<?php endforeach;?>

	</ul>
	</ul>
  </div>
  <!--main end-->

  <?php $this->display('layouts/footer.php')?>

  <script src="<?php echo SYSTEMURL;?>/js/slides.js"></script>
  <script src="<?php echo SYSTEMURL;?>/js/jquery.slides.min.js"></script>
  <script>
    $(function() {
      $('#slides').slidesjs({
        width: 600,
        height: 254,
        navigation: false,
        play: {
            active: false,
            auto: true,
            interval: 4000,
            swap: true
        }
      });
    });

	/***
	 *
	 * 打开图片轮播链接地址
	 */
	function openimg(url)
	{
//		var tmp=window.open('about:blank','','fullscreen=1')
//		tmp.moveTo(0,0);
//		tmp.resizeTo(screen.width+20,screen.height);
//		tmp.focus();
//		tmp.location=url;
		window.open(url)
	}
  </script>
 </body>
</html>
