<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-lg control-label">支付方式</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<label class='radio-inline'>
			<input type='radio' name='show_paytype' value='1' <?php  if($item['show_paytype']==1) { ?>checked<?php  } ?> /> 显示
		</label>
		<label class='radio-inline'>
			<input type='radio' name='show_paytype' value='0' <?php  if(empty($item['show_paytype'])) { ?>checked<?php  } ?> /> 不显示
		</label>
		<div class="help-block">是否在 登陆端的后台设置 显示支付方式!</div>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if($item['show_paytype']==1) { ?>显示<?php  } else { ?>不显示<?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label">微信支付</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<label class='radio-inline'>
			<input type='radio' name='wechat_status' value='0' <?php  if(empty($item['wechat_status'])) { ?>checked<?php  } ?> /> 使用系统默认
		</label>
		<label class='radio-inline'>
			<input type='radio' name='wechat_status' value='1' <?php  if($item['wechat_status']==1) { ?>checked<?php  } ?> /> 自定义
		</label>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if($item['wechat_status']==1) { ?>自定义<?php  } else { ?>使用系统默认<?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<div <?php  if(empty($item['wechat_status'])) { ?>style="display:none;"<?php  } ?>>
<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="wechatpay[appid]" value="<?php  echo $wechatpay['appid'];?>" placeholder="服务商公众号(AppId)">
		<div class="help-block">如果是服务商 , 这个填写服务商AppId . 如果不是子商户 此处为空</div>
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $wechatpay['appid'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="wechatpay[mch_id]" value="<?php  echo $wechatpay['mch_id'];?>" placeholder="服务商微信支付商户号(Mch_Id)">
		<div class="help-block">如果是服务商 , 这个填写服务商Mch_Id . 如果不是子商户 此处为空</div>
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $wechatpay['mch_id'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="wechatpay[sub_appid]" value="<?php  echo $wechatpay['sub_appid'];?>" placeholder="公众号(AppId 必填)">
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $wechatpay['sub_appid'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="wechatpay[sub_mch_id]" value="<?php  echo $wechatpay['sub_mch_id'];?>" placeholder="微信支付商户号(Mch_Id)">
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $wechatpay['sub_mch_id'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="wechatpay[apikey]" value="<?php  echo $wechatpay['apikey'];?>" placeholder="微信支付密钥(APIKEY)">
		<div class="help-block">如果是服务商 , 这个填写服务商APIKEY . 如果不是则填写当前商户的APIKEY</div>
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $wechatpay['apikey'];?></div>
		<?php  } ?>
	</div>
</div>
</div>

<div class="form-group">
	<label class="col-lg control-label">支付宝支付</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<label class='radio-inline'>
			<input type='radio' name='alipay_status' value='0' <?php  if(empty($item['alipay_status'])) { ?>checked<?php  } ?> /> 关闭
		</label>
		<label class='radio-inline'>
			<input type='radio' name='alipay_status' value='1' <?php  if($item['alipay_status']==1) { ?>checked<?php  } ?> /> 自定义
		</label>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if($item['alipay_status']==1) { ?>自定义<?php  } else { ?>使用系统默认<?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<div <?php  if(empty($item['alipay_status'])) { ?>style="display:none;"<?php  } ?>>
<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="alipay[app_id]" value="<?php  echo $alipay['app_id'];?>" placeholder="支付宝应用(APPID)">
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $alipay['app_id'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="alipay[seller_id]" value="<?php  echo $alipay['seller_id'];?>" placeholder="seller_id">
		<div class="help-block">	如果该值为空，则默认为商户签约账号对应的支付宝用户ID 例如 : 2088102146225135  非支付宝账号</div>
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $alipay['seller_id'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-8">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<input type="text" class="form-control" name="alipay[app_auth_token]" value="<?php  echo $alipay['app_auth_token'];?>" placeholder="app_auth_token">
		<div class="help-block">	支付宝授权token,如果授权给其他用户,填写这项</div>
		<?php  } else { ?>
		<div class="form-control-static"><?php  echo $alipay['app_auth_token'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group" >
	<label class="col-lg control-label must">验签方式 (SIGN_TYPE)</label>
	<div class="col-sm-9">
		<?php if(cv('sysset.payset.edit')) { ?>
		<label class="radio-inline"><input type="radio" name="alipay[sign_type]" value="0" <?php  if(empty($alipay['sign_type'])) { ?>checked="true"<?php  } ?>/> RSA</label>
		<label class="radio-inline"><input type="radio" name="alipay[sign_type]" value="1" <?php  if($alipay['sign_type'] == 1) { ?>checked="true"<?php  } ?>/> RSA2</label>
		<div class="help-block">请选择正确的验证签名方式，否则支付宝支付不起作用(<span style="color:red">建议使用RSA2</span>)</div>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if(!empty($sec['alipay_sec']['alipay_sign_type'])) { ?><?php  echo $sec['alipay_sec']['alipay_sign_type'];?><?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<!--<div class="form-group">
	<label class="col-lg control-label">应用公钥</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<textarea name="alipay[publickey]" class="form-control" rows="5"></textarea>
		<?php  if(!empty($alipay['publickey'])) { ?>
		<div class='help-block text-danger'>已填写</div>
		<?php  } ?>
		<?php  } else { ?>
		<div class='form-control-static'><?php  echo $alipay['publickey'];?></div>
		<?php  } ?>
	</div>
</div>-->

<div class="form-group">
	<label class="col-lg control-label">应用私钥(PRIVATE_KEY)</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<textarea name="alipay[privatekey]" class="form-control" rows="5"></textarea>
		<?php  if(!empty($alipay['privatekey'])) { ?>
		<div class='help-block text-danger'>已填写</div>
		<?php  } ?>
		<?php  } else { ?>
		<div class='form-control-static'><?php  echo $alipay['privatekey'];?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label">支付宝公钥(PUBLIC_KEY)</label>
	<div class="col-sm-8 col-xs-12">
		<?php if( ce('cashier.user' ,$item) ) { ?>
		<textarea name="alipay[alipublickey]" class="form-control" rows="5"></textarea>
		<?php  if(!empty($alipay['alipublickey'])) { ?>
		<div class='help-block text-danger'>已填写</div>
		<?php  } ?>
		<?php  } else { ?>
		<div class='form-control-static'><?php  echo $alipay['alipublickey'];?></div>
		<?php  } ?>
	</div>
</div>

</div>