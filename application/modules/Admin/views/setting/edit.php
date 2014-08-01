<?php $this->display('layouts/header.php'); ?>
<form name="useredit" method="post" action="<?php echo ADMINURL;?>/user/doedit">
	<input type="hidden" name="userid" value="<?php echo $userInfo['userid'];?>" />
		<input type="hidden" name="page" value="<?php echo $page;?>" />
	<div class="table-box">
		<table class="table table-striped table-bordered clearfix">
				<?php if (empty($userInfo)):?>
					<input type="hidden" name="action" value="add"/>
					<tr>
						<td width="15%">姓名 <span class="required">*</span></td>
						<td><div class="col-xs-3"><?php if ($userInfo):?><?php echo $userInfo['email'];?><?php else:?><input type="text" name="username" class="form-control" value="" maxlength="16" /><?php endif;?></div></td>
					</tr>
					<tr>
						<td width="15%">年龄</td>
						<td><div class="col-xs-2"><?php if ($userInfo):?><?php echo $userInfo['email'];?><?php else:?><input type="text" name="age" class="form-control" value="" maxlength="3" onkeyup="this.value=this.value.replace(/\D/g,''); if(this.value < 0){this.value=''}else if (this.value > 200){this.value=''}"/><?php endif;?></div></td>
					</tr>
				<?php endif;?>
					<tr>
						<td width="15%">邮箱 <?php if (empty($userInfo)):?> <span class="required">*</span><?php endif;?></td>
						<td><div class="col-xs-3"><?php if ($userInfo):?><?php echo $userInfo['email'];?><?php else:?><input type="text" name="email" class="form-control" value="" maxlength="30" /><?php endif;?></div></td>
					</tr>
					<tr>
						<td width="15%">用户组</td>
						<td>
							<div class="col-xs-3">
								<select name="usergroupid" class="form-control"/>
									<?php foreach ($userGroups as $k => $userGroup ):?>
										<option value="<?php echo $userGroup['usergroupid']?>" <?php if ($userInfo['usergroupid'] == $userGroup['usergroupid']):?>selected="selected" <?php endif;?>><?php echo $userGroup['groupname']?></option>
									<?php endforeach;?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td width="15%">新密码 <?php if (empty($userInfo)):?> <span class="required">*</span><?php endif;?></td>
						<td><div class="col-xs-3"><input type="password" name="password" class="form-control" maxlength="16" value=""/></div></td>
					</tr>
					<tr>
						<td width="15%">确认密码<?php if (empty($userInfo)):?> <span class="required">*</span><?php endif;?></td>
						<td><div class="col-xs-3"><input type="password" name="repassword" class="form-control" maxlength="16" value=""/></div></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn btn-primary" value="确定" /></td>
					</tr>
		</table>
	</div>
</form>
<?php $this->display('layouts/footer.php'); ?>