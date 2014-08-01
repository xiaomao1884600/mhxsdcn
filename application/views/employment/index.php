<?php $this->display('layouts/header.php'); ?>


<div class="return">
    <a href="<?php echo SYSTEMURL;?>"><img src="<?php echo SYSTEMURL;?>/images/return.jpg" /></a>
</div>

<!--main-->
<div class="main">
    <p class="gojob">火星时代实训基地经过20年的发展，形成了完善的CG人才培养体系，建立了动漫培训、就业服务一体化机制专门成立就业指导中心负责为学员终身推荐就业。从学员步入火星时代实训基地开始，就业指导中心会对学生进行职业规划系统培训同时会邀请业界知名企业来火星讲座，帮助学生详细了解行业的发展动态、企业岗位需求。树立正确的求职心态、择业观念，培养职业素养、面试技巧以及作为职场新人的处事能力，为今后就业奠定良好基础。我们的宗旨是帮助每一位渴望步入CG行业的学员，成功入职。</p>
    <?php if(!$data) : ?>  
            <?php echo '没有数据。'?>
    <?php else : ?>
        <ul class="student">
            <?php foreach($data as $key=>$value) : ?>
            <li><a href="<?php echo $value['link']?>" class="phone"><img src="<?php echo EDUURL.$value['photo']?>" /></a><a href="<?php echo $value['link']?>" class="t"><?php echo $value['name']?></a><a href="<?php echo $value['link']?>"  class="t">就职 <?php echo $value['employment']?></a></li>
                <?php if($key != max(array_keys($data)) && 0==(($key+1)%4)) : ?>
                    <?php echo '</ul>'?>
                    <?php echo '<ul class="student">'?>
                <?php endif;?>
            <?php endforeach ;?>
		</ul>
    <?php endif; ?>
    
    <?php echo $pageNav; ?>
    
</div>

<?php $this->display('layouts/footer.php'); ?>