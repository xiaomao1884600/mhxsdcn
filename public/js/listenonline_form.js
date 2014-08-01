function apply_form(id){
	var oBox=document.createElement("div");
	oBox.id="ap_bg";
	document.body.appendChild(oBox);
	oBox.style.cssText="position:fixed;background:#000;opacity:0.5;filter:alpha(opacity=50);width:100%;height:"+document.body.scrollHeight+"px;top:0;left:0;z-index:999;";
	var oApplyform=document.createElement("div");
	oApplyform.id="apply_form2";
	oApplyform.className="apply_form";
	oApplyform.innerHTML="<h3>申请助学金<a href='javascript:;'>x</a></h3>"
										+"<form>"
											+"<p><span>姓名：</span><input onfocus='cleanname(this)'id='name' type='text' name='name'/></p>"
											+"<p><span>电话：</span><input onfocus='cleanmobile(this)' id='mobile' type='text' name='mobile' value='' /></p>"
											+"<input type='hidden' id='pcourse' name='course' value='"+id+"'>"
											+"<input class='btn' onclick='submitApply()'type='button' value='提交申请' />"
										+"</form>";
	document.body.appendChild(oApplyform);

	var oA=oApplyform.getElementsByTagName("a")[0];
	oA.onclick=function(){
		document.body.removeChild(oBox);
		document.body.removeChild(oApplyform);
	}
}
var oMobile=document.getElementById("mobile");

function cleanmobile(o)
{
	o.value="";
	o.style.cssText="";
}

function cleanname(o)
{
	o.value="";
	o.style.cssText="";
}

function submitApply()
{
	var name = $('#name').val();
	var mobile = $('#mobile').val();
	var course = $('#pcourse').val();
	$.ajax({
		url: "/topic/uionefour",
		type: "post",
		data: 'mobile=' + mobile + '&name=' + name + '&course=' + course,
		
		success: function(msg)
		{
			var info = eval('(' + msg + ')');
			
			if (info.status == 1)
			{
				errortips();
				document.body.removeChild(document.getElementById("ap_bg"));
				document.body.removeChild(document.getElementById("apply_form2"));
			}
		   else
			{
				if(info.erron == 3)
				{
					var oMobile=document.getElementById("mobile");
					oMobile.style.cssText="border:1px solid #d10b0b;color:red;";
					oMobile.value=info.msg;
				}
				else
				{
					var oName=document.getElementById("name");
					oName.style.cssText="border:1px solid #d10b0b;color:red;";
					oName.value=info.msg;
				}
				
			}
		}
	});
}

function errortips(){
	var oBox=document.createElement("div");
	document.body.appendChild(oBox);
	oBox.style.cssText="position:fixed;background:#000;opacity:0.5;filter:alpha(opacity=50);width:100%;height:"+document.body.scrollHeight+"px;top:0;left:0;z-index:999;";
	var errortip=document.createElement("div");
	errortip.className="errortip";
	errortip.innerHTML="提交成功";
	document.body.appendChild(errortip);
	errortip.onclick=function(){
		document.body.removeChild(errortip);
		document.body.removeChild(oBox);
	};
}