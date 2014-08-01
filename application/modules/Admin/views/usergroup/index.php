<?php $this->display('layouts/header.php'); ?>
	 <div class="table-box">
	 	<div class="pull-right"><button type="button" class="btn btn-default"><a href="<?php echo ADMINURL;?>/usergroup/edit/action/add" class="navbar-link">添加用户组</a></button></div>
		<div class="navclear1"></div>
		<table class="table table-striped table-bordered clearfix">
			<thead>
				<tr class="table-tr">
					<th width="8%">ID</th>
					<th width="25%">用户组</th>
					<th width="15%">操作人</th>
					<th width="20%">操作时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($userGroups AS $key => $userGroup) :?>
					<tr>
						<td><?php echo $userGroup['usergroupid']?></td>
						<td><?php echo $userGroup['groupname'];?></td>
						<td><?php echo $userGroup['userid'];?></td>
						<td><?php echo Local\Util\Time:: formatDate($userGroup['dateline']);?></td>
						<td>
							<a href="<?php echo ADMINURL;?>/usergroup/edit/usergroupid/<?php echo $userGroup['usergroupid']?>/page/<?php echo $page;?>" class="btn btn-success">编辑</a>
							<a href="<?php echo ADMINURL;?>/usergroup/disabled/usergroupid/<?php echo $userGroup['usergroupid']?>/page/<?php echo $page;?>" class="btn btn-success"><?php if ($userGroup['disabled']):?>激活<?php else:?>禁用<?php endif;?></a>
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