<script src="http://edu.hxsd.com/templets/edunew/js/jQuery.js"></script>
<div class="footer row-fluid">
    <div class="apply clear" id="apply">
        <form action="" name="apply" method="post" id="apply_form">
            <h3><span>申请试听</span><input type="button" onclick="checkform()" class="sub"  value="提交申请" /></h3>
            <p><span>姓名：</span><input type="text" name="name" id="_Name" value="" /> <font id="erron_2" color="red"></font></p>
            <p><span>性别：</span><input type="radio" name="gender" checked value="2" class="r"/>女<input type="radio" name="gender" value="1" class="r" />男</p>
            <p><span>Q Q：</span><input type="input" name="qq" onchange="checkappearedfooter()" value="" id="_QQ" /> <font id="erron_3" color="red"></font></p>
            <p><span>电话：</span><input type="tel" name="mobile" onchange="checkappearedfooter()" value="" id="_Tel" /> <font id="erron_5" color="red"></font></p>
            <p id="yzm" style="display:none;"><span>验证：</span><input type="text" id="validate"/><img id="vdimgck" src="<?php echo SYSTEMURL; ?>/listenonline/include?" alt="看不清？点击更换" style="cursor:pointer" onclick="this.src = this.src + '?'" /> <font id="erron_9" color="red"></font></p>
            <p><span>试听地点：</span><input type="radio" name="campus" value="1" checked class="r"/>北京<input type="radio" name="campus" value="2" class="r" />上海</p>
            <p class="sel">
				<span>试听方向：</span>
				<select name="course" class="course" id="course">
					<option>选择方向/专业</option>
                    <optgroup label="影视动画方向">
                        <option value="45"> 角色动画与故事创作大师班 </option>
                        <option value="43"> 影视概念设计专业班 </option>
                        <option value="32"> 影视特效动画专业班 </option>
                        <option value="33"> 影视次世代高精模型专业班</option>
                        <option value="3"> 影视特效与合成专业班 </option>
                        <option value="4"> 影视后期合成专业班 </option>
                        <option value="5"> 影视包装与广告专业班 </option>
                        <option value="6"> 影视剪辑专业班 </option>
                        <option value="7"> C4D影视包装班 </option>
                        <option value="8">  影视合成全科班 </option>
                        <option value="9">  Maya 基础班（暑期班）</option>
                        <option value="10"> Maya 专业班（暑期班）</option>
                    </optgroup>

                    <optgroup label="游戏设计方向">
                        <option value="30">MDA游戏设计学历班 </option>
                        <option value="11">游戏原画美术专业班 </option>
                        <option value="12">游戏原画美术精英班 </option>
                        <option value="41">游戏UI设计专业班 </option>
                        <option value="13">网游次世代高精模型专业班</option>
                        <option value="14">游戏特效专业班 </option>
                        <option value="15">游戏动画专业班 </option>
                        <option value="42">手机游戏设计专业班 </option>
                        <option value="16">游戏设计策划专业班</option>
                    </optgroup>

                    <optgroup label="建筑设计方向">
                        <option value="46"> MDA室内设计学历班 </option>
                        <option value="38">室内设计专业班</option>
                        <option value="17">建筑表现与动画专业班</option>
                        <option value="18">建筑表现专业班 </option>
                        <option value="34">展览展示设计专业班</option>
                        <option value="35">公共空间装饰设计班</option>
                        <option value="21">3ds Max & VRay 室内表现全科班 </option>
                        <option value="36">CAD施工图设计班 </option>
                        <option value="37">室内设计手绘特训班</option>
                        <option value="23">Revit施工图设计班 </option>
                        <option value="22">3ds Max 基础班</option>
                    </optgroup>

                    <optgroup label="互动媒体方向">
                        <option value="24">平面广告高级设计师班</option>
                        <option value="27">UI界面高级设计师班</option>
                        <option value="26">商业插画高级设计师班 </option>
                    </optgroup>
				</select>
				<font id="erron_8" color="red"></font>
			</p>
        </form>
    </div>
    <ul class="ft">
        <li class="span4" id="applybtn"><a href="javascript:;"  ><img src="<?php echo SYSTEMURL; ?>/images/navicon1.png" /></a></li>
        <li class="span4">
			<a href="tel:4008101418" ><img src="<?php echo SYSTEMURL; ?>/images/navicon2.png" /></a>
		</li>
        <li class="span4"><a href="<?php echo SYSTEMURL; ?>/aboutteacher/" ><img src="<?php echo SYSTEMURL; ?>/images/navicon3.png" /></a></li>
    </ul>
