<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	protected function merchData()
	{
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		return array('is_openmerch' => $is_openmerch, 'merch_plugin' => $merch_plugin, 'merch_data' => $merch_data);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$money = floatval($_GPC['money']);
		$merchs = $_GPC['merchs'];
		$goods = $_GPC['goods'];

		if (is_string($merchs)) {
			$merchstring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['merchs']));
			$merchs = @json_decode($merchstring, true);
		}

		if (is_string($goods)) {
			$goodsstring = htmlspecialchars_decode(str_replace('\\', '', $_GPC['goods']));
			$goods = @json_decode($goodsstring, true);
		}

		if ($type == 0) {
			$list = com_run('coupon::getAvailableCoupons', $type, 0, $merchs, $goods);
		}
		else {
			if ($type == 1) {
				$list = com_run('coupon::getAvailableCoupons', $type, $money, $merchs);
			}
		}

		foreach ($list as &$row) {
			$row['thumb'] = tomedia($row['thumb']);
			$row['timestart'] = !empty($row['timestart']) ? date('Y-m-d', $row['timestart']) : '';
			$row['timeend'] = !empty($row['timeend']) ? date('Y-m-d', $row['timeend']) : '';
			$row['gettime'] = !empty($row['gettime']) ? date('Y-m-d H:i:s', $row['gettime']) : '';
		}

		unset($row);
		$list = set_medias($list, 'thumb');
		return app_json(array('list' => $list, 'count' => count($list)));
	}

	public function getCouponsbygood()
	{
		global $_W;
		global $_GPC;
		$goodid = intval($_GPC['goodsid']);
		$merchdata = $this->merchData();
		extract($merchdata);
		$time = time();
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,timelimit,coupontype,timedays,timestart,timeend,thumb,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax,merchid,total as t,limitmemberlevels,limitagentlevels,limitpartnerlevels,limitaagentlevels,limitgoodcatetype,limitgoodcateids,limitgoodtype,limitgoodids,tagtitle,settitlecolor,titlecolor from ' . tablename('ewei_shop_coupon') . ' c ';
		$sql .= ' where uniacid=:uniacid and money=0 and credit = 0 and coupontype=0';

		if ($is_openmerch == 0) {
			$sql .= ' and merchid=0';
		}
		else if (!empty($_GPC['merchid'])) {
			$sql .= ' and merchid=:merchid';
			$param[':merchid'] = intval($_GPC['merchid']);
		}
		else {
			$sql .= ' and merchid=0';
		}

		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);

			if (empty($plugin_com_set['level'])) {
				$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);

			if (empty($plugin_globonus_set['open'])) {
				$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);

			if (empty($plugin_abonus_set['open'])) {
				$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
		}

		$sql .= ' and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))';
		$sql .= ' order by displayorder desc, id desc  ';
		$list = set_medias(pdo_fetchall($sql, $param), 'thumb');

		if (empty($list)) {
			$list = array();
		}

		if (!empty($goodid)) {
			$goodparam[':uniacid'] = $_W['uniacid'];
			$goodparam[':id'] = $goodid;
			$sql = 'select id,cates,marketprice,merchid   from ' . tablename('ewei_shop_goods');
			$sql .= ' where uniacid=:uniacid and id =:id order by id desc LIMIT 1 ';
			$good = pdo_fetch($sql, $goodparam);
		}

		$cates = explode(',', $good['cates']);

		if (!empty($list)) {
			foreach ($list as $key => &$row) {
				$row = com('coupon')->setCoupon($row, time());
				$row['thumb'] = tomedia($row['thumb']);
				$row['timestr'] = '????????????';

				if (empty($row['timelimit'])) {
					if (!empty($row['timedays'])) {
						$row['timestr'] = date('Y-m-d H:i', $row['gettime'] + $row['timedays'] * 86400);
					}
				}
				else if ($time <= $row['timestart']) {
					$row['timestr'] = date('Y-m-d H:i', $row['timestart']) . '-' . date('Y-m-d H:i', $row['timeend']);
				}
				else {
					$row['timestr'] = date('Y-m-d H:i', $row['timeend']);
				}

				if ($row['backtype'] == 0) {
					$row['backstr'] = '??????';
					$row['backmoney'] = $row['deduct'];
					$row['backpre'] = true;

					if ($row['enough'] == '0') {
						$row['color'] = 'org ';
					}
					else {
						$row['color'] = 'blue';
					}
				}
				else if ($row['backtype'] == 1) {
					$row['backstr'] = '???';
					$row['backmoney'] = $row['discount'];
					$row['color'] = 'red ';
				}
				else {
					if ($row['backtype'] == 2) {
						if ($row['coupontype'] == '0') {
							$row['color'] = 'red ';
						}
						else {
							$row['color'] = 'pink ';
						}

						if (0 < $row['backredpack']) {
							$row['backstr'] = '??????';
							$row['backmoney'] = $row['backredpack'];
							$row['backpre'] = true;
						}
						else if (0 < $row['backmoney']) {
							$row['backstr'] = '??????';
							$row['backmoney'] = $row['backmoney'];
							$row['backpre'] = true;
						}
						else {
							if (!empty($row['backcredit'])) {
								$row['backstr'] = '?????????';
								$row['backmoney'] = $row['backcredit'];
							}
						}
					}
				}

				$limitmemberlevels = explode(',', $row['limitmemberlevels']);
				$limitagentlevels = explode(',', $row['limitagentlevels']);
				$limitpartnerlevels = explode(',', $row['limitpartnerlevels']);
				$limitaagentlevels = explode(',', $row['limitaagentlevels']);
				$p = 0;

				if ($row['islimitlevel'] == 1) {
					$openid = trim($_W['openid']);
					$member = m('member')->getMember($openid);
					if (!empty($row['limitmemberlevels']) || $row['limitmemberlevels'] == '0') {
						$level1 = pdo_fetchall('select * from ' . tablename('ewei_shop_member_level') . ' where uniacid=:uniacid and  id in (' . $coupon['limitmemberlevels'] . ') ', array(':uniacid' => $_W['uniacid']));

						if (in_array($member['level'], $limitmemberlevels)) {
							$p = 1;
						}
					}

					if ((!empty($coupon['limitagentlevels']) || $coupon['limitagentlevels'] == '0') && $hascommission) {
						$level2 = pdo_fetchall('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id  in (' . $coupon['limitagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['isagent'] == '1' && $member['status'] == '1') {
							if (in_array($member['agentlevel'], $limitagentlevels)) {
								$p = 1;
							}
						}
					}

					if ((!empty($coupon['limitpartnerlevels']) || $coupon['limitpartnerlevels'] == '0') && $hasglobonus) {
						$level3 = pdo_fetchall('select * from ' . tablename('ewei_shop_globonus_level') . ' where uniacid=:uniacid and  id in(' . $coupon['limitpartnerlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['ispartner'] == '1' && $member['partnerstatus'] == '1') {
							if (in_array($member['partnerlevel'], $limitpartnerlevels)) {
								$p = 1;
							}
						}
					}

					if ((!empty($coupon['limitaagentlevels']) || $coupon['limitaagentlevels'] == '0') && $hasabonus) {
						$level4 = pdo_fetchall('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid and  id in (' . $coupon['limitaagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['isaagent'] == '1' && $member['aagentstatus'] == '1') {
							if (in_array($member['aagentlevel'], $limitaagentlevels)) {
								$p = 1;
							}
						}
					}
				}
				else {
					$p = 1;
				}

				if ($p == 1) {
					$p = 0;
					$limitcateids = explode(',', $row['limitgoodcateids']);
					$limitgoodids = explode(',', $row['limitgoodids']);
					if ($row['limitgoodcatetype'] == 0 && $row['limitgoodtype'] == 0) {
						$p = 1;
					}

					if ($row['limitgoodcatetype'] == 1) {
						$result = array_intersect($cates, $limitcateids);

						if (0 < count($result)) {
							$p = 1;
						}
					}

					if ($row['limitgoodtype'] == 1) {
						$isin = in_array($good['id'], $limitgoodids);

						if ($isin) {
							$p = 1;
						}
					}

					if ($p == 0) {
						unset($list[$key]);
					}
				}
				else {
					unset($list[$key]);
				}
			}

			unset($row);
		}

		return app_json(array('list' => array_values($list)));
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$id = intval($_GPC['id']);
		$goodsdetail = intval($_GPC['goodsdetail']);
		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$coupon = com('coupon')->setCoupon($coupon, time());

		if (empty($coupon['gettype'])) {
			return app_error(AppError::$CouponCanNotBuy, '??????' . $coupon['gettypestr']);
		}

		if ($coupon['total'] != -1 && $coupon['total'] <= 0) {
			return app_error(AppError::$CouponCanNotBuy, '?????????????????????');
		}

		if (!$coupon['canget']) {
			return app_error(AppError::$CouponCanNotBuy, '????????????' . $coupon['gettypestr'] . '????????????');
		}

		if ($goodsdetail) {
			if (0 < $coupon['money'] || 0 < $coupon['credit']) {
				return app_error(AppError::$CouponCanNotBuy, '??????????????????????????????????????????');
			}
		}
		else {
			if (0 < $coupon['credit']) {
				$credit = $this->member['credit1'];

				if ($credit < intval($coupon['credit'])) {
					return app_error(AppError::$CouponCanNotBuy, '???????????????????????????' . $coupon['gettypestr'] . '!');
				}
			}

			$needpay = false;

			if (0 < $coupon['money']) {
				pdo_delete('ewei_shop_coupon_log', array('couponid' => $id, 'openid' => $openid, 'status' => 0, 'paystatus' => 0));
				$needpay = true;
				$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_coupon_log') . ' where couponid=:couponid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':couponid' => $id, ':openid' => $openid, ':uniacid' => $_W['uniacid']));

				if (!empty($lastlog)) {
					return app_json(array('logid' => $lastlog['id']));
				}
			}
			else {
				pdo_delete('ewei_shop_coupon_log', array('couponid' => $id, 'openid' => $openid, 'status' => 0));
			}
		}

		$logno = m('common')->createNO('coupon_log', 'logno', 'CC');
		$log = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $openid, 'logno' => $logno, 'couponid' => $id, 'status' => 0, 'paystatus' => 0 < $coupon['money'] ? 0 : -1, 'creditstatus' => 0 < $coupon['credit'] ? 0 : -1, 'createtime' => time(), 'getfrom' => 1);
		pdo_insert('ewei_shop_coupon_log', $log);
		$logid = pdo_insertid();

		if ($goodsdetail) {
			$result = com('coupon')->payResult($log['logno']);

			if (is_error($result)) {
				return app_error(AppError::$CouponCanNotBuy, $result['message']);
			}

			return app_json(array('url' => $result['url'], 'dataid' => $result['dataid'], 'coupontype' => $result['coupontype']));
		}

		if ($needpay) {
			$useweixin = true;

			if (!empty($coupon['usecredit2'])) {
				$money = $this->member['credit2'];

				if ($coupon['money'] <= $money) {
					$useweixin = false;
				}
			}

			pdo_update('ewei_shop_coupon_log', array('paytype' => $useweixin ? 1 : 0), array('id' => $logid));
			$set = m('common')->getSysset();

			if ($useweixin) {
				$wechat = array('success' => 0);

				if (!empty($set['pay']['wxapp'])) {
					$payinfo = array('openid' => $openid, 'title' => $set['shop']['name'] . '?????????????????????:' . $log['logno'], 'tid' => $log['logno'], 'fee' => $coupon['money']);
					$res = $this->model->wxpay($payinfo, 16);

					if (!is_error($res)) {
						$wechat = array('success' => true, 'payinfo' => $res);
						return app_json(array('logid' => $logid, 'wechat' => $wechat));
					}

					return app_error(AppError::$WxPayParamsError);
				}

				return app_error(AppError::$WxPayNotOpen, '?????????????????????');
			}
		}

		return app_json(array('logid' => $logid));
	}

	public function payresult($a = array())
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);

		if (empty($logid)) {
			return app_error(AppError::$ParamsError);
		}

		$log = pdo_fetch('select id,logno,status,paystatus,couponid from ' . tablename('ewei_shop_coupon_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			return app_error(AppError::$CouponRecordNotFound);
		}

		$coupon = com('coupon')->getCoupon($log['couponid']);
		if (!empty($coupon['usecredit2']) || $coupon['money'] <= 0) {
			$result = com('coupon')->payResult($log['logno']);

			if (is_error($result)) {
				return app_error(AppError::$CouponBuyError, $result['message']);
			}
		}
		else {
			if (empty($log['paystatus'])) {
				return app_error(AppError::$CouponBuyError, '???????????????');
			}
		}

		$confirm_text = '';

		if ($result['coupontype'] == 1) {
			$confirm_text = '?????????????????????????????????????????????????????????????';
		}
		else if ($result['coupontype'] == 2) {
			$confirm_text = '???????????????????????????????????????';
		}
		else {
			$confirm_text = '??????????????????????????????';
		}

		return app_json(array('dataid' => $result['dataid'], 'coupontype' => $result['coupontype'], 'confirm_text' => $confirm_text));
	}

	public function getCouponCate()
	{
		global $_W;
		$merchdata = $this->merchData();
		extract($merchdata);
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid';

		if ($is_openmerch == 0) {
			$sql .= ' and merchid=0';
		}
		else {
			if (!empty($_GPC['merchid'])) {
				$sql .= ' and merchid=:merchid';
				$param[':merchid'] = intval($_GPC['merchid']);
			}
		}

		$sql .= ' and status=1 order by displayorder desc';
		$category = pdo_fetchall($sql, $param);
		return app_json(array('list' => $category));
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$merchdata = $this->merchData();
		extract($merchdata);
		$cateid = trim($_GPC['cateid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,timelimit,coupontype,timedays,timestart,timeend,thumb,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax,merchid,total as t,tagtitle,settitlecolor,titlecolor from ' . tablename('ewei_shop_coupon') . ' c ';
		$sql .= ' where uniacid=:uniacid';

		if ($is_openmerch == 0) {
			$sql .= ' and merchid=0';
		}
		else {
			if (!empty($_GPC['merchid'])) {
				$sql .= ' and merchid=:merchid';
				$param[':merchid'] = intval($_GPC['merchid']);
			}
		}

		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();

			if (empty($plugin_com_set['level'])) {
				$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
		}

		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();

			if (empty($plugin_globonus_set['open'])) {
				$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
		}

		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();

			if (empty($plugin_abonus_set['open'])) {
				$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
		}

		$sql .= ' and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))';

		if (!empty($cateid)) {
			$sql .= ' and catid=' . $cateid;
		}

		$total = pdo_fetchcolumn($sql, $param);
		$sql .= ' order by displayorder desc, id desc  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$coupons = set_medias(pdo_fetchall($sql, $param), 'thumb');

		if (empty($coupons)) {
			$coupons = array();
		}

		$newCoupons = array();

		foreach ($coupons as $i => &$row) {
			$row = com('coupon')->setCoupon($row, $time);
			$last = com('coupon')->get_last_count($row['id']);

			if ($row['t'] != -1) {
				if ($last <= 0) {
					$row['last'] = $last;
					$row['isdisa'] = '1';
					$row['color'] = 'disa';
				}
				else {
					$totle = $row['t'];
					$row['last'] = $last;
					$row['lastratio'] = intval($last / $totle * 100);
				}
			}
			else {
				$row['last'] = 1;
				$row['lastratio'] = 100;
			}

			$title2 = '';
			$tagtitle = '';

			if ($row['coupontype'] == '0') {
				if (0 < $row['enough']) {
					$title2 = '???' . (double) $row['enough'] . '?????????';
				}
				else {
					$title2 = '???????????????';
				}
			}
			else {
				if ($row['coupontype'] == '1') {
					if (0 < $row['enough']) {
						$title2 = '?????????' . (double) $row['enough'] . '?????????';
					}
					else {
						$title2 = '???????????????';
					}
				}
			}

			if ($row['coupontype'] == '2') {
				if (0 < $row['enough']) {
					$title2 = '???' . (double) $row['enough'] . '?????????';
				}
				else {
					$title2 = '???????????????';
				}
			}

			if ($row['backtype'] == 0) {
				if ($row['enough'] == '0') {
					$row['color'] = 'org ';
					$tagtitle = '?????????';
				}
				else {
					$row['color'] = 'blue';
					$tagtitle = '?????????';
				}
			}

			if ($row['backtype'] == 1) {
				$row['color'] = 'red ';
				$tagtitle = '?????????';
			}

			if ($row['backtype'] == 2) {
				if ($row['coupontype'] == '0') {
					$row['color'] = 'red ';
					$tagtitle = '???????????????';
				}
				else if ($row['coupontype'] == '1') {
					$row['color'] = 'pink ';
					$tagtitle = '???????????????';
				}
				else {
					if ($row['coupontype'] == '2') {
						$row['color'] = 'red ';
						$tagtitle = '???????????????';
					}
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			$newCoupon = array('id' => $row['id'], 'isdisa' => $row['isdisa'], 'color' => trim($row['color']), 'thumb' => $row['thumb'], 'couponname' => $row['couponname'], 'tagtitle' => $row['tagtitle'], 'backtype' => $row['backtype'], 'deduct' => $row['deduct'], 'discount' => (double) $row['discount'], 'backmoney' => $row['backmoney'], 'backcredit' => $row['backcredit'], 'backredpack' => $row['backredpack'], 'timestr' => $row['timestr'], 'gettypestr' => $row['gettypestr'], 'lastratio' => $row['lastratio'], 'title2' => $title2, 'settitlecolor' => $row['settitlecolor'], 'titlecolor' => $row['titlecolor'], 'iconurl' => $row['isdisa'] ? $_W['siteroot'] . 'template/mobile/default/static/images/coupon/end.png' : '');

			if ($row['timestr'] == '0') {
				$newCoupon['usestr'] = '????????????';
			}
			else if ($row['timestr'] == '1') {
				$newCoupon['usestr'] = '???' . $row['gettypestr'] . '?????? ' . $row['timedays'] . ' ?????????';
			}
			else {
				$newCoupon['usestr'] = '????????? ' . $row['timestr'];
			}

			$newCoupons[] = $newCoupon;
		}

		unset($row);
		return app_json(array('list' => $newCoupons, 'pagesize' => $psize, 'total' => $total));
	}

	public function getdetail()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			return app_error(AppError::$CouponNotFound);
		}

		$coupon = com('coupon')->setCoupon($coupon, time());
		$title2 = '';
		$title3 = '';

		if ($coupon['coupontype'] == '0') {
			if (0 < $coupon['enough']) {
				$title2 = '???' . (double) $coupon['enough'] . '???';
			}
			else {
				$title2 = '??????????????????';
			}
		}
		else {
			if ($coupon['coupontype'] == '1') {
				if (0 < $coupon['enough']) {
					$title2 = '?????????' . (double) $coupon['enough'] . '???';
				}
				else {
					$title2 = '??????????????????';
				}
			}
		}

		if ($coupon['coupontype'] == '2') {
			if (0 < $coupon['enough']) {
				$title2 = '???' . (double) $coupon['enough'] . '???';
			}
			else {
				$title2 = '??????????????????';
			}
		}

		if ($coupon['backtype'] == 0) {
			if ($coupon['enough'] == '0') {
				$coupon['color'] = 'org ';
			}
			else {
				$coupon['color'] = 'blue';
			}

			$title3 = '???' . (double) $coupon['deduct'] . '???';
		}

		if ($coupon['backtype'] == 1) {
			$coupon['color'] = 'red ';
			$title3 = '???' . (double) $coupon['discount'] . '??? ';
		}

		if ($coupon['backtype'] == 2) {
			if ($coupon['coupontype'] == '0') {
				$coupon['color'] = 'red ';
			}
			else {
				$coupon['color'] = 'pink ';
			}

			if (!empty($coupon['backmoney']) && 0 < $coupon['backmoney']) {
				$title3 = $title3 . '???' . $coupon['backmoney'] . '????????? ';
			}

			if (!empty($coupon['backcredit']) && 0 < $coupon['backcredit']) {
				$title3 = $title3 . '???' . $coupon['backcredit'] . '?????? ';
			}

			if (!empty($coupon['backredpack']) && 0 < $coupon['backredpack']) {
				$title3 = $title3 . '???' . $coupon['backredpack'] . '?????????';
			}
		}

		$coupon['title2'] = $title2;
		$coupon['title3'] = $title3;
		$goods = array();
		$category = array();

		if ($coupon['limitgoodtype'] != 0) {
			if (!empty($coupon['limitgoodids'])) {
				$where = 'and id in(' . $coupon['limitgoodids'] . ')';
			}

			$goods = pdo_fetchall('select `title` from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid ' . $where, array(':uniacid' => $_W['uniacid']), 'id');
		}

		if ($coupon['limitgoodcatetype'] != 0) {
			if (!empty($coupon['limitgoodcateids'])) {
				$where = 'and id in(' . $coupon['limitgoodcateids'] . ')';
			}

			$category = pdo_fetchall('select `name`  from ' . tablename('ewei_shop_category') . ' where uniacid=:uniacid   ' . $where, array(':uniacid' => $_W['uniacid']), 'id');
		}

		$limitmemberlevels = explode(',', $coupon['limitmemberlevels']);
		$limitagentlevels = explode(',', $coupon['limitagentlevels']);
		$limitpartnerlevels = explode(',', $coupon['limitpartnerlevels']);
		$limitaagentlevels = explode(',', $coupon['limitaagentlevels']);
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$leveltitle2 = $plugin_com_set['texts']['agent'];
			$hascommission = !empty($plugin_com_set['level']);

			if (in_array('0', $limitagentlevels)) {
				$commissionname = empty($plugin_com_set['levelname']) ? '????????????' : $plugin_com_set['levelname'];
			}
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$leveltitle3 = $plugin_globonus_set['texts']['partner'];
			$hasglobonus = !empty($plugin_globonus_set['open']);

			if (in_array('0', $limitpartnerlevels)) {
				$globonuname = empty($plugin_globonus_set['levelname']) ? '????????????' : $plugin_globonus_set['levelname'];
			}
		}

		$hasabonus = false;
		$abonu = '';
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$leveltitle4 = $plugin_abonus_set['texts']['aagent'];
			$hasabonus = !empty($plugin_abonus_set['open']);

			if (in_array('0', $limitaagentlevels)) {
				$abonuname = empty($plugin_abonus_set['levelname']) ? '????????????' : $plugin_abonus_set['levelname'];
			}
		}

		$pass = false;

		if ($coupon['islimitlevel'] == 1) {
			$openid = trim($_W['openid']);
			$member = m('member')->getMember($openid);
			if (!empty($coupon['limitmemberlevels']) || $coupon['limitmemberlevels'] == '0') {
				$shop = $_W['shopset']['shop'];

				if (in_array('0', $limitmemberlevels)) {
					$meblvname = empty($shop['levelname']) ? '????????????' : $shop['levelname'];
				}

				$level1 = pdo_fetchall('select * from ' . tablename('ewei_shop_member_level') . ' where uniacid=:uniacid and  id in (' . $coupon['limitmemberlevels'] . ') ', array(':uniacid' => $_W['uniacid']));

				if (in_array($member['level'], $limitmemberlevels)) {
					$pass = true;
				}
			}

			if ((!empty($coupon['limitagentlevels']) || $coupon['limitagentlevels'] == '0') && $hascommission) {
				$level2 = pdo_fetchall('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id  in (' . $coupon['limitagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
				if ($member['isagent'] == '1' && $member['status'] == '1') {
					if (in_array($member['agentlevel'], $limitagentlevels)) {
						$pass = true;
					}
				}
			}

			if ((!empty($coupon['limitpartnerlevels']) || $coupon['limitpartnerlevels'] == '0') && $hasglobonus) {
				$level3 = pdo_fetchall('select * from ' . tablename('ewei_shop_globonus_level') . ' where uniacid=:uniacid and  id in(' . $coupon['limitpartnerlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
				if ($member['ispartner'] == '1' && $member['partnerstatus'] == '1') {
					if (in_array($member['partnerlevel'], $limitpartnerlevels)) {
						$pass = true;
					}
				}
			}

			if ((!empty($coupon['limitaagentlevels']) || $coupon['limitaagentlevels'] == '0') && $hasabonus) {
				$level4 = pdo_fetchall('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid and  id in (' . $coupon['limitaagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
				if ($member['isaagent'] == '1' && $member['aagentstatus'] == '1') {
					if (in_array($member['aagentlevel'], $limitaagentlevels)) {
						$pass = true;
					}
				}
			}
		}
		else {
			$pass = true;
		}

		$set = m('common')->getPluginset('coupon');
		$detail = array('name' => $coupon['couponname'], 'merchstr' => $coupon['merchname'] ? '??????' . $coupon['merchname'] . '????????????' : '', 'money' => $coupon['money'], 'credit' => $coupon['credit'], 'title2' => $coupon['title2'], 'title3' => $coupon['title3'], 'color' => $coupon['color'], 'gettypestr' => $coupon['gettypestr'], 'coupontype' => $coupon['coupontype'], 'limitdiscounttype' => $coupon['limitdiscounttype'], 'limitgoodtype' => $coupon['limitgoodtype'], 'limitgoodcatetype' => $coupon['limitgoodcatetype'], 'limitgoods' => $goods, 'limitcates' => $category, 'islimitlevel' => $coupon['islimitlevel']);

		if (!empty($coupon['islimitlevel'])) {
			if (!empty($coupon['limitmemberlevels']) || $coupon['limitmemberlevels'] === '0') {
				$detail['limitmemberlevels'] = '??????: ';

				foreach ($level1 as $l1) {
					$detail['limitmemberlevels'] .= ' ' . $l1['levelname'];
				}
			}

			if ((!empty($coupon['limitagentlevels']) || $coupon['limitagentlevels'] === '0') && $hascommission) {
				$detail['limitagentlevels'] = $leveltitle2 . ': ';

				if (in_array('0', $limitagentlevels)) {
					$detail['limitagentlevels'] .= $commissionname;
				}

				foreach ($level2 as $l2) {
					$detail['limitagentlevels'] .= ' ' . $l2['levelname'];
				}
			}

			if ((!empty($coupon['limitpartnerlevels']) || $coupon['limitpartnerlevels'] === '0') && $hasglobonus) {
				$detail['limitpartnerlevels'] = $leveltitle3 . ': ' . $globonuname;

				foreach ($level3 as $l3) {
					$detail['limitpartnerlevels'] .= ' ' . $l3['levelname'];
				}
			}

			if ((!empty($coupon['limitaagentlevels']) || $coupon['limitaagentlevels'] === '0') && $hasabonus) {
				$detail['limitaagentlevels'] = $leveltitle4 . ': ' . $abonuname;

				foreach ($level4 as $l4) {
					$coupon['limitpartnerlevels'] .= ' ' . $l4['levelname'];
				}
			}
		}

		if ($coupon['timestr'] == '0') {
			$detail['usestr'] = '????????????';
		}
		else if ($coupon['timestr'] == '1') {
			$detail['usestr'] = '???' . $coupon['gettypestr'] . '?????? ' . $coupon['timedays'] . ' ?????????';
		}
		else {
			$detail['usestr'] = '????????? ' . $coupon['timestr'];
		}

		if (!$coupon['canget']) {
			$detail['getstr'] = '?????????' . $coupon['gettypestr'] . '??????';
			$detail['canget'] = 0;
		}
		else if ($pass) {
			$detail['getstr'] = '??????' . $coupon['gettypestr'];
			$detail['canget'] = 1;
		}
		else {
			$detail['getstr'] = '?????????' . $coupon['gettypestr'] . '??????';
			$detail['canget'] = -1;
		}

		if ($coupon['descnoset'] == '0') {
			if ($coupon['coupontype'] == '0') {
				$detail['desc'] = htmlspecialchars_decode($set['consumedesc']);
			}
			else if ($coupon['coupontype'] == '1') {
				$detail['desc'] = htmlspecialchars_decode($set['rechargedesc']);
			}
			else {
				$detail['desc'] = htmlspecialchars_decode($set['consumedesc']);
			}
		}
		else {
			$detail['desc'] = $coupon['desc'];
		}

		return app_json(array('detail' => $detail));
	}
}

?>
