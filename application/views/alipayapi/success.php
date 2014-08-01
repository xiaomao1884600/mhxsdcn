<?php $this->display('layouts/header.php');?>
<!--main-->
  <div class="main success">
	   <?php if($type == ALIPAY_SUCCESS) : ?>
		<div class="dh"><div class="fl"><img src="<?php echo SYSTEMURL?>/images/ok.jpg" /></div><div class="fr"><h1>报名成功</h1><p>您的订单号为：<?php echo $out_trade_no;?></p></div></div>
	 <?php else: ?>
		<h1>对不起，支付失败！</h1>
	<?php endif;?>
		<div class="qrfs"><b><img src="<?php echo SYSTEMURL?>/images/ask.jpg" /></b><span>以下3种方法都可以确认信息哦！</span></div>

		<ul>
			<li><span>方法1</span>订单号是您的付款凭证，请截屏保存，并联系自己的课程规划老师，通过QQ发送截屏图片确认上课信息。</li>
			<li><span>方法2</span>请拨打 400-810-1418（北京）或 400-621-1416（上海） 提交您的订单号，确认上课信息。</li>
			<li><span>方法3</span>通过您留的留下的联系方式，我们的课程规划老师会联系您，确认上课信息。</li>
		</ul>
		<div class="confirmform">
			<form name="form" action="paysuccess" method='post' >
				<p><span>姓名</span><input type="text" name='username' /></p>
				<p><span>电话</span><input type="text" name='phone'/></p>
				<input type="hidden" name="orderid" value="<?php echo $out_trade_no;?>">
				<input type="hidden" name="courseid" value="<?php echo $courseInfo['id'];?>">
				<input type="submit" id="sub" value="提交信息" />
			</form>
		</div>
  </div>
  <!--main end-->
<?php $this->display('layouts/footer.php');?>
 </body>
</html>
