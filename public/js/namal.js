/* 运动 */
function move(obj,attr,target)
{
	clearInterval(obj.timer);	
	var iCur=parseInt(getStyle(obj,attr));	
	var speed=target>iCur?25:-25;	
	obj.timer=setInterval(function(){		 
		 //当剩下的距离  <  速度   就快到了吧
		 if( Math.abs(target-iCur)< Math.abs(speed) )
		 {
			 obj.style[attr]=target+'px';
			 clearInterval(obj.timer);
		 }
		 else
		 {
			 iCur+=speed;
			 obj.style[attr]=iCur+'px'; 
		 };		
	},30);
};

/* 获取样式 */
function getStyle(obj,attr){return obj.currentStyle?obj.currentStyle[attr]:getComputedStyle(obj,false)[attr];}


/* 申请试听 apply */
function apply(){
	var applybtn=document.getElementById("applybtn").getElementsByTagName("a")[0];
	if (applybtn)
	{
		/*点击显示申请试听表单*/
		var oApplyBox=document.getElementById("apply");
		var oYzm=document.getElementById("yzm");
		oApplyBox.style.height=300+"px";

		applybtn.onclick=function(){
			if (oApplyBox.style.display=="block")
			{
				move(oApplyBox,"top",0);
				setTimeout(function(){
					oApplyBox.style.display="none";
				},500);
			}else{
				oApplyBox.style.display="block"
				var h=oApplyBox.offsetHeight;
				oApplyBox.style.top=0;
				move(oApplyBox,"top",-300);
				/*setInterval(function(){
					if (oYzm.style.display=="none")
					{					
						move(oApplyBox,"top",-260);
					}else{					
						alert("a")
						move(oApplyBox,"top",-300);
					}
				},30);*/

			}
			
		}
	}
	var oSel=document.getElementById("course");
	oSel.onchange=function(){
	    var oErron_8=document.getElementById("erron_8");
	    if(oSel.value!="选择方向/专业"){
		oErron_8.innerHTML="";
	    }
	}

}
apply();

function creatshare(){
	var oshareDiv=document.createElement("div");
	oshareDiv.style.cssText="position:fixed;top:50%;left:50%;width:288px;margin:0 0 0 -144px;border:1px solid #ccc;z-index:9999;background:#fff; -moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius:15px;overflow:hidden;";
	document.body.appendChild(oshareDiv);
	oshareDiv.innerHTML="<ul class='shareUl'><li class='renren'>"
								+"<a href='http://share.renren.com/share/buttonshare.do?link='';title='''>人人网</a></li><li class='sina'>"
								+"<a href='http://v.t.sina.com.cn/share/share.php?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent('{$title}')+''&appkey=433903842&pic'>新浪微博</a></li><li class='qq'>"
								+"<a href='http://v.t.qq.com/share/share.php?title='''>腾讯微博</a></li><li class='douban'>"
								+"<a href='http://www.douban.com/recommend/?url=''&amp;title=''&amp;comment='''>豆瓣</a></li><li class='feixing'>"
								+"<a href='http://space.fetion.com.cn/api/share?source=''&amp;url=''&amp;title='''>飞信</a></li><li class='close_share' id='close_share'>"
								+"取消</li></ul>";
	var aLi=oshareDiv.getElementsByTagName("li");
	var h=oshareDiv.style.height=aLi[0].offsetHeight*aLi.length+"px";
	oshareDiv.style.marginTop=-(parseInt(h)/2)+"px";
	var oclose_share=document.getElementById("close_share");
	oclose_share.onclick=function(){
		document.body.removeChild(oshareDiv);
	}
}