<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection">

<title>最时代合作商户</title>
<style type="text/css" media="all">
    @CHARSET "UTF-8";
    html,body{
    	background-color:#f7f7f7;
    }
    .payinfo{
    	display:none;
    }
    .payinfo .paynum {
    	font-size: 0.6rem;
    	color: #424857;
    }
    /*记得写入职资料电子版*/
    .payinfo .payzero {
    	font-size: 0.6rem;
    	color: #424857;
    }
    table{
    	width:100%; 
    	height:50%;
    	position:absolute;
    	bottom:0;
        background-color:white;
        background-top:none;
    }
    table tr td{
    	text-align:center;
    	width: 1.88rem;
    	height: 1.26rem;
    	font-family: "Microsoft YaHei";
    	font-weight: normal;
    	border-right:1px solid #D9D9D9;
    	border-bottom:1px solid #D9D9D9;
    }
    table tr td:active{
    	background-color:#ECECEC;
    }
    .keybord-return{
    	width: 1.88rem;
    	height: 1.26rem;
    	background:url(../../addons/ewei_shopv2/static/images/keybord-return.png) no-repeat;
    	background-size: 50% 50%;
    	background-position: center;
    }
    .keybord-stop{background-image:url(../../addons/ewei_shopv2/static/images/keybord-stop.png); background-size:90% 90%;}
    .pay{
    	color:#ffffff;
    	font-size:0.3rem;
    	background-color:#fe9b20;
    }
    .pay:active{
    	background-color: #D9D9D9;
    }
    .pay a{
    	display: block;
    	position: relative;
    	width: 100%;
    	height: 100%;
    	color: #fff;
    	text-decoration: none;
    }
    .a-pay {
    	position: absolute;
    	top: 50%;
    	left: 50%;
    	-webkit-transform: translate(-50%, -50%);
    	-o-transform: translate(-50%, -50%);
    	-moz-transform: translate(-50%, -50%);
    	transform: translate(-50%, -50%);
    }
    .pay-disabled {
    	background-color: #D9D9D9;
    }
    * {
        padding: 0;
        margin: 0;
    }
    .pay-top {
    
    }
    .pay-shop-info {
        width: 100%;
        margin-bottom: 0.2rem;
    }
    .pay-shop-info .content {
        padding-top: 0.3rem;
        display: flex;
        width: 4rem;
        height: 0.8rem;
        margin: 0 auto;
    }
    .pay-shop-info .shop-logo{
        flex: 1;
        width: 0.8rem;
        height: 0.8rem;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }
    .pay-shop-info .shop-name {
        flex: auto;
        height: 0.8rem;
        font-size: 0.42rem;
        line-height: 0.8rem;
        margin-left: 0.2rem;
        color: #2f323a;
    }
    .pay-input-money {
        width: 6.76rem;
        height: 1.24rem;
        line-height: 1.24rem;
        margin: 0 auto;
        border: 0.04rem solid rgb(255,56,71);
        -webkit-border-radius: 0.02rem;
        -moz-border-radius: 0.02rem;
        border-radius: 0.02rem;
        background: #fff;
        border-radius:5px;
    }
    .input-left {
        float: left;
        font-size: 0.4rem;
        padding-left: 0.24rem;
    }
    .input-right {
        font-size: 0.4rem;
        float: right;
    }
    .input-right label{
        display: inline-block;
        width: 2.3rem;
        font-size: 0.4rem;
    }
    
    .upper-case {
        margin-right: 0.48rem;
        font-size: 0.25rem;
        color: #949494;
        float: right;
    }

</style>
</head>
<!-- 
	通用说明： 
	1.模块的隐藏添加class:hide;
	2.body标签默认绑定ontouchstart事件，激活所有按钮的:active效果
-->
<body ontouchstart class="weui-wepay-pay-wrap">
<div class="pay-top">
	<div class="pay-shop-info" style="margin-bottom:1rem;">
		<div class="content">
			<img class="shop-logo" src="../../attachment/<?php  echo $shop['logo'];?>" alt="商家logo">
			<span class="shop-name"><?php  echo $shop['merchname'];?></span>
		</div>
	</div>
	<div class="pay-input-money">
		<div class="input-left">
			<span>输入消费金额</span>
		</div>
		<div class="input-right">
			<span>￥</span>
			<label id="paymoney" type="text"></label>
		</div>
	</div>
	<div class="upper-case">
		<span class="upper-case-content"></span>
	</div>
</div>
<div class="payinfo">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td class="paynum">1</td>
			<td class="paynum">2</td>
			<td class="paynum">3</td>
			<td id="pay-return">
				<div class="keybord-return"></div>
			</td>
		</tr>
		<tr>
			<td class="paynum">4</td>
			<td class="paynum">5</td>
			<td class="paynum">6</td>
			<td rowspan="3" class="pay">
				<a href="javascript:return false;">
					<div class="a-pay">
						<p>确认</p>
						<p>支付</p>
					</div>
				</a>
			</td>
		</tr>
		<tr>
			<td class="paynum">7</td>
			<td class="paynum">8</td>
			<td class="paynum">9</td>
		</tr>
		<tr>
			<td id="pay-zero" colspan="2" class="payzero">0</td>
			<td id="pay-float">.</td>
		</tr>
	</table>
</div>
</body>

<script type="text/javascript">
	$(function(){
		$(".payinfo").slideDown();
		var $paymoney = $("#paymoney");
		// 大写金额
		var upperCaseMoney = $('.upper-case span');
		$("#paymoney").focus(function(){
			$(".payinfo").slideDown();
       		document.activeElement.blur();
		});
		$(".paynum").each(function(){
			$(this).click(function(){
				if(($paymoney.text()).indexOf(".") != -1 && ($paymoney.text()).substring(($paymoney.text()).indexOf(".") + 1, ($paymoney.text()).length).length == 2){
					return;
				}
				if($.trim($paymoney.text()) == "0"){
					return;
				}
				if (parseInt($paymoney.text()) > 10000 && $paymoney.text().indexOf(".") == -1) {
					return;
				}
				$paymoney.text($paymoney.text() + $(this).text());
				
				
				$('.pay').removeClass('pay-disabled').find('a').attr('href','javascript:;');
				upperCaseMoney.text(digitUppercase($paymoney.text()));
			});
		});
		
		$('.pay').click(function(){
		    var money = $paymoney.text();
		    if(money){
		        $.post('<?php  echo mobileUrl("shop/paycode/pay",array("merchid"=>$shop["id"]))?>',{money:money},function(res){
		            console.log(res); 
		        });
		    }
		});
		
		$("#pay-return").click(function(){
			$paymoney.text(($paymoney.text()).substring(0, ($paymoney.text()).length - 1));
			upperCaseMoney.text(digitUppercase($paymoney.text()));
			if (!$paymoney.text()) {
				upperCaseMoney.text('');
				$('.pay').addClass('pay-disabled').find('a').attr('href', 'javascript:return false;');
			}
		});
		
		$("#pay-zero").click(function(){
			if(($paymoney.text()).indexOf(".") != -1 && ($paymoney.text()).substring(($paymoney.text()).indexOf(".") + 1, ($paymoney.text()).length).length == 2){
				return;
			}
			if($.trim($paymoney.text()) == "0"){
				return;
			}
			if (parseInt($paymoney.text()) > 10000 && $paymoney.text().indexOf(".") == -1) {
				return;
			}
			$paymoney.text($paymoney.text() + $(this).text());
		});
		
		$("#pay-float").click(function(){
			if($.trim($paymoney.text()) == ""){
				return;
			}
		
			if(($paymoney.text()).indexOf(".") != -1){
				return;
			}
			
			if(($paymoney.text()).indexOf(".") != -1){
				return;
			}
			
			$paymoney.text($paymoney.text() + $(this).text());
		});
		if (!$paymoney.text()) {
			$('.pay').addClass('pay-disabled');
		}
	});
</script>
<!--自适应布局-->
<script>
	(function () {
		var designW = 750;  //设计稿宽
		var font_rate = 100;
		//适配
		document.getElementsByTagName("html")[0].style.fontSize = document.body.offsetWidth / designW * font_rate + "px";
		document.getElementsByTagName("body")[0].style.fontSize = document.body.offsetWidth / designW * font_rate + "px";

		//监测窗口大小变化
		window.addEventListener("resize", function () {
			document.getElementsByTagName("html")[0].style.fontSize = document.body.offsetWidth / designW * font_rate + "px";
			document.getElementsByTagName("body")[0].style.fontSize = document.body.offsetWidth / designW * font_rate + "px";
		}, false);
	})();
</script>
<!--金额转大写-->
<script>
	var digitUppercase = function(n) {
		var fraction = ['角', '分'];
		var digit = [
			'零', '壹', '贰', '叁', '肆',
			'伍', '陆', '柒', '捌', '玖'
		];
		var unit = [
			['元', '万', '亿'],
			['', '拾', '佰', '仟']
		];
		var head = n < 0 ? '欠' : '';
		n = Math.abs(n);
		var s = '';
		for (var i = 0; i < fraction.length; i++) {
			s += (digit[Math.floor(n * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');
		}
		s = s || '整';
		n = Math.floor(n);
		for (var i = 0; i < unit[0].length && n > 0; i++) {
			var p = '';
			for (var j = 0; j < unit[1].length && n > 0; j++) {
				p = digit[n % 10] + unit[1][j] + p;
				n = Math.floor(n / 10);
			}
			s = p.replace(/(零.)*零$/, '').replace(/^$/, '零') + unit[0][i] + s;
		}
		return head + s.replace(/(零.)*零元/, '元')
						.replace(/(零.)+/g, '零')
						.replace(/^整$/, '零元整');
	};
</script>

</html>

