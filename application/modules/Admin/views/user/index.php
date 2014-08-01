<?php $this->display('layouts/header.php'); ?>
	<div class="table-box">
		<div class="pull-right"><button type="button" class="btn btn-default"><a href="<?php echo ADMINURL;?>/user/edit/action/add" class="navbar-link">添加用户</a></button></div>
		<div class="navclear1"></div>
		<table class="table table-striped table-bordered clearfix">
			<thead>
				<tr class="table-tr">
					<th width="8%">ID</th>
					<th>用户名</th>
					<th>邮箱</th>				
					<th width="20%">用户组</th>
					<th width="15%">注册时间</th>
					<th width="15%">最后登录时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users AS $key => $user) :?>
					<tr>
						<td><?php echo $user['userid']?></td>
						<td><?php echo $user['username']?></td>
						<td><?php echo $user['email']?></td>
						<td><?php echo $userGroups[$user['usergroupid']]['groupname']?></td>
						<td><?php echo Local\Util\Time:: formatDate($user['dateline']);?></td>
						<td><?php echo Local\Util\Time:: formatDate($user['lasttime']);?></td>
						<td>
							<a href="<?php echo ADMINURL;?>/user/edit/userid/<?php echo $user['userid']?>/page/<?php echo $page;?>" class="btn btn-success">编辑</a>
							<a href="<?php echo ADMINURL;?>/user/disabled/userid/<?php echo $user['userid']?>/page/<?php echo $page;?>" class="btn btn-success"><?php if ($user['disabled']):?>激活<?php else:?>禁用<?php endif;?></a>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
	
	<div class="pagenav">
		<?php echo $pageNav;?>
	</div>
<?php $this->display('layouts/footer.php'); ?>