<?php $this->display('layouts/header.php'); ?>
 <!--main-->
 <?php if(!empty($courseinfo)):?>
  <div class="main">
	<h2 class="tit_red"><?php echo $courseinfo['name']; ?></h2>
	<div class="article curm_article">

		<p><?php echo $courseinfo['description'] ?></p>
		<hr />
		<h5>课程信息</h5>
		<ul>
			<li><p><b>课&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;时：</b><?php echo $courseinfo['hour']?></p></li>
			<li>
					<p class="ke"><b>开课时间：</b>

					<?php
					if ($courseinfo['isupdate'] == 1)
					{
						echo '<li>课程升级中，详情请咨询400-810-1418</li>';
					}
					else
					{
						for ($i = 0; $i < 5; $i++)
						{
							if ($courseinfo['begintime']['date'][$i] > 0 && $courseinfo['begintime']['state'][$i] > 0)
							{
								$btime = date('Y年m月d日', strtotime($courseinfo['begintime']['date'][$i]));
								$state = $state_array[$courseinfo['begintime']['state'][$i]];
								$extrainfo = empty($courseinfo['extrainfo'][$i]) ? '' : "({$courseinfo['extrainfo'][$i]})";
								echo $btime . $extrainfo . (($courseinfo['newcourses'][$i]) ? '（新课程）' : '') . '<span>' . $state . '</span><br/>';
							}
						}
					}
					?>
			</li>
			<li><p><b>入学条件：</b></p><p><?php echo $courseinfo['condition']; ?></p></li>
			<li><p><b>专业认证：</b></p><p><?php echo $courseinfo['certification']; ?></p></li>

			<li><p><b>就业岗位：</b></p><p><?php echo $courseinfo['status']; ?></p></li>
		</ul>
		<hr />
		<?php if(!empty($courseinfo['classcourses'])):?>
		<h5>课程说明</h5>
		<?php foreach ($courseinfo['classcourses'] as $value): ?>
			<dl class="clear">
				<dt><a href=""><?php echo $value['name'] ?></a></dt>
				<dd>
					<p><?php echo $value['description'] ?></p>
				</dd>
			</dl>
		<?php endforeach; ?>
		<hr />
		<?php endif;?>
		<a href="<?php echo SYSTEMURL.'/'.CONTROLLER_NAME ;?>/payonline/classid/<?php echo $courseinfo['id']; ?>/" class="btn_bm">我要报名</a>
	</div>
  </div>
 <?php else : ?>
	<h2 class="error_blog">对不起!没有找到这门课程!</h2>
<?php endif; ?>
  <!--main end-->
<?php $this->display('layouts/footer.php');?>
 </body>
</html>
