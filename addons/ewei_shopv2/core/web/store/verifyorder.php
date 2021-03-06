<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Verifyorder_EweiShopV2Page extends WebPage
{
	protected function orderData()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' o.uniacid = :uniacid and o.ismr=0 and o.deleted=0 and o.isparent=0';
		$leftsql = '';
		$uniacid = $_W['uniacid'];
		$paras = array(':uniacid' => $uniacid);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$searchtime = trim($_GPC['searchtime']);
		if (!empty($searchtime) && is_array($_GPC['time']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);

			if ($searchtime == 'finish') {
				$condition .= ' And ((vgl.verifydate >= :starttime And vgl.verifydate <= :endtime) or (o.verifytime >= :starttime And o.verifytime <= :endtime)) ';
			}
			else {
				$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
			}

			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
		}

		if ($_GPC['searchtype'] != '') {
			if ($_GPC['searchtype'] == 'store') {
				$condition .= ' AND ( o.storeid <> 0  and o.istrade=0  and o.isnewstore=1) ';
			}
			else if ($_GPC['searchtype'] == 'mall') {
				$condition .= ' AND ((o.isnewstore=0 and  o.isverify=1)||(o.isnewstore=0 and addressid=0)) ';
			}
			else if ($_GPC['searchtype'] == 'trade') {
				$condition .= ' AND ( o.storeid <> 0  and  o.istrade=1 and o.isnewstore=1) ';
			}
			else {
				if ($_GPC['searchtype'] == 'all') {
					$condition .= '  and (o.isverify=1 or o.istrade=1)';
				}
			}
		}
		else {
			$condition .= '  and (o.isverify=1 or o.istrade=1)';
		}

		if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
			$searchfield = trim(strtolower($_GPC['searchfield']));
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$paras[':keyword'] = htmlspecialchars_decode($_GPC['keyword'], ENT_QUOTES);
			$sqlcondition = '';

			if ($searchfield == 'ordersn') {
				$condition .= ' AND locate(:keyword,o.ordersn)>0';
			}
			else if ($searchfield == 'member') {
				$condition .= ' AND (locate(:keyword,m.realname)>0 or locate(:keyword,m.mobile)>0 or locate(:keyword,m.nickname)>0)';
			}
			else if ($searchfield == 'address') {
				$condition .= ' AND ( locate(:keyword,a.realname)>0 or locate(:keyword,a.mobile)>0 or locate(:keyword,o.carrier)>0)';
			}
			else if ($searchfield == 'expresssn') {
				$condition .= ' AND locate(:keyword,o.expresssn)>0';
			}
			else if ($searchfield == 'saler') {
				if (p('merch')) {
					$leftsql .= ' left join ' . tablename('ewei_shop_merch_saler') . ' ms on (ms.id = vgl.salerid or ms.id=vol.salerid or ms.openid=o.verifyopenid) and ms.uniacid=o.uniacid and o.ismerch=1';
					$condition .= ' AND (locate(:keyword,sm.realname)>0 or locate(:keyword,sm.mobile)>0 or locate(:keyword,sm.nickname)>0 or locate(:keyword,s.salername)>0 or locate(:keyword,ms.salername)>0 )';
				}
				else {
					$condition .= ' AND (locate(:keyword,sm.realname)>0 or locate(:keyword,sm.mobile)>0 or locate(:keyword,sm.nickname)>0 or locate(:keyword,s.salername)>0)';
				}
			}
			else if ($searchfield == 'verifycode') {
				$condition .= ' AND (verifycode=:keyword or locate(:keyword,o.verifycodes)>0)';
			}
			else if ($searchfield == 'store') {
				if (p('merch')) {
					$leftsql .= ' left join ' . tablename('ewei_shop_merch_store') . ' mstore on  ( mstore.id = o.verifystoreid or store.id = vgl.storeid or store.id = vol.storeid ) and o.ismerch=1';
					$condition .= ' AND (locate(:keyword,store.storename)>0 or locate(:keyword,mstore.storename)>0)';
				}
				else {
					$condition .= ' AND (locate(:keyword,store.storename)>0)';
				}
			}
			else if ($searchfield == 'goodstitle') {
				$sqlcondition = ' inner join ( select DISTINCT(og.orderid) from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,g.title)>0)) gs on gs.orderid=o.id');
			}
			else {
				if ($searchfield == 'goodssn') {
					$sqlcondition = ' inner join ( select DISTINCT(og.orderid) from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (((locate(:keyword,g.goodssn)>0)) or (locate(:keyword,og.goodssn)>0))) gs on gs.orderid=o.id');
				}
			}
		}

		$authorid = intval($_GPC['authorid']);
		$author = p('author');
		if ($author && !empty($authorid)) {
			$condition .= ' and o.authorid = :authorid';
			$paras[':authorid'] = $authorid;
		}

		$field = '';

		if ($searchtime == 'finish') {
			$field = ',vgl.verifydate';
		}

		$sql = 'select distinct o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea, a.street as astreet,a.address as aaddress,
                  d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername,
                  r.rtype,r.status as rstatus,o.sendtype,store.storename' . $field . ' from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.orderid = o.id' . ' left join ' . tablename('ewei_shop_verifygoods_log') . ' vgl on vgl.verifygoodsid = vg.id' . ' left join ' . tablename('ewei_shop_verifyorder_log') . ' vol on vol.orderid=o.id ' . ' left join ' . tablename('ewei_shop_saler') . ' s on (s.id = vgl.salerid or s.id=vol.salerid or s.openid=o.verifyopenid) and s.uniacid=o.uniacid and o.ismerch=0' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . ' left join ' . tablename('ewei_shop_store') . ' store on ( store.id = vgl.storeid or store.id = vol.storeid or store.id=o.verifystoreid) and o.ismerch=0' . $leftsql . (' ' . $sqlcondition . ' where ' . $condition . ' AND o.status =3 GROUP BY o.id ORDER BY o.createtime DESC  ');

		if (empty($_GPC['export'])) {
			$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $paras);
		$paytype = array(
			1  => array('css' => 'danger', 'name' => '????????????'),
			11 => array('css' => 'default', 'name' => '????????????'),
			2  => array('css' => 'danger', 'name' => '????????????'),
			21 => array('css' => 'success', 'name' => '????????????'),
			22 => array('css' => 'warning', 'name' => '???????????????'),
			23 => array('css' => 'warning', 'name' => '????????????'),
			3  => array('css' => 'primary', 'name' => '????????????')
		);
		$orderstatus = array(
			-1 => array('css' => 'default', 'name' => '?????????'),
			0  => array('css' => 'danger', 'name' => '?????????'),
			1  => array('css' => 'info', 'name' => '?????????'),
			2  => array('css' => 'warning', 'name' => '?????????'),
			3  => array('css' => 'success', 'name' => '?????????')
		);

		if (!empty($list)) {
			$diy_title_data = array();
			$diy_data = array();

			foreach ($list as &$value) {
				$s = $value['status'];
				$pt = $value['paytype'];
				$value['statusvalue'] = $s;
				$value['statuscss'] = $orderstatus[$value['status']]['css'];
				$value['status'] = $orderstatus[$value['status']]['name'];
				if ($pt == 3 && empty($value['statusvalue'])) {
					$value['statuscss'] = $orderstatus[1]['css'];
					$value['status'] = $orderstatus[1]['name'];
				}

				if ($s == 1) {
					if ($value['isverify'] == 1) {
						$value['status'] = '?????????';

						if (0 < $value['sendtype']) {
							$value['status'] = '????????????';
						}
					}
					else if (empty($value['addressid'])) {
						$value['status'] = '?????????';
					}
					else {
						if (0 < $value['sendtype']) {
							$value['status'] = '????????????';
						}
					}
				}

				if ($s == -1) {
					if (!empty($value['refundtime'])) {
						$value['status'] = '?????????';
					}
				}

				$value['paytypevalue'] = $pt;
				$value['css'] = $paytype[$pt]['css'];
				$value['paytype'] = $paytype[$pt]['name'];
				$value['dispatchname'] = empty($value['addressid']) ? '??????' : $value['dispatchname'];

				if (empty($value['dispatchname'])) {
					$value['dispatchname'] = '??????';
				}

				if ($pt == 3) {
					$value['dispatchname'] = '????????????';
				}
				else if ($value['isverify'] == 1) {
					$value['dispatchname'] = '????????????';
				}
				else if ($value['isvirtual'] == 1) {
					$value['dispatchname'] = '????????????';
				}
				else {
					if (!empty($value['virtual'])) {
						$value['dispatchname'] = '????????????(??????)<br/>????????????';
					}
				}

				if ($value['dispatchtype'] == 1 || !empty($value['isverify']) || !empty($value['virtual']) || !empty($value['isvirtual'])) {
					$value['address'] = '';
					$carrier = iunserializer($value['carrier']);

					if (is_array($carrier)) {
						$value['addressdata']['realname'] = $value['realname'] = $carrier['carrier_realname'];
						$value['addressdata']['mobile'] = $value['mobile'] = $carrier['carrier_mobile'];
					}
				}
				else {
					$address = iunserializer($value['address']);
					$isarray = is_array($address);
					$value['realname'] = $isarray ? $address['realname'] : $value['arealname'];
					$value['mobile'] = $isarray ? $address['mobile'] : $value['amobile'];
					$value['province'] = $isarray ? $address['province'] : $value['aprovince'];
					$value['city'] = $isarray ? $address['city'] : $value['acity'];
					$value['area'] = $isarray ? $address['area'] : $value['aarea'];
					$value['street'] = $isarray ? $address['street'] : $value['astreet'];
					$value['address'] = $isarray ? $address['address'] : $value['aaddress'];
					$value['address_province'] = $value['province'];
					$value['address_city'] = $value['city'];
					$value['address_area'] = $value['area'];
					$value['address_street'] = $value['street'];
					$value['address_address'] = $value['address'];
					$value['address'] = $value['province'] . ' ' . $value['city'] . ' ' . $value['area'] . ' ' . $value['address'];
					$value['addressdata'] = array('realname' => $value['realname'], 'mobile' => $value['mobile'], 'address' => $value['address']);
				}

				if (!empty($agentid)) {
					$magent = m('member')->getMember($agentid);
				}

				$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,
                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,
                    og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $uniacid, ':orderid' => $value['id']));
				$goods = '';

				foreach ($order_goods as &$og) {
					$og['seckill_task'] = false;
					$og['seckill_room'] = false;

					if ($og['seckill']) {
						$og['seckill_task'] = plugin_run('seckill::getTaskInfo', $og['seckill_taskid']);
						$og['seckill_room'] = plugin_run('seckill::getRoomInfo', $og['seckill_taskid'], $og['seckill_roomid']);
					}

					if (!empty($og['specs'])) {
						$thumb = m('goods')->getSpecThumb($og['specs']);

						if (!empty($thumb)) {
							$og['thumb'] = $thumb;
						}
					}

					$goods .= '' . $og['title'] . '
';

					if (!empty($og['optiontitle'])) {
						$goods .= ' ??????: ' . $og['optiontitle'];
					}

					if (!empty($og['option_goodssn'])) {
						$og['goodssn'] = $og['option_goodssn'];
					}

					if (!empty($og['option_productsn'])) {
						$og['productsn'] = $og['option_productsn'];
					}

					if (!empty($og['goodssn'])) {
						$goods .= ' ????????????: ' . $og['goodssn'];
					}

					if (!empty($og['productsn'])) {
						$goods .= ' ????????????: ' . $og['productsn'];
					}

					$goods .= ' ??????: ' . $og['price'] / $og['total'] . ' ?????????: ' . $og['realprice'] / $og['total'] . ' ??????: ' . $og['total'] . ' ??????: ' . $og['price'] . ' ?????????: ' . $og['realprice'] . '
 ';
					if (p('diyform') && !empty($og['diyformfields']) && !empty($og['diyformdata'])) {
						$diyformdata_array = p('diyform')->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']), 1);
						$diyformdata = '';
						$dflag = 1;

						foreach ($diyformdata_array as $da) {
							if (!empty($diy_title_data)) {
								if (array_key_exists($da['key'], $diy_title_data)) {
									$dflag = 0;
								}
							}

							if ($dflag == 1) {
								$diy_title_data[$da['key']] = $da['name'];
							}

							$og['goods_' . $da['key']] = $da['value'];
							$diyformdata .= $da['name'] . ': ' . $da['value'] . ' 
';
						}

						$og['goods_diyformdata'] = $diyformdata;
					}
				}

				unset($og);
				$value['goods'] = set_medias($order_goods, 'thumb');
				$value['goods_str'] = $goods;
			}
		}

		unset($value);
		set_time_limit(0);

		if ($_GPC['export'] == 1) {
			plog('order.op.export', '????????????');
			$columns = array(
				array('title' => '????????????', 'field' => 'ordersn', 'width' => 24),
				array('title' => '????????????', 'field' => 'nickname', 'width' => 12),
				array('title' => '????????????', 'field' => 'mrealname', 'width' => 12),
				array('title' => 'openid', 'field' => 'openid', 'width' => 24),
				array('title' => '?????????????????????', 'field' => 'mmobile', 'width' => 12),
				array('title' => '????????????(????????????)', 'field' => 'realname', 'width' => 12),
				array('title' => '????????????', 'field' => 'mobile', 'width' => 12),
				array('title' => '', 'field' => 'address_address', 'width' => 12),
				array('title' => '????????????', 'field' => 'goods_title', 'width' => 24),
				array('title' => '????????????', 'field' => 'goods_goodssn', 'width' => 12),
				array('title' => '????????????', 'field' => 'goods_optiontitle', 'width' => 12),
				array('title' => '????????????', 'field' => 'goods_total', 'width' => 12),
				array('title' => '????????????(?????????)', 'field' => 'goods_price1', 'width' => 12),
				array('title' => '????????????(?????????)', 'field' => 'goods_price2', 'width' => 12),
				array('title' => '????????????(?????????)', 'field' => 'goods_rprice1', 'width' => 12),
				array('title' => '????????????(?????????)', 'field' => 'goods_rprice2', 'width' => 12),
				array('title' => '????????????', 'field' => 'paytype', 'width' => 12),
				array('title' => '????????????', 'field' => 'dispatchname', 'width' => 12),
				array('title' => '????????????', 'field' => 'pickname', 'width' => 24),
				array('title' => '????????????', 'field' => 'goodsprice', 'width' => 12),
				array('title' => '??????', 'field' => 'dispatchprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'deductprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'deductcredit2', 'width' => 12),
				array('title' => '????????????', 'field' => 'deductenough', 'width' => 12),
				array('title' => '???????????????', 'field' => 'couponprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'changeprice', 'width' => 12),
				array('title' => '????????????', 'field' => 'changedispatchprice', 'width' => 12),
				array('title' => '?????????', 'field' => 'price', 'width' => 12),
				array('title' => '??????', 'field' => 'status', 'width' => 12),
				array('title' => '????????????', 'field' => 'createtime', 'width' => 24),
				array('title' => '????????????', 'field' => 'paytime', 'width' => 24),
				array('title' => '????????????', 'field' => 'sendtime', 'width' => 24),
				array('title' => '????????????', 'field' => 'finishtime', 'width' => 24),
				array('title' => '????????????', 'field' => 'remark', 'width' => 36),
				array('title' => '??????????????????', 'field' => 'remarksaler', 'width' => 36),
				array('title' => '?????????', 'field' => 'salerinfo', 'width' => 24),
				array('title' => '????????????', 'field' => 'storeinfo', 'width' => 36),
				array('title' => '?????????????????????', 'field' => 'order_diyformdata', 'width' => 36),
				array('title' => '?????????????????????', 'field' => 'goods_diyformdata', 'width' => 36)
			);

			if (!empty($diy_title_data)) {
				foreach ($diy_title_data as $key => $value) {
					$field = 'goods_' . $key;
					$columns[] = array('title' => $value . '(?????????????????????)', 'field' => $field, 'width' => 24);
				}
			}

			foreach ($list as &$row) {
				$row['realname'] = str_replace('=', '', $row['realname']);
				$row['nickname'] = str_replace('=', '', $row['nickname']);
				$row['ordersn'] = $row['ordersn'] . ' ';

				if (0 < $row['deductprice']) {
					$row['deductprice'] = '-' . $row['deductprice'];
				}

				if (0 < $row['deductcredit2']) {
					$row['deductcredit2'] = '-' . $row['deductcredit2'];
				}

				if (0 < $row['deductenough']) {
					$row['deductenough'] = '-' . $row['deductenough'];
				}

				if ($row['changeprice'] < 0) {
					$row['changeprice'] = '-' . $row['changeprice'];
				}
				else {
					if (0 < $row['changeprice']) {
						$row['changeprice'] = '+' . $row['changeprice'];
					}
				}

				if ($row['changedispatchprice'] < 0) {
					$row['changedispatchprice'] = '-' . $row['changedispatchprice'];
				}
				else {
					if (0 < $row['changedispatchprice']) {
						$row['changedispatchprice'] = '+' . $row['changedispatchprice'];
					}
				}

				if (0 < $row['couponprice']) {
					$row['couponprice'] = '-' . $row['couponprice'];
				}

				$row['nickname'] = strexists($row['nickname'], '^') ? '\'' . $row['nickname'] : $row['nickname'];
				$row['expresssn'] = $row['expresssn'] . ' ';
				$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
				$row['paytime'] = !empty($row['paytime']) ? date('Y-m-d H:i:s', $row['paytime']) : '';
				$row['sendtime'] = !empty($row['sendtime']) ? date('Y-m-d H:i:s', $row['sendtime']) : '';
				$row['finishtime'] = !empty($row['finishtime']) ? date('Y-m-d H:i:s', $row['finishtime']) : '';
				$row['salerinfo'] = '';
				$row['storeinfo'] = '';
				$row['pickname'] = '';
				if (!empty($row['verifyopenid']) && $row['verifytype'] == 0) {
					if (0 < $row['merchid']) {
						$row['storeinfo'] = '[' . pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid'])) . ']';
						$salermember = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_merch_saler') . ' s left join ' . tablename('ewei_shop_member') . (' m on m.openid=s.openid
                         WHERE s.openid=\'' . $row['verifyopenid'] . '\''));
						$row['salerinfo'] = '[' . $salermember['id'] . ']' . $salermember['salername'] . '(' . $salermember['nickname'] . ')';
					}
					else {
						$row['storeinfo'] = '[' . pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid'])) . ']';
						$salermember = pdo_fetch('SELECT s.id,s.salername,m.nickname FROM ' . tablename('ewei_shop_saler') . ' s left join ' . tablename('ewei_shop_member') . (' m on m.openid=s.openid
                         WHERE s.openid=\'' . $row['verifyopenid'] . '\''));
						$row['salerinfo'] = '[' . $salermember['id'] . ']' . $salermember['salername'] . '(' . $salermember['nickname'] . ')';
					}
				}
				else {
					$orderid = $row['id'];
					$ordersn = $row['ordersn'];

					if (strstr($ordersn, 'ME')) {
						if (!empty($row['verifyinfo'])) {
							$verifyinfo = iunserializer($row['verifyinfo']);

							if (!empty($verifyinfo)) {
								foreach ($verifyinfo as $k => $v) {
									$verifyopenid = $v['verifyopenid'];
									$verifystoreid = $v['verifystoreid'];

									if (!empty($verifyopenid)) {
										$verify_member = com('verify')->getSalerInfo($verifyopenid, $row['merchid']);
										$row['salerinfo'] .= '[' . $verify_member['salerid'] . ']' . $verify_member['salername'] . '(' . $verify_member['salernickname'] . ')';
										$verify_store = com('verify')->getStoreInfo($verifystoreid, $row['merchid']);
										$row['storeinfo'] .= '[' . $verify_store['storename'] . ']';
									}
								}
							}
						}
					}
					else {
						$sql = 'select s.storename,sa.salername,sa.id,m.nickname  from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
                             left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.id = vgl.verifygoodsid
                             left join ' . tablename('ewei_shop_store') . ' s  on s.id = vgl.storeid
                             left join ' . tablename('ewei_shop_saler') . ' sa  on sa.id = vgl.salerid
                             left join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
                             left join ' . tablename('ewei_shop_member') . ' m on m.openid = sa.openid
                             where  og.orderid=' . $orderid . ' ORDER BY vgl.verifydate DESC ';
						$res = pdo_fetchall($sql);

						foreach ($res as $k => $v) {
							$row['salerinfo'] .= '[' . $v['id'] . ']' . $v['salername'] . '(' . $v['nickname'] . ')';
							$row['storeinfo'] .= '[' . $v['storename'] . ']';
						}
					}
				}

				if (!empty($row['verifystoreid']) && $row['verifytype'] == 0) {
					if (0 < $row['merchid']) {
						$row['storeinfo'] = '[' . pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid'])) . ']';
					}
					else {
						$row['storeinfo'] = '[' . pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid'])) . ']';
					}
				}

				if (!empty($row['storeid'])) {
					if (0 < $row['merchid']) {
						$row['pickname'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['storeid']));
					}
					else {
						$row['pickname'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['storeid']));
					}
				}

				if (p('diyform') && !empty($row['diyformfields']) && !empty($row['diyformdata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diyformfields']), iunserializer($row['diyformdata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$row['order_diyformdata'] = $diyformdata;
				}
			}

			unset($row);
			$exportlist = array();

			foreach ($list as &$r) {
				$ogoods = $r['goods'];
				unset($r['goods']);

				foreach ($ogoods as $k => $g) {
					if (0 < $k) {
						$r['ordersn'] = '';
						$r['realname'] = '';
						$r['mobile'] = '';
						$r['openid'] = '';
						$r['nickname'] = '';
						$r['mrealname'] = '';
						$r['mmobile'] = '';
						$r['address'] = '';
						$r['address_province'] = '';
						$r['address_city'] = '';
						$r['address_area'] = '';
						$r['address_street'] = '';
						$r['address_address'] = '';
						$r['paytype'] = '';
						$r['dispatchname'] = '';
						$r['dispatchprice'] = '';
						$r['goodsprice'] = '';
						$r['status'] = '';
						$r['createtime'] = '';
						$r['sendtime'] = '';
						$r['finishtime'] = '';
						$r['expresscom'] = '';
						$r['expresssn'] = '';
						$r['deductprice'] = '';
						$r['deductcredit2'] = '';
						$r['deductenough'] = '';
						$r['changeprice'] = '';
						$r['changedispatchprice'] = '';
						$r['price'] = '';
						$r['order_diyformdata'] = '';
					}

					$r['goods_title'] = $g['title'];
					$r['goods_goodssn'] = $g['goodssn'];
					$r['goods_optiontitle'] = $g['optiontitle'];
					$r['goods_total'] = $g['total'];
					$r['goods_price1'] = $g['price'] / $g['total'];
					$r['goods_price2'] = $g['realprice'] / $g['total'];
					$r['goods_rprice1'] = $g['price'];
					$r['goods_rprice2'] = $g['realprice'];
					$r['goods_diyformdata'] = $g['goods_diyformdata'];

					foreach ($diy_title_data as $key => $value) {
						$field = 'goods_' . $key;
						$r[$field] = $g[$field];
					}

					$exportlist[] = $r;
				}
			}

			unset($r);
			m('excel')->export($exportlist, array('title' => '????????????-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		if ($searchfield == 'saler') {
			$t = pdo_fetch('SELECT COUNT(DISTINCT(o.id)) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.orderid = o.id' . ' left join ' . tablename('ewei_shop_verifygoods_log') . ' vgl on vgl.verifygoodsid = vg.id' . ' left join ' . tablename('ewei_shop_verifyorder_log') . ' vol on vol.orderid=o.id ' . ' left join ' . tablename('ewei_shop_saler') . ' s on (s.id = vgl.salerid or s.id=vol.salerid) and s.uniacid=o.uniacid and o.ismerch=0' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . $leftsql . (' ' . $sqlcondition . ' WHERE ' . $condition . ' AND o.status =3'), $paras);
		}
		else if ($searchfield == 'store') {
			$t = pdo_fetch('SELECT COUNT(DISTINCT(o.id)) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.orderid = o.id' . ' left join ' . tablename('ewei_shop_verifygoods_log') . ' vgl on vgl.verifygoodsid = vg.id' . ' left join ' . tablename('ewei_shop_verifyorder_log') . ' vol on vol.orderid=o.id ' . ' left join ' . tablename('ewei_shop_store') . ' store on ( store.id = vgl.storeid or store.id = vol.storeid ) and o.ismerch=0' . $leftsql . (' ' . $sqlcondition . ' WHERE ' . $condition . ' AND o.status =3'), $paras);
		}
		else {
			$t = pdo_fetch('SELECT COUNT(DISTINCT(o.id)) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_verifygoods') . ' vg on vg.orderid = o.id' . ' left join ' . tablename('ewei_shop_verifygoods_log') . ' vgl on vgl.verifygoodsid = vg.id' . ' left join ' . tablename('ewei_shop_verifyorder_log') . ' vol on vol.orderid=o.id ' . $leftsql . (' ' . $sqlcondition . ' WHERE ' . $condition . ' AND o.status =3'), $paras);
		}

		$total = $t['count'];
		$totalmoney = $t['sumprice'];
		$pager = pagination2($total, $pindex, $psize);
		$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_store') . ' where uniacid=:uniacid ', array(':uniacid' => $uniacid));
		$r_type = array('??????', '????????????', '??????');
		load()->func('tpl');
		include $this->template('store/verifyorder/log');
	}

	public function log()
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData();
	}
}

?>
