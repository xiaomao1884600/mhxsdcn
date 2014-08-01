<?php $this->display('layouts/header.php'); ?>
	<form name="settingedit" method="post" action="<?php echo ADMINURL;?>/setting/edit">
	<div class="table-box">
		<table class="table table-striped table-bordered clearfix">
					<thead>
						<td>变量名称</td>
						<td>参数说明</td>
						<td>参数值</td>
						<td width="7%">排序</td>
					</thead>
					<tbody>
						<?php foreach($settings as $setting):?>
							<tr>
								<td><?php echo $setting['title'];?></td>
								<td><?php echo $setting['description'];?></td>
								<td><?php echo Local\Util\Page::displayFormElement("setting[{$setting['settingid']}][value]", $setting['value'], $setting['type']) ;?></td>
								<td><div class="navbar-btn"><input type="text" name="setting[<?php echo $setting['settingid']?>][sort]" class="form-control text-center" maxlength="3" value="<?php echo $setting['sort'];?>" onkeyup="this.value=this.value.replace(/\D/g, ''); if(this.value < 0){this.value='';}"/></div></td>
							</tr>
						<?php endforeach;?>
					</tbody>
						<tr>
							<td colspan="4"><input type="submit" class="btn btn-primary" value="确定" /></td>
						</tr>
					
		</table>
	</div>
</form>
<?php $this->display('layouts/footer.php'); ?>