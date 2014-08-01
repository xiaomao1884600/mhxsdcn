<?php $this->display('layouts/header.php'); ?>

<div class="main teacher">
    
    <?php if($data): ?>
        <?php foreach ($data as $val) : ?>
            <dl>
                <dt><img src="http://edu.hxsd.com<?php echo $val['photo'] ?>" /></dt>
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

<script src="<?php echo SYSTEMURL; ?>/js/namal.js"></script>
<?php $this->display('layouts/footer.php'); ?>
