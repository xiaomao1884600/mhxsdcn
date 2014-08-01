<?php $this->display('layouts/header.php'); ?>

<div class="return">
	<a href="<?php echo SYSTEMURL;?>"><img src="<?php echo SYSTEMURL;?>/images/return.jpg" /></a>
</div>
  <!--main-->
  <div class="main teacher">
		
	<?php if($data): ?>
        <?php foreach ($data as $val) : ?>
            <dl>
                <dt><img src="<?php echo $val['photo'] ?>" /></dt>
                <dd>
                    <h3><?php echo $val['name'] ?></h3>
                    <p><?php echo $val['info'] ?></p>
                </dd>
            </dl>
        <?php endforeach; ?>
    <?php else: ?>
        <dl>
            <dt><?php echo '没有数据'?></dt>
        </dl>
    <?php endif; ?>

    <?php echo $pageNav; ?>	 
  </div>

<?php $this->display('layouts/footer.php'); ?>