</div>

<script src="<?php echo SYSTEMURL; ?>/js/namal.js"></script>

<script>
				//显示验证
				function checkappearedfooter()
				{
					//var mobile = $('#_Tel').val();
					//var qq = $('#_QQ').val();

					//alert(value);
					$.ajax({url: "/listenonline/checkappeared",
						type: "post",
						dataType: "html",
						//data: "qq=" + qq + "&mobile=" + mobile,
						success: function(msg)
						{
							if (msg == 1)
							{
								$("#yzm").css('display', '');
							}
							else
							{
								$("#yzm").css('display', 'none');
							}
						}
					});
				}

				/*
				 *生成验证码
				 *
				 */
				function reloadcode()
				{
					var verify = $("#vdimgck").attr("src", "/include/vdimgck.php?'+Math.random()*100");
				}

				var fullName = document.getElementById("_Name");
				var nameErron = document.getElementById("erron_2");
				fullName.onblur = function() {
					var str = "";
					nameErron.innerHTML = str;
				}

				var qq = document.getElementById("_QQ");
				var qqErron = document.getElementById("erron_3");
				qq.onblur = function() {
					var patrn = /^\d{5,11}$/;
					var qqInfo = $('#_QQ').val();
					var str = "";
					if (qqInfo)
					{
						if (!patrn.exec(qqInfo))
						{
							str = "请正确的QQ号！";
						}
					}

					qqErron.innerHTML = str;
				}

				var mobile = document.getElementById("_Tel");
				var mobileErron = document.getElementById("erron_5");
				mobile.onblur = function() {
					var patrn = /^1[358][0-9]{9}$/;
					var mobileInfo = $('#_Tel').val();
					var str = "";
					if (mobileInfo)
					{
						if (!patrn.exec(mobileInfo))
						{
							str = "请正确输入手机号";
						}
					}
					else
					{
						str = "请输入手机号";
					}
					mobileErron.innerHTML = str;
				}



				var validate = document.getElementById("validate");
				var validateErron = document.getElementById("erron_9");
				validate.onblur = function() {
					var str = "";
					validateErron.innerHTML = str;
				}




				//检查表单
				function checkform()
				{
					var name = $('#_Name').val();
					var gender = $('input[name="gender"]:checked').val();
					var qq = $('#_QQ').val();
					var mobile = $('#_Tel').val();
					var campus = $('input[name="campus"]:checked').val();
					var course = $('.course option:selected').val();
					var validate = $("#validate").val();

					$.ajax({
						url: "/listenonline/runauditionsubmit",
						type: "post",
						data: 'mobile=' + mobile + '&qq=' + qq + '&name=' + name + '&campus=' + campus + '&course=' + course + '&gender=' + gender + '&validate=' + validate,
						success: function(msg)
						{

							var obj = eval('(' + msg + ')');

							if (obj.status == 1)
							{
								//$(".footpop").show();
								//    alert('添加成功');

								test();
							}
							else
							{
								//checkmobile('mobile');
								//alert(obj.msg);
								//$("#" + obj.id).focus();
								var span = document.getElementById("erron_" + obj.erron);
								var str = obj.msg;
								span.innerHTML = str;
							}
						}
					});
				}

				function test()
				{
					var arr = ["<font size='6px'>信息提交成功</font><br /><font size='4.5px'>请耐心等待客服人员联系您！</font>", "提交失败"];

					var oApplyBox = document.getElementById("apply");
					var oK = document.createElement("div");
					move(oApplyBox, "top", -100);
					oApplyBox.insertBefore(oK, oApplyBox.children[0]);
					oK.innerHTML = arr[0];
					oK.style.cssText = "height:100px;text-align:center;color:#fff;font-size:1em;line-height:50px;";
					setTimeout(function() {
						move(oApplyBox, "top", 0);
					}, 2000);

					setTimeout(function() {
						oApplyBox.removeChild(oK);
						oApplyBox.style.display = "none";
                        location.reload();
					}, 3000);

					//表单重置

					/*$("#apply_form")[0].reset();
                    $(".footcont span,.foot_layter").click(function() {
                        $(".footpop").hide();
                        $('#mobile').val("输入手机");
                        $('#validate').val("");
                        $('#yzm').hide();
                    });*/

				}

</script>