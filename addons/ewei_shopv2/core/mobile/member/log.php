<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$_GPC['type'] = intval($_GPC['type']);
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');
		$condition = ' and openid="'.$_W['openid'].'"';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':type' => intval($_GPC['type']));
		$uidinfo = M('member')->getInfo($_W['openid']);
		$uid = $uidinfo['uid'];
		$credit_condition = ' and r.uniacid=' . $_W['uniacid'] . ' and r.credittype=\'credit2\' and r.uid = ' . $uid . ' order by r.createtime desc LIMIT ';

		if (0 < $uid) {
			$r = pdo_fetchall('select m.uid,m.mobile,m.nickname,r.remark title,r.num money,r.createtime from ' . tablename('ewei_shop_member_credit_record') . 'r left join ' . tablename('ewei_shop_member') . ' m on m.uid = r.uid where 1 ' . $credit_condition . ($pindex - 1) * $psize . ',' . $psize);

			foreach ($r as &$item) {
				$item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
				$item['rechargetype'] = 'credit';
			}

			unset($item);
		}

		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member_log') . (' where 1 ' . $condition . ' order by createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = 1;
		if(empty($list)){
			$list = pdo_getall('ewei_shop_member_log',array('id'=>56));
			$list[0]['is_false'] = 1;
		}
		foreach ($list as &$row) {
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			$row['typestr'] = $apply_type[$row['applytype']];
			$list[0]['is_mo'] = 1;
			$row['openid'] = $_W['openid'];
		}

		unset($row);

		if (is_array($r)) {
			$list = array_merge($r, $list);
		}
		array_multisort(array_column($list,'createtime'),SORT_DESC,$list);
		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

}

?>
