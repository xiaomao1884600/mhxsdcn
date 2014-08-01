<?php $this->display('layouts/header.php'); ?>

<div class="main stu_say">

    <?php if($data): ?>
        <?php foreach ($data as $val) : ?>
            <dl>
                <dt><img width="106" height="106" src="http://edu.hxsd.com<?php echo $val['photo'] ?>" /></dt>
                <dd>
                    <h3><?php echo $val['name']; ?></h3>
                    <p><b>班　　级：</b><?php echo $val['classname']; ?></p>
                    <p><b>个人感言：</b><?php echo $val['content']; ?></p>
                </dd>
            </dl>
        <?php endforeach; ?>
    <?php else: ?>
        <dl>
            <dl><?php echo '没有数据'; ?></dl>
        </dl>
    <?php endif; ?>

    <?php echo $pageNav; ?>

</div>

<?php $this->display('layouts/footer.php'); ?>