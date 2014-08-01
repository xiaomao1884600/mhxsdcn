		</div>
	</div>
</div>
<div class="navclear2"></div>
<div class="panel panel-default">
	<div class="panel-footer"><h3 class="panel-title">快来关注火星看点啦</h3></div>
</div>
<ul class="pull-left">
	<?php foreach($blogposts as $key => $post):?>
	<li class="list-group-item"><a href="<?php echo SYSTEMURL;?>/blog/index/id<?php echo $post['ID'];?>" target="_blank"><?php echo $post['post_title']?></a>&nbsp;&nbsp;&nbsp;<span class="badge"><?php echo ($key + 1);?></span></li>
	<?php endforeach;?>
</ul>
</body>
</html>