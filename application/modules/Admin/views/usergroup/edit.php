<?php $this->display('layouts/header.php'); ?>
<form name="usergroupedit" method="post" action="<?php echo ADMINURL;?>/usergroup/doedit">
	<input type="hidden" name="usergroupid" value="<?php echo $userGroupInfo['usergroupid'];?>" />
		<input type="hidden" name="page" value="<?php echo $page;?>" />
	<div class="table-box">
		<table class="table table-striped table-bordered clearfix">
					<?php if ($userGroupInfo):?>
						<tr>
							<td width="15%">原用户组名</td>
							<td><div class="col-xs-3"><?php echo $userGroupInfo['groupname']?></div></td>
						</tr>
						
						<tr>
							<td width="15%">新用户组名</td>
							<td><div class="col-xs-3"><input type="text" name="groupname" class="form-control" maxlength="16" value=""/></div></td>
						</tr>
					<?php else:?>
						<tr>
						<td width="15%" rowspan="2">用户组名</td>
						<td><div class="col-xs-3">添加新用户组</div></td>
						</tr>
						
						<tr>
							<td><div class="col-xs-3"><input type="text" name="groupname" class="form-control" maxlength="16" value=""/></div></td>
						</tr>
						<input type="hidden" name="action" value="add"/>
					<?php endif;?>
					<tr>
						<td colspan="2"><input type="submit" class="btn btn-primary" value="确定" /></td>
					</tr>
		</table>
	</div>
</form>
<?php $this->display('layouts/footer.php'); ?>