<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Paycode_EweiShopV2Page extends MobilePage
{
	public function main()
	{

	    $url = mobileUrl('shop/paycode', ['shop_id'=>1], true);
	    $qrcode = m('qrcode')->createQrcode($url);
	    
		global $_W;
		global $_GPC;
		$shop_id = intval($_GPC['shop_id']);
		$shop = pdo_get('ewei_shop_merch_user',['id'=>$shop_id,'status'=>1,'uniacid'=>$_W['uniacid']]);
		if(!$shop){
		    $this->message('该商户暂未开启收款功能', '', 'error');
		}
		include $this->template();
	}
	
	public function pay(){
	    global $_W;
		global $_GPC;
	    var_dump($_GPC);die;
	}


}

?>
