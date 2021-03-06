<?php defined('IN_IA') or exit('Access Denied');?>	<div class="fui-list" style="background: <?php  echo $diyfollowbar['style']['background'];?>;display: none">
		<i class="close icon icon-guanbi1" data-value="follow" style="font-size: 1rem;margin-right: 0.7rem"></i>
	   	<div class="fui-list-media">
	   		<img class="<?php  echo $diyfollowbar['params']['iconstyle'];?>" src="<?php  echo $diyfollowbar['logo'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/followbarimg.png'">
	   	</div>
	    <div class="fui-list-inner">
	    	<div class="text" style="color: <?php  echo $diyfollowbar['style']['textcolor'];?>;"><?php  echo $diyfollowbar['text'];?></div>
	    </div>
   		<div class="fui-list-angle">
   			<div class="btn btn-success external" data-followurl="<?php  echo $diyfollowbar['link'];?>" data-qrcode="<?php  echo $diyfollowbar['qrcode'];?>" id="followbtn" style="border: none; color: <?php  echo $diyfollowbar['style']['btncolor'];?>; background: <?php  echo $diyfollowbar['style']['btnbgcolor'];?>;"><?php  if(!empty($diyfollowbar['params']['btnicon'])) { ?><i class="icon <?php  echo $diyfollowbar['params']['btnicon'];?>" style="font-size: 0.6rem;"></i> <?php  } ?><?php  if(!empty($diyfollowbar['params']['btntext'])) { ?><?php  echo $diyfollowbar['params']['btntext'];?><?php  } else { ?>点击关注<?php  } ?></div>
   		</div> 
   	</div>

	<?php  if(!empty($diyfollowbar['qrcode'])) { ?>
		<div class="follow_hidden" style="display: none;">
			<div class="verify-pop">
				<div class="close" ><i class="icon icon-roundclose"></i></div>
				<div class="qrcode" style="height: 250px;">
					<img class="qrimg" src="" />
				</div>
				<div class="tip">
					<p class="text-white">长按识别二维码关注</p>
					<p class="text-warning" style="color: <?php  echo $diyfollowbar['style']['highlight'];?>;"><?php  echo $_W['shopset']['shop']['name'];?></p>
				</div>
			</div>
		</div>
   	<?php  } ?>
   	<script>
   		$(function(){
   			var _followbtn = $("#followbtn");
   			var _followurl = _followbtn.data("followurl");
   			var _qrcode = _followbtn.data("qrcode");
   			_followbtn.click(function(){
   				if(_qrcode){
   					$('.verify-pop').find('.qrimg').attr('src', _qrcode).show();
   					follow_container = new FoxUIModal({
   						content: $(".follow_hidden").html(),
   						extraClass: "popup-modal",
   						maskClick:function(){
   							follow_container.close();
   						}
   					});
   					follow_container.show();
					$('.verify-pop').removeClass('follow_topbar')
   					$('.verify-pop').find('.close').unbind('click').click(function () {
		        		follow_container.close();
		        	});
   				}
   				else if(_followurl){
   					location.href = _followurl;
   				}
   				return;
   			});
			$('.close').click(function(){
				var tmpkey = $(this).data('value');
				if (tmpkey == 'follow')
				{
					$(this).parent().css({display:'none'}).removeClass('fui-list follow_topbar');
					cookie.set('close_followbar',tmpkey);
				}else if (tmpkey == 'startadv')
				{
					$(this).parent().css({display:'none'}).removeClass('fui-list follow_topbar');
					cookie.set('startadv',tmpkey);

				}

			});
			var cookie = {
				set:function(key,val,time){//设置cookie方法
					var date=new Date(); //获取当前时间
					document.cookie=key + "=" + val ;  //设置cookie
				},
				get:function(key){
					/*获取cookie参数*/
					var getCookie = document.cookie.replace(/[ ]/g,"");
					var arrCookie = getCookie.split(";");
					var tips;
					for(var i=0;i<arrCookie.length;i++){
						var arr=arrCookie[i].split("=");
						if(key==arr[0]){
							tips=arr[1];
							break;
						}
					}
					return tips;
				}
			};
			if(cookie.get('close_followbar') == 'follow'){
				$("[class='close icon icon-guanbi1']").parent().css({display:'none'}).removeClass('fui-list follow_topbar');
			}else{
				$("[class='close icon icon-guanbi1").parent().css({display:'flex'}).addClass('fui-list follow_topbar');
			}
			if (cookie.get('startadv') == 'startadv')
			{
				$("[class='fui-startadv default']").parent().css({display:'none'}).removeClass('fui-list follow_topbar');
			}else
			{
				$("[class='fui-startadv default']").parent().css({display:'flex'}).removeClass('fui-list follow_topbar');

			}
		});
   	</script>
   	
