 //界面加载获取后台数据
   window.onload = function() {
      getData();
  }
 //获取后台数据 活动列表页
 function getData(){
  var url = "/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list";//"http://192.168.1.30/gang/web/url.php/api/index" ;//"/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list";//?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list ";
      $.ajax({
        type: "POST",
        url: url,
        xhrFields: { withCredentials: true },
        crossDomain: true, 
        data:  "",//{i:2,c:"entry",m:"ewei_shopv2",do:"mobile",r:"api.game_list"},
        dataType: "JSON",
        success: function (data ,textStatus, jqXHR)
        {
          // data = [{"id":"3","uniacid":"2","game_name":"现金刚一下活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/WiZ3ZVvIvh8UIROvkV1RovI3kv4RzR.png","content":"刚一下现金活动简介","is_cash":"1","is_tong":"0","is_te":"0","member_max":"29","member_min":"100","game_money":"1.00","money_min":"0.00","start_time":"2021-05-20 10:16:26","time_for":"3","hexiao":"1","ok_where":"[\"1\",\"2\",\"3\"]","goods_id":"[\"20\",\"21\"]","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":2,"is_man":0,"goods":[{"id":"20","title":"iphone 11","thumb":"\/attachment\/images\/2\/2021\/04\/LX8oX2FBg5bsV2KWBV222xB8lF5Gm3.jpg","minprice":"4999.00"},{"id":"21","title":"美味好吃小苗条1111","thumb":"\/attachment\/images\/2\/2021\/04\/oy0h00E8hepyYzyzNB0by0EznH01P7.jpg","minprice":"10.00"}]},{"id":"4","uniacid":"2","game_name":"门店集奖实物奖励刚一下游戏活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/gL14W4ikI71u7wSG1W3c48wLwiG744.png","content":"门店集奖实物奖励刚一下游戏活动简介","is_cash":"0","is_tong":"1","is_te":"0","member_max":"200","member_min":"200","game_money":"2.00","money_min":"10.00","start_time":"2021-05-20 10:16:26","time_for":"","hexiao":"1","ok_where":"[\"1\",\"2\",\"3\"]","goods_id":"[\"20\",\"21\"]","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":2,"is_man":0,"goods":[{"id":"20","title":"iphone 11","thumb":"\/attachment\/images\/2\/2021\/04\/LX8oX2FBg5bsV2KWBV222xB8lF5Gm3.jpg","minprice":"4999.00"},{"id":"21","title":"美味好吃小苗条1111","thumb":"\/attachment\/images\/2\/2021\/04\/oy0h00E8hepyYzyzNB0by0EznH01P7.jpg","minprice":"10.00"}]},{"id":"5","uniacid":"2","game_name":"线下门店促销活动-实物奖励刚一下游戏活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/LL1lM5v8e3BLzL3M3QelLl36smlRRY.png","content":"线下门店促销活动-实物奖励刚一下游戏活动","is_cash":"0","is_tong":"1","is_te":"0","member_max":"200","member_min":"200","game_money":"3.00","money_min":"3.00","start_time":"2021-05-20 10:16:26","time_for":"60","hexiao":"0","ok_where":"[\"1\",\"2\",\"3\"]","goods_id":"[\"20\",\"21\"]","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":2,"is_man":0,"goods":[{"id":"20","title":"iphone 11","thumb":"\/attachment\/images\/2\/2021\/04\/LX8oX2FBg5bsV2KWBV222xB8lF5Gm3.jpg","minprice":"4999.00"},{"id":"21","title":"美味好吃小苗条1111","thumb":"\/attachment\/images\/2\/2021\/04\/oy0h00E8hepyYzyzNB0by0EznH01P7.jpg","minprice":"10.00"}]},{"id":"6","uniacid":"2","game_name":"门店集奖你笑我买奖励刚一下游戏活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/LL1lM5v8e3BLzL3M3QelLl36smlRRY.png","content":"门店集奖你笑我买奖励刚一下游戏活动","is_cash":"0","is_tong":"1","is_te":"0","member_max":"200","member_min":"200","game_money":"4.00","money_min":"400.00","start_time":"2021-05-20 10:16:26","time_for":"60","hexiao":"1","ok_where":"[\"1\",\"2\",\"3\"]","goods_id":"[\"20\",\"21\"]","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":2,"is_man":0,"goods":[{"id":"20","title":"iphone 11","thumb":"\/attachment\/images\/2\/2021\/04\/LX8oX2FBg5bsV2KWBV222xB8lF5Gm3.jpg","minprice":"4999.00"},{"id":"21","title":"美味好吃小苗条1111","thumb":"\/attachment\/images\/2\/2021\/04\/oy0h00E8hepyYzyzNB0by0EznH01P7.jpg","minprice":"10.00"}]},{"id":"7","uniacid":"2","game_name":"防火车奖刚一下活动奖励","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/sM78pPl525ofG27lxub88bccfbBBbb.png","content":"防火车奖刚一下活动奖励","is_cash":"0","is_tong":"0","is_te":"1","member_max":"100","member_min":"100","game_money":"0.00","money_min":"0.00","start_time":"2021-05-20 10:16:26","time_for":"","hexiao":"1","ok_where":"[\"1\"]","goods_id":"[\"20\",\"21\"]","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":0,"is_man":0,"goods":[{"id":"20","title":"iphone 11","thumb":"\/attachment\/images\/2\/2021\/04\/LX8oX2FBg5bsV2KWBV222xB8lF5Gm3.jpg","minprice":"4999.00"},{"id":"21","title":"美味好吃小苗条1111","thumb":"\/attachment\/images\/2\/2021\/04\/oy0h00E8hepyYzyzNB0by0EznH01P7.jpg","minprice":"10.00"}]},{"id":"8","uniacid":"2","game_name":"50000元现金奖励刚一下活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/WiZ3ZVvIvh8UIROvkV1RovI3kv4RzR.png","content":"50000元现金奖励刚一下活动","is_cash":"0","is_tong":"1","is_te":"0","member_max":"100","member_min":"100","game_money":"10.00","money_min":"10.00","start_time":"2021-05-20 10:16:26","time_for":"60","hexiao":"0","ok_where":"[\"1\",\"3\"]","goods_id":"null","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":0,"is_man":0,"goods":[]},{"id":"9","uniacid":"2","game_name":"平台加帮车或房实物奖励刚一下游戏活动","game_img":"https:\/\/gang.jixunxi.com\/attachment\/images\/2\/2021\/05\/gL14W4ikI71u7wSG1W3c48wLwiG744.png","content":"平台加帮车或房实物奖励刚一下游戏活动","is_cash":"0","is_tong":"1","is_te":"0","member_max":"500","member_min":"400","game_money":"30.00","money_min":"5000.00","start_time":"2021-05-20 10:16:26","time_for":"1","hexiao":"0","ok_where":"[\"1\",\"2\"]","goods_id":"null","status":"0","ok_num":null,"lun_time":"2021-05-19 14:06:16","is_baoming":0,"sum":2,"is_man":0,"goods":[]}] ;
           var htmlData ="" ; //界面列表串
           var jpArr = [] ;   //奖品数组
           var startTimeArr = [] ; //开始时间数组
         //遍历返回的对象数组
          $.each(data,function(key,value){
             var obj = data[key] ;
             //背景色的四个样式
             var arrBgColor=["","one","two","three"];
             var num = key%4 ;

             //获取背景颜色样式
             var bgColor = arrBgColor[num];
              htmlData += getPageInfo(obj,bgColor) ; 

              //奖品数组
              jpArr.push(getItemsGoods(obj.goods)) ;

              //开始时间数组
              startTimeArr.push(obj.start_time) ;
          });
          //详情页面显示数据
          $("#list-box").html(htmlData);

          //报名按钮文字显示
          //bmBtn(data) ;

          //绑定悬浮窗口显示（点图片），展示详情页详细内容
         // showFFrame() ;
      
          // 悬浮窗口关闭 绑定关闭事件
         // closeFFrame();
          
          //遍历奖品标签 并赋值
         /* getItemGoods(jpArr) ;*/

          //倒计时 遍历界面倒计时标签
          var $djsEles = $('.daojishi-flag') ;
          $.each($djsEles,function(index,ele){
              //判断报名人数是否满了
              showDjs($djsEles[index],data[index].start_time,data[index].id,isFully(data[index])) ;//传入dom元素以及数据
          }) ;
          

          /*//判断是否报名已满
          function isFully(obj){
            alert("****")
            var isFully = false ;
            if (obj.member_max > obj.sum) {
               isFully = isFully ;
            }else {
              isFully = !isFully ;
            }
            return isFully ;
          }
*/

        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {      
             showBmTips("","请求失败","")
        }
      });
}

  //获取界面列表数据html
    function getPageInfo(obj,bgColor,daojisiTime){
      var html = "";
          html +=  ' <div class="position-relative">' ;
          html +=  ' <a href="javascript:;" onclick="reqDetailInfo('+obj.id+')" class="aui-flex '+bgColor+'" >' ; //bgColor为背景颜色
          html +=  '                   <div class="aui-img">' ;
          html +=  '                       <img src=" '+obj.game_img+' "alt="">' ; //活动主题 '+obj.game_img+'
       //   html +=  '                       <span>现金奖励</span>' ;
          html +=  '                  </div>' ;
          html +=  '                 <div class="aui-flex-box">' ;
          html +=  '                     <h2>'+obj.game_name+'</h2>' ; //活动名称
          html +=  '                    <p>共'+obj.member_max+'人 | 已报：'+obj.sum+ '</p>' ; 
          /* html +=  '                    <p class="start-time style="display:hidden">'+obj.start_time+'</p>' ;*/ //活动开始时间
          html +=  '                     <div class="aui-user-box ">' ;
        /*  html +=  '                         <div class="aui-user">' ;*/
        //  html +=  '                             <img src="img/qianglibao.png" alt="">' ;
         /* html +=  '                        </div>' ;*/
          html +=  '                        <div class="aui-flex-box jp-and-content">' ;
          html +=  '                           <h3><span></span><span></span> </h3>' ; 
          html +=  '                           <h4><span>主题：</span><span>'+obj.content+'</span></h4>' ;
          html +=  '                      </div>' ;
          html +=  '                  </div>' ;
        //  html +=  '                 <h5><span>已报名人数：59</span></h5>' ;
        //  html +=  '                 <h5><span class="size-red" id="daojishi">距开始:2天2时3分3秒</span></h5>' ;
          html +=  '             </div>' ;
          html +=  '              <span class="daojishi-flag"  >预计:00天00时00分00秒</span>' ;//活动开始时间
       /*   html +=  '             <button class="aui-btn" onclick="entry('+obj.id+','+obj.is_cash+','+obj.is_tong+','+obj.is_te+')">立即报名</button>' ;*///"is_cash":"0","is_tong":"1","is_te":"0" 现金报名，通用优惠券报名，特殊优惠劵报名
          html +=  '  </a>' ;
          html +=  '  <div class="hover-frame">' ;
          html +=  '     <h5>活动介绍</h5>' ;
          html +=  '     <p></p>' ;
          html +=  '     <a href="#"><img src="img/cancel-btn-gray.png"></a>' ;
          html +=  '     <h5>奖品</h5>' ;
          html +=  '     <p></p>' ;
          html +=  '     <a href="#"><img src="img/cancel-btn-gray.png"></a>' ;
          html +=  ' </div>' ;
          html +=  '<div class="cover-box"></div>' ;
          html +=  '</div>' ;
      return html ;
    }


//遍历奖品标签 并赋值
function getItemGoods(jpArr){
      var jpEles = $(".jp-and-content h3") ;//.find("span").eq(1)
      for(var i = 0 ; i < jpEles.length ; i ++){
        if (jpArr[i] == "") 
          { jpEles[i].style.display="none";}
        jpEles[i].getElementsByTagName("span")[1].innerHTML=jpArr[i];
      }
}

//处理奖品数据，返回每项活动的奖品字符串
function getItemsGoods(data){
  var goodsStr = "" ;
  for(var i = 0 ; i < data.length;i++){
    goodsStr += data[i].title + "/";
  }
  return goodsStr ;
}

//工具类倒计时
function dao_time(domEle,end_time,id,timeInterVal,isFully){
      end_time =  end_time.replace('-','/').replace('-','/');
      var nowtime = new Date(),          //获取当前时间
          endtime = new Date(end_time);  //定义结束时间
      var timeInfo = "" ;
         var lefttime = endtime.getTime() - nowtime.getTime(),  //距离结束时间的毫秒数
             leftd = Math.floor(lefttime/(1000*60*60*24)),     //计算天数
             lefth = Math.floor(lefttime/(1000*60*60)%24),     //计算小时数
             leftm = Math.floor(lefttime/(1000*60)%60),        //计算分钟数
             lefts = Math.floor(lefttime/1000%60);         //计算秒数
             if(lefttime<0){
                  timeInfo = "活动结束" ;
                  clearInterval(timeInterVal) ;
                  //验证是否活动结束
                if (!isFully) {
                  isDelay(domEle,id);
                }
             }else {
                  timeInfo ="预计:" + leftd + "天" + lefth + "时" + leftm + "分" + lefts+"秒" ;
             }

      return timeInfo;  //返回倒计时的字符串
 }

 //验证是否活动结束
 function isDelay(domEle,id){
     var url = "/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list";//"http://192.168.1.30/gang/web/url.php/api/index" ;//"/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list";//?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.game_list ";
      $.ajax({
        type: "POST",
        url: url,
        xhrFields: { withCredentials: true },
        crossDomain: true, 
        data:  "",//{i:2,c:"entry",m:"ewei_shopv2",do:"mobile",r:"api.game_list"},
        dataType: "JSON",
        success: function (data ,textStatus, jqXHR){
            var startTime =  getStartTime(id,data) ;
            var objData = getEventObj(data,id) ;
            var isF = isFully(objData) ;
            showDjs(domEle,startTime,id,isF);
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {      
           //showBmTips("","请求失败","")
        }
      });
 }


//判断是否报名人数达到了最低开始人数
function isFully(obj){
  var isFully = false ;
  if (obj.member_min > obj.sum) {
     isFully = isFully ;
  }else {
    isFully = !isFully ;
  }
  return isFully ;
}


//获取该活动的对象信息 id 活动id，
  function getStartTime(id,data){
        var starttime = "" ;
      $.each(data,function(index,ele){
        var obj = data[index] ;
        if (id==obj.id) {
          starttime = obj.start_time ;
        }
      }) ;
      return starttime ;
  }

//根据id获取活动obj数据
function getEventObj(data,id){
    var objEvent = {} ;
   $.each(data,function(index,ele){
        var obj = data[index] ;
        if (id==obj.id) {
          objEvent = obj ;
          return ;
        }
    }) ;

   return objEvent ;
}


 //提示框 显示 隐藏
/*entryType 什么报名的 （现金劵 优惠劵 特殊劵）
  isSuccess 是否成功
*/
function showBmTips(entryType,isSucceed,eleBtn){
  //获取元素
   var isSuccess = $("#isSuccess");
   var entryType = $("#entryType");
   var tkBox = $("#tkBox") ;

   //显示弹框
   tkBox.show();
   //document.getElementById('body').style.overflow='hidden' ;//解决遮罩层弹出，下面界面还会滑动的问题
 
   //赋值
   isSuccess.html(isSucceed) ;
   entryType.html(entryType) ;

   if (isSucceed.indexOf("成功") != -1) { //如果返回的提示信息包含"成功"，将该报名按钮text改为"已报名"，并将按钮设置未 不可操作
       eleBtn.innerHTML = "已报名" ;
       eleBtn.disabled = "true" ;
   }
}
//弹框关闭(点差)
 $(".cancel-btn a").click(function(){
    var tkBox = $("#tkBox").hide() ;
  }) ;
//弹框关闭（点返回）
$("#goBack").click(function(){
      $("#tkBox").hide()
});


//请求进入详情页（刚游戏）
function reqDetailInfo(id){
     window.location.href='/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=game.details?param='+id ; //跳转到详情页面
}

//显示倒计时
function showDjs(domEle,start_time,id,isFully){
         var timeInterVal = setInterval(function(){
            var res = dao_time(domEle,start_time,id,timeInterVal,isFully);
            domEle.innerHTML = res;
            domEle.style.display= "inline-block" ;
        }, 1000);
       /*setInterval(function(){
          for(var i=0;i<$daoJsEles.length;i++){
             var res = dao_time(startTimeArr[i],data[i].id);
             $daoJsEles[i].innerHTML = res;
             console.log('res:'+res) ;
             $daoJsEles.show() ;
          }
       },1000);*/
}


////报名按钮文字显示
/*function bmBtn(data){
  var bmBtnsArr =$(".aui-btn");
  for (var i = 0 ; i < bmBtnsArr.length ; i++) {
       if (data[i].is_baoming == 1) { //"is_baoming" 1已报名 0未报名
            bmBtnsArr[i].innerHTML = "已报名" ;
            bmBtnsArr[i].disabled=true;
       }else {
          if(data[i].member_max <= data[i].sum ){ //未报名
                  bmBtnsArr[i].innerHTML = "人数已满" ;
                  bmBtnsArr[i].disabled=true;
         }else {
           
         }
       }
  }
}
*/












//报名(传入游戏id，0成功，1失败) 报名按钮
/*function entry(id,cash,tong,te){
  var eleBtn =  event.currentTarget ;//获取当前点击的元素
  var url = "https://gang.jixunxi.com/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=api.add_game_member";
      $.ajax({
        type: "POST",
        url: url,
        xhrFields: { withCredentials: true },
        crossDomain: true, 
        data:  {id:id},//传入游戏ID {i:2,c:"entry",m:"ewei_shopv2",do:"mobile",r:"api.game_list"},
        dataType: "JSON",
        success: function (data ,textStatus, jqXHR)
        {
          if(data.code==0){
            var entryType = cash==1?"现金":(tong==1?"通用优惠劵":"特殊优惠券" );
              showBmTips(entryType,data.msg,eleBtn) ; //提示信息
          } else{
              showBmTips("",data.msg,eleBtn) ;
          }

        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {      
           showBmTips("","请求失败","")
        }
      });
}
*/



//显示浮窗
/*function showFFrame(){
    var details = $(".aui-img") ; //详情界面图片
      for(var i=0;i<details.length;i++){
          details[i].addEventListener("click",function(e){ //图片绑定事件 弹出详情框
                  $(this).parent().next().show();
                  $(this).parent().next().find("p").eq(0).html($(this).next().find("h4 span").eq(1).html()) ;
                  $(this).parent().next().find("p").eq(1).html($(this).next().find("h3 span").eq(1).html()) ;
                  $(this).parent().next().next().show();//show() ; //遮罩层显示
                  e.stopPropagation() ;
          });
       }
}
*/


//关闭浮窗事件
/*function closeFFrame(){
  var  closeBtns =  $(".hover-frame a") ;
  for (var i =  0; i < closeBtns.length ; i++) {
     closeBtns[i].addEventListener('click',function(e){
        $(this).parent().hide() ;
        $(this).parent().next('.cover-box').hide() ; //遮罩层隐藏
        e.stopPropagation() ;
     }) ;
  }
}
*/






