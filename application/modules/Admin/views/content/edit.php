<?php $this->display('layouts/header.php'); ?>
<form name="classmobile" method="post" action="<?php echo ADMINURL;?>/content/doedit" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $classInfo['classes_mobileid'];?>" />
		<input type="hidden" name="page" value="<?php echo $page;?>" />
	<div class="table-box">
		<table class="table table-striped table-bordered clearfix">
					<?php if ($classInfo):?>
						<tr>
							<td width="15%">原班级</td>
							<td><div class="col-xs-3"><?php echo $classInfo['name']?></div></td>
						</tr>
						
						<tr>
							<td width="15%">新班级名称</td>
							<td><div class="col-xs-3"><input type="text" name="name" class="form-control" maxlength="16" value="" /></div></td>
						</tr>
					<?php else:?>
						<tr>
						<td width="15%" rowspan="2">班级名称</td>
						<td><div class="col-xs-3">添加新班级</div></td>
						</tr>
						
						<tr>
							<td><div class="col-xs-3"><input type="text" name="name" class="form-control" maxlength="16" value="" required/></div></td>
						</tr>
						<input type="hidden" name="action" value="add"/>
					<?php endif;?>
					<tr>
						<td width="15%">
							所属系
						</td>
						<td>
							<div class="col-xs-3">
								<select name="facultieid" class="form-control">
								<?php foreach($faculties as $key => $faculty):?>
									
										<option value="<?php echo $faculty['id']?>" <?php if ($classInfo['facultieid'] == $faculty['id']):?> selected <?php endif;?>><?php echo $faculty['name'];?></option>
								<?php endforeach;?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td width="15%">封面图</td>
						<td>
							<input type="file" name="img" value=""/>
							<?php if ($classInfo['imgpath']):?>
								<!--  放图片-->
								<br />
								<div class="col-xs-2">
									<a href="<?php echo Local\Util\Page::getImageCacheURL($classInfo['imgpath'], '', 'jpg');?>" target="_blank"><img src="<?php echo Local\Util\Page::getImageCacheURL($classInfo['imgpath'], '', 'jpg');?>" alt="<?php echo $classInfo['name'];?>" title="<?php echo $classInfo['name']?>" style="width:120px;height:90px;"/></a>
								</div>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td width="15%">定价</td>
						<td>
							<div class="col-xs-2">
								<input class="form-control" type="text" name="price" value="<?php echo $classInfo['price'];?>" onkeyup="this.value=this.value.replace(/\D[^.]\D/g, ''); if(this.value < 0){this.value='';}" required />
							</div>
						</td>
					</tr>
					<tr>
						<td>班级简介</td>
						<td>
							<div class="col-xs-6">
								<textarea name="description" class="form-control"><?php echo $classInfo['description']; ?></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn btn-primary" value="确定" /></td>
					</tr>
		</table>
	</div>
</form>
<?php $this->display('layouts/footer.php'); ?>