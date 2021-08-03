define(["core","tpl"],function(d,e,t){var r={goods:!1,address:0,addressid:0,canpay:0,needdispatchpay:0,settime:0,init:function(e){r.goods=goods=e.goods,r.log=goods=e.log,r.addressid=r.log.addressid;var t=!1;if(void 0!==window.selectedAddressData)t=window.selectedAddressData;else if(void 0!==window.editAddressData)(t=window.editAddressData).address=t.areas.replace(/ /gi,"")+" "+t.address;else if("0"==r.goods.type){var i=r.getCookie("id"),a=r.getCookie("mobile"),n=decodeURIComponent(r.getCookie("realname")),o=decodeURIComponent(r.getCookie("addressd"));0<i&&(t={id:i,mobile:a,address:o,realname:n})}if(console.log(window.selectedAddressData),t&&(r.address=t,r.addressid=t.id,r.addressid&&d.json("creditshop/create/dispatch",{goodsid:r.goods.id,addressid:r.addressid,optionid:r.optionid},function(e){if(1!=e.status){t=e.result;return r.address="",r.addressid=0,$("#address_select").text("请选择收货地址"),$("#carrier_realname").show().find("input").val(""),$("#carrier_mobile").show().find("input").val(""),void FoxUI.toast.show(t.nodispatch)}var t=e.result;r.dispatch=t.dispatch,0<t.dispatch?(r.goods.dispatch=t.dispatch,$(".dispatchprice").html("运费：¥"+t.dispatch),$(".dispatch").html("¥ "+t.dispatch),$(".btn-1").html("支付运费")):$(".btn-1").html("确认兑换"),$("#address_select").html(r.address.address),$("#carrier_realname").show().find("input").val(r.address.realname),$("#carrier_mobile").show().find("input").val(r.address.mobile)}),$("#addressInfo a").attr("href",d.getUrl("member/address/selector")),$("#addressInfo a").click(function(){window.orderSelectedAddressID=t.id})),$(".fui-footer .btn-1").click(function(){(0<r.goods.dispatch||"1"==r.goods.type)&&r.addressid<1?FoxUI.toast.show("请选择收货地址!"):0==r.goods.isverify&&0<r.goods.dispatch?r.openActionSheet(!1):r.payDispatch("")}),$(".order-verify").unbind("click").click(function(){var e=$(this).data("orderid");r.verify(e)}),$(".order-finish").unbind("click").click(function(){var e=$(this).data("logid");FoxUI.confirm("确认已收到货了吗?","提示",function(){r.finish(e)})}),$(".order-packet").unbind("click").click(function(){var e=$(this).data("logid");FoxUI.confirm("确认领取红包吗?","提示",function(){r.packet(e)})}),$(".look-diyinfo").click(function(){var e="diyinfo_"+$(this).attr("data"),t=$(this).attr("hide");"1"==t?$("."+e).slideDown():$("."+e).slideUp(),$(this).attr("hide","1"==t?"0":"1")}),0<$("#nearStore").length){var s=[];(new BMap.Geolocation).getCurrentPosition(function(e){if(this.getStatus()==BMAP_STATUS_SUCCESS){var n=e.point.lat,o=e.point.lng;$(".store-item").each(function(){var e=$(this).find(".location"),t=$(this).data("lng"),i=$(this).data("lat");if(0<t&&0<i){var a=d.getDistanceByLnglat(o,n,t,i);$(this).data("distance",a),e.html("距离您: "+a.toFixed(2)+"km").show()}else $(this).data("distance",1e18),e.html("无法获得距离").show();s.push($(this))}),s.sort(function(e,t){return e.data("distance")-t.data("distance")}),$.each(s,function(){$(".store-container").append(this)}),$("#nearStore").show(),$("#nearStoreHtml").append($(s[0]).html());var t=$("#nearStoreHtml").find(".location").html();$("#nearStoreHtml").find(".location").html(t+"<span class='fui-label fui-label-danger'>最近</span> "),$(s[0]).remove()}},{enableHighAccuracy:!0})}},finish:function(e){d.json("creditshop/log/finish",{id:e},function(e){1!=e.status?FoxUI.toast.show(e.result):location.reload()},!0,!0)},packet:function(e){d.json("creditshop/log/Receivepacket",{id:e},function(e){1==e.status?setTimeout(function(){FoxUI.message.show({title:"恭喜您，红包领取成功!",icon:"icon icon-success",content:"",buttons:[{text:"确定",extraClass:"btn-danger",onclick:function(){location.reload()}}]})},1):FoxUI.toast.show(e.result.message)},!0,!0)},openActionSheet:function(e){FoxUI.actionsheet.show("选择支付方式",[{text:"微信支付",extraClass:"wechat",onclick:function(){r.payDispatch("wechat")}},{text:"支付宝支付",extraClass:"alipay",onclick:function(){r.payDispatch("alipay")}}],e)},verify:function(e){container=new FoxUIModal({content:$(".order-verify-hidden").html(),extraClass:"popup-modal",maskClick:function(){container.close()}}),container.show(),$(".verify-pop").find(".close").unbind("click").click(function(){container.close()}),d.json("groups/verify/qrcode",{id:e},function(e){if(0!=e.status){var t=+new Date;$(".verify-pop").find(".qrimg").attr("src",e.result.url+"?timestamp="+t).show()}else FoxUI.alert("生成出错，请刷新重试!")},!1,!0)},payDispatch:function(e){if(0==r.goods.isverify&&0<r.goods.dispatch){var t="确认兑换并支付运费吗？";r.needdispatchpay=1}else{t="确认兑换吗?";r.needdispatchpay=0}FoxUI.message.show({icon:"icon icon-information",content:t,buttons:[{text:"确定",extraClass:"btn-danger",onclick:function(){setTimeout(function(){d.json("creditshop/log/paydispatch",{id:r.log.id,addressid:r.addressid,paytype:e},function(e){var t=e.result;if(r.needdispatchpay){if(t.wechat){var i=t.wechat;if(i.weixin){function a(){WeixinJSBridge.invoke("getBrandWCPayRequest",{appId:i.appid?i.appid:i.appId,timeStamp:i.timeStamp,nonceStr:i.nonceStr,package:i.package,signType:i.signType,paySign:i.paySign},function(e){"get_brand_wcpay_request:ok"==e.err_msg?r.payResult():"get_brand_wcpay_request:cancel"==e.err_msg?FoxUI.toast.show("取消支付"):d.json("creditshop/log/paydispatch",{id:r.log.id,addressid:r.addressid,jie:1},function(e){r.payWechatJie(e.result.wechat)},!1,!0)})}"undefined"==typeof WeixinJSBridge?document.addEventListener?document.addEventListener("WeixinJSBridgeReady",a,!1):document.attachEvent&&(document.attachEvent("WeixinJSBridgeReady",a),document.attachEvent("onWeixinJSBridgeReady",a)):a()}else!t.wechat.weixin_jie&&1!=t.wechat.jie||r.payWechatJie(i)}else if(t.alipay){var n=t.alipay;n.success||FoxUI.toast.show("支付参数错误！"),location.href=d.getUrl("order/pay_alipay",{id:r.log.id,type:21,url:n.url})}}else r.payResult()},!0,!0)},1e3)}},{text:"取消",extraClass:"btn-default",onclick:function(){}}]})},payWechatJie:function(e){var t=d.getUrl("index/qr",{url:e.code_url});$("#qrmoney").text(r.goods.dispatch),$(".fui-header").hide(),$("#btnWeixinJieCancel").unbind("click").click(function(){clearInterval(r.settime),$(".order-weixinpay-hidden").hide(),$(".fui-header").show()}),$(".order-weixinpay-hidden").show(),r.settime=setInterval(function(){r.payResult()},2e3),$(".verify-pop").find(".close").unbind("click").click(function(){$(".order-weixinpay-hidden").hide(),$(".fui-header").show(),clearInterval(r.settime)}),$(".verify-pop").find(".qrimg").attr("src",t).show()},payResult:function(){var i=r.needdispatchpay?"运费支付成功!":"兑换成功!";d.json("creditshop/log/payresult",{id:r.log.id,needdispatchpay:r.needdispatchpay},function(e){var t=e.result;1==e.status?(clearInterval(r.settime),FoxUI.message.show({icon:"icon icon-success",content:i,buttons:[{text:"确定",extraClass:"btn-danger",onclick:function(){location.reload()}}]})):0==r.settime&&FoxUI.toast.show(t.message)},!1,!0)},getCookie:function(e){for(var t=e+"=",i=document.cookie.split(";"),a=0;a<i.length;a++){for(var n=i[a];" "==n.charAt(0);)n=n.substring(1);if(-1!=n.indexOf(t))return n.substring(t.length,n.length)}return""}};return r});