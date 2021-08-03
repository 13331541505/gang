<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Commission_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC'), $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_commission_bank') . (' WHERE 1 ' . $condition), $params);
		include $this->template('commission/bank');
	}
}

?>
