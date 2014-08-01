<?php $this->display('layouts/header.php'); ?>
	<div class="table-box">
		<div class="pull-right"><button type="button" class="btn btn-default"><a href="<?php echo ADMINURL;?>/content/edit/action/add" class="navbar-link">添加班级</a></button></div>
		<div class="navclear1"></div>
	<form name="classmobile" method="post" action="<?php echo ADMINURL;?>/content/rank" enctype="multipart/form-data">
		<table class="table table-striped table-bordered clearfix">
			<thead>
				<tr class="table-tr">
					<th width="8%">ID</th>
					<th>专业班</th>
					<th>系</th>	
					<th width="20%">班级封面</th>
					<th width="10%">定价</th>
					<th width="7%">排序</th>			
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($classesmobile AS $key => $classes) :?>
					<tr>
						<td><?php echo $classes['classes_mobileid'];?></td>
						<td><?php echo $classes['name'];?></td>
						<?php foreach($faculties as $key => $faculty):?>
							<?php if ($classes['facultieid'] == $faculty['id']):?>
								<td><?php echo $faculty['name'];?></td>
							<?php endif;?>
						<?php endforeach;?>
						<td>
							<div class="col-xs-2">
									<a href="<?php echo Local\Util\Page::getImageCacheURL($classes['imgpath'], '', 'jpg');?>" target="_blank"><img src="<?php echo Local\Util\Page::getImageCacheURL($classes['imgpath'], '', 'jpg');?>" alt="<?php echo $classes['name'];?>" title="<?php echo $classes['name']?>" style="width:120px;height:70px;"/></a>
							</div>
						</td>
						<td>
							<div class="navbar-btn">
								<?php echo $classes['price'];?> 元
							</div>
						</td>
						<td>
							<div class="navbar-btn">
								<input  class="form-control text-center" type="text" name="rank[<?php echo $classes['classes_mobileid'];?>]" value="<?php echo $classes['rank'];?>" maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,''); if(this.value < 0){this.value='';}"/>
							</div>	
						</td>
						<td>
							<a href="<?php echo ADMINURL;?>/content/edit/id/<?php echo $classes['classes_mobileid']?>/page/<?php echo $page;?>" class="btn btn-success">编辑</a>
							<a href="<?php echo ADMINURL;?>/content/disabled/id/<?php echo $classes['classes_mobileid']?>/page/<?php echo $page;?>" class="btn btn-success"><?php if ($classes['isclose']):?>激活<?php else:?>禁用<?php endif;?></a>
						</td>
					</tr>
				<?php endforeach;?>
					<tr>
						<td colspan="6"><input type="submit" class="btn btn-primary" value="排序" /></td>
					</tr>
			</tbody>
		</table>
	</div>
	<div class="pagenav">
		<?php echo $pageNav;?>
	</div>
<?php $this->display('layouts/footer.php'); ?>