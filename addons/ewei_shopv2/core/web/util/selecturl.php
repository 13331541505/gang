<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selecturl_EweiShopV2Page extends WebPage
{
	protected $full = false;
	protected $platform = false;

	public function __construct()
	{
		global $_W;
		global $_GPC;
		$this->full = intval($_GPC['full']);
		$this->platform = trim($_GPC['platform']);
		$this->defaultUrl = trim($_GPC['url']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$syscate = m('common')->getSysset('category');
		if (isset($_GPC['type']) && !empty($_GPC['type'])) {
			$type = $_GPC['type'];
		}

		if (0 < $syscate['level']) {
			$categorys = pdo_fetchall('SELECT id,name,parentid FROM ' . tablename('ewei_shop_category') . ' WHERE enabled=:enabled and uniacid= :uniacid  ', array(':uniacid' => $_W['uniacid'], ':enabled' => '1'));
		}

		$groups = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_goods_group') . ' WHERE enabled=:enabled AND merchid = 0 AND  uniacid= :uniacid ', array(':uniacid' => $_W['uniacid'], ':enabled' => '1'));
		$storeList = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . ' WHERE status = 1 AND uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));

		if (p('diypage')) {
			if ($type == 'topmenu') {
				$diypage = p('diypage')->getPageList('allpage', ' and (`type` = 1 or `type` = 2)');

				if (!empty($diypage)) {
					foreach ($diypage['list'] as $k => $v) {
						$pages = json_decode(base64_decode($v['data']), true);

						foreach ($pages['items'] as $pk => $pv) {
							if ($pv['id'] == 'topmenu') {
								unset($diypage['list'][$k]);
							}
						}
					}
				}

				$allpagetype = p('diypage')->getPageType();
			}
			else {
				$diypage = p('diypage')->getPageList('allpage', ' and `type`<5');
				$allpagetype = p('diypage')->getPageType();
			}
		}

		$platform = $this->platform;

		if (p('quick')) {
			if ($platform == 'wxapp' || $platform == 'wxapp_tabbar') {
				$quickList = p('quick')->getPageList('', 1, ' status=1 and ');
			}
			else {
				$quickList = p('quick')->getPageList();
			}
		}

		if (p('friendcoupon')) {
			$activities = p('friendcoupon')->getActivityList();
		}

		$full = $this->full;
		if ($platform == 'wxapp' && !empty($this->defaultUrl) && strexists($this->defaultUrl, '/pages/web/index')) {
			$defaultUrl = urldecode($this->defaultUrl);
			$defaultUrl = str_replace('/pages/web/index?url=https://', '', $defaultUrl);
		}

		$allUrls = array(
			array(
				'name' => '????????????',
				'list' => array(
					array('name' => '????????????', 'url' => mobileUrl(NULL, NULL, $full), 'url_wxapp' => '/pages/index/index'),
					array('name' => '????????????', 'url' => mobileUrl('shop/category', NULL, $full), 'url_wxapp' => '/pages/shop/caregory/index'),
					array('name' => '????????????', 'url' => mobileUrl('goods', NULL, $full), 'url_wxapp' => '/pages/goods/index/index'),
					array('name' => '????????????', 'url' => mobileUrl('shop/notice', NULL, $full), 'url_wxapp' => '/pages/shop/notice/index/index'),
					array('name' => '?????????', 'url' => mobileUrl('member/cart', NULL, $full), 'url_wxapp' => '/pages/member/cart/index')
				)
			),
			array(
				'name' => '????????????',
				'list' => array(
					array('name' => '????????????', 'url' => mobileUrl('goods', array('isrecommand' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?isrecommand=1'),
					array('name' => '????????????', 'url' => mobileUrl('goods', array('isnew' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?isnew=1'),
					array('name' => '????????????', 'url' => mobileUrl('goods', array('ishot' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?ishot=1'),
					array('name' => '????????????', 'url' => mobileUrl('goods', array('isdiscount' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?isdiscount=1'),
					array('name' => '????????????', 'url' => mobileUrl('goods', array('issendfree' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?issendfree=1'),
					array('name' => '????????????', 'url' => mobileUrl('goods', array('istime' => 1), $full), 'url_wxapp' => '/pages/goods/index/index?istime=1')
				)
			),
			array(
				'name' => '????????????',
				'list' => array(
					0  => array('name' => '????????????', 'url' => mobileUrl('member', NULL, $full), 'url_wxapp' => '/pages/member/index/index'),
					1  => array('name' => '????????????(??????)', 'url' => mobileUrl('order', NULL, $full), 'url_wxapp' => '/pages/order/index'),
					2  => array('name' => '???????????????', 'url' => mobileUrl('order', array('status' => 0), $full), 'url_wxapp' => '/pages/order/index?status=0'),
					// 3  => array('name' => '???????????????', 'url' => mobileUrl('order', array('status' => 1), $full), 'url_wxapp' => '/pages/order/index?status=1'),
					4  => array('name' => '???????????????', 'url' => mobileUrl('order', array('status' => 2), $full), 'url_wxapp' => '/pages/order/index?status=2'),
					5  => array('name' => '???????????????', 'url' => mobileUrl('order', array('status' => 4), $full), 'url_wxapp' => '/pages/order/index?status=4'),
					6  => array('name' => '???????????????', 'url' => mobileUrl('order', array('status' => 3), $full), 'url_wxapp' => '/pages/order/index?status=3'),
					7  => array('name' => '????????????', 'url' => mobileUrl('member/favorite', array(), $full), 'url_wxapp' => '/pages/member/favorite/index'),
					8  => array('name' => '????????????', 'url' => mobileUrl('member/history', array(), $full), 'url_wxapp' => '/pages/member/history/index'),
					// 9  => array('name' => '????????????', 'url' => mobileUrl('member/recharge', array(), $full), 'url_wxapp' => '/pages/member/recharge/index'),
					10 => array('name' => '????????????', 'url' => mobileUrl('member/log', array(), $full), 'url_wxapp' => '/pages/member/log/index'),
					11 => array('name' => '????????????', 'url' => mobileUrl('member/withdraw', array(), $full), 'url_wxapp' => '/pages/member/withdraw/index'),
					12 => array('name' => '????????????', 'url' => mobileUrl('member/info', array(), $full), 'url_wxapp' => '/pages/member/info/index'),
					// 13 => array('name' => '????????????', 'url' => mobileUrl('member/rank', array(), $full), 'url_wxapp' => ''),
					14 => array('name' => '????????????', 'url' => mobileUrl('member/rank/order_rank', array(), $full), 'url_wxapp' => ''),
					// 16 => array('name' => '??????????????????', 'url' => mobileUrl('member/address', array(), $full), 'url_wxapp' => '/pages/member/address/index'),
					// 18 => array('name' => '????????????', 'url' => mobileUrl('member/fullback', array(), $full), 'url_wxapp' => ''),
					// 19 => array('name' => '???????????????', 'url' => mobileUrl('verifygoods', array(), $full), 'url_wxapp' => '')
				)
			)
		);

		if ($platform) {
			if (cv('creditshop') && p('creditshop')) {
				$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl(NULL, NULL, $full), 'url_wxapp' => '/pages/creditshop/index');
			}

			if (cv('commission') && p('commission')) {
				$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('commission', NULL, $full), 'url_wxapp' => '/pages/transfer/commission/index');
			}

			$allUrls[2]['list'][] = array('name' => '????????????', 'url' => mobileUrl('member/fullback', array(), $full), 'url_wxapp' => '/commission/pages/return/index');
			$allUrls[2]['list'][] = array('name' => '???????????????', 'url' => mobileUrl('verifygoods', array(), $full), 'url_wxapp' => '/pages/verifygoods/index');
			if ($platform != 'wxapp_tabbar' && $platform != '') {
				if (cv('dividend') && p('dividend')) {
					$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('', NULL, $full), 'url_wxapp' => '/dividend/pages/index/index');
				}
			}

			if (cv('groups') && p('groups')) {
				$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('', NULL, $full), 'url_wxapp' => '/pages/transfer/groups/index');
			}

			if (cv('groups') && p('seckill')) {
				$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('', NULL, $full), 'url_wxapp' => '/pages/transfer/seckill/index');
			}

			if (cv('groups') && p('bargain')) {
				$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('', NULL, $full), 'url_wxapp' => '/pages/transfer/bargain/index');
			}
		}

		// if (p('cycelbuy')) {
		// 	$allUrls[2]['list'][] = array('name' => '?????????????????????', 'url' => mobileUrl('cycelbuy/order/list', array(), $full), 'url_wxapp' => '/pages/order/cycle/order');
		// }

		if (p('membercard')) {
			$allUrls[2]['list'][] = array('name' => '???????????????', 'url' => mobileUrl('membercard/index', array(), $full), 'url_wxapp' => '/pages/member/membercard/index');
		}

		// if (p('dividend') && !$platform) {
		// 	$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('dividend', array(), $full), 'url_wxapp' => '/pages/order/cycle/order');
		// }

		// if (p('exchange') && !$platform) {
		// 	$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('exchange', array('codetype' => 1, 'all' => 1), $full), 'url_wxapp' => '');
		// }

		// if (p('abonus') && !$platform) {
		// 	$allUrls[0]['list'][] = array('name' => '????????????', 'url' => mobileUrl('abonus', $full), 'url_wxapp' => '');
		// }

		if ($platform) {
			$customs = pdo_fetchall('select id,`name` from ' . tablename('ewei_shop_wxapp_page') . ' where uniacid = :uniacid and `type` = 20 and status = 1 ', array(':uniacid' => $_W['uniacid']));

			if (!empty($customs)) {
				$addUrl = array(
					'name' => '???????????????',
					'list' => array()
				);
				$urllist = array();

				foreach ($customs as $key => $value) {
					if ($type == 'topmenu') {
						$urllist[$key] = array('name' => $value['name'], 'url' => '', 'url_wxapp' => '/pages/custom/index?pageid=' . $value['id']);
						$diypage = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE id=:id AND uniacid = :uniacid', array(':id' => $value['id'], ':uniacid' => $_W['uniacid']));
						$diypageData = json_decode(base64_decode($diypage['data']), true);

						if (!empty($diypageData['items'])) {
							foreach ($diypageData['items'] as $dk => $dv) {
								if ($dv['id'] == 'topmenu') {
									unset($urllist[$key]);
								}
							}
						}
					}
					else {
						$urllist[$key] = array('name' => $value['name'], 'url' => '', 'url_wxapp' => '/pages/custom/index?pageid=' . $value['id']);
					}
				}

				$addUrl['list'] = $urllist;
				array_push($allUrls, $addUrl);
			}

			unset($allUrls[2]['list'][13]);
			unset($allUrls[2]['list'][14]);
			unset($allUrls[2]['list'][15]);
			unset($allUrls[2]['list'][18]);
			unset($allUrls[2]['list'][19]);

			if ($platform == 'wxapp_tabbar') {
				unset($allUrls[1]);
				unset($allUrls[2]['list'][2]);
				unset($allUrls[2]['list'][3]);
				unset($allUrls[2]['list'][4]);
				unset($allUrls[2]['list'][5]);
				unset($allUrls[2]['list'][6]);
			}
		}

		// if (cv('commission.agent.edit') && p('commission') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('commission'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('commission', NULL, $full), 'url_wxapp' => '/pages/commission/index'),
		// 			array('name' => '???????????????', 'url' => mobileUrl('commission/register', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/myshop', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????/????????????', 'url' => mobileUrl('commission/withdraw', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/order', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/down', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/log', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '???????????????', 'url' => mobileUrl('commission/qrcode', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/myshop/set', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/rank', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('commission/myshop/select', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		if (cv('offic.system.edit') && p('offic') && !$platform) {
			$allUrls[] = array(
				'name' => m('plugin')->getName('offic'),
				'list' => array(
					array('name' => '??????', 'url' => mobileUrl('offic', NULL, $full), 'url_wxapp' => ''),
					array('name' => '??????', 'url' => mobileUrl('offic/find', NULL, $full), 'url_wxapp' => ''),
					array('name' => '????????????', 'url' => mobileUrl('commission/branch', NULL, $full), 'url_wxapp' => ''),
					array('name' => '????????????', 'url' => mobileUrl('commission/branch/fans', NULL, $full), 'url_wxapp' => ''),
					array('name' => '????????????', 'url' => mobileUrl('offic/myshop', NULL, $full), 'url_wxapp' => '')
				)
			);
		}

		if (cv('article.edit') && p('article') && !$platform) {
			$allUrls[] = array(
				'name' => m('plugin')->getName('article'),
				'list' => array(
					array('name' => '??????????????????', 'url' => mobileUrl('article/list', NULL, $full), 'url_wxapp' => '')
				)
			);
		}

		// $allUrls[] = array(
		// 	'name' => m('plugin')->getComName('coupon'),
		// 	'list' => array(
		// 		array('name' => '???????????????', 'url' => mobileUrl('sale/coupon', NULL, $full), 'url_wxapp' => '/pages/sale/coupon/index/index'),
		// 		array('name' => '???????????????', 'url' => mobileUrl('sale/coupon/my', NULL, $full), 'url_wxapp' => '/pages/sale/coupon/my/index/index')
		// 	)
		// );
		// if (cv('groups.goods.edit') && p('groups') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('groups'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('groups', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('groups/category', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('groups/orders', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '?????????', 'url' => mobileUrl('groups/team', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// if (cv('mr.goods.edit') && p('mr') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('mr'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('mr', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('mr/order', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// if (cv('sns.adv.edit') && p('sns') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('sns'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('sns', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('sns/board/lists', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('sns/user', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// if (cv('sign.rule.edit') && p('sign') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('sign'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('sign', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('sign/rank', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// if (cv('qa.adv.edit') && p('qa') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('qa'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('qa', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('qa/category', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('qa/question', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		if (cv('task.edit') && p('task') && !$platform) {
			$allUrls[] = array(
				'name' => m('plugin')->getName('task'),
				'list' => array(
					array('name' => '??????', 'url' => mobileUrl('task', NULL, $full), 'url_wxapp' => '')
				)
			);
		}

		// if (cv('creditshop.goods.edit') && p('creditshop') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('creditshop'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('creditshop', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('creditshop/lists', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '??????', 'url' => mobileUrl('creditshop/log', NULL, $full), 'url_wxapp' => ''),
		// 			array('name' => '????????????', 'url' => mobileUrl('creditshop/creditlog', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// if (cv('seckill.task.edit') && p('seckill') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('seckill'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('seckill', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		if (cv('newstore.temp.edit') && p('newstore') && !$platform) {
			$allUrls[] = array(
				'name' => m('plugin')->getName('newstore'),
				'list' => array(
					array('name' => '????????????', 'url' => mobileUrl('newstore/stores', NULL, $full), 'url_wxapp' => '')
				)
			);
		}

		// if (cv('globonus.partner.edit') && p('globonus') && !$platform) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('globonus'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('globonus', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		// $key = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_open_plugin') . ' WHERE `status` =1 and plugin = :plugin', array(':plugin' => 'open_messikefu'));
		// if (cv('open_messikefu') && p('open_messikefu') && !$platform && $key) {
		// 	$allUrls[] = array(
		// 		'name' => m('plugin')->getName('open_messikefu'),
		// 		'list' => array(
		// 			array('name' => '????????????', 'url' => mobileUrl('open_messikefu', NULL, $full), 'url_wxapp' => '')
		// 		)
		// 	);
		// }

		if (cv('friendcoupon.edit') && p('friendcoupon') && !$platform) {
			$activities = p('friendcoupon')->getActivityList();
		}

		if ($type == 'levellink') {
			unset($allUrls);
			$allUrls = array();

			if ($platform) {
				$customs = pdo_fetchall('select id,`name` from ' . tablename('ewei_shop_wxapp_page') . ' where uniacid = :uniacid and `type` = 20 and status = 1 ', array(':uniacid' => $_W['uniacid']));
				if (!empty($customs) && $platform != 'wxapp_tabbar') {
					$addUrl = array(
						'name' => '???????????????',
						'list' => array()
					);
					$urllist = array();

					foreach ($customs as $key => $value) {
						if ($type == 'levellink') {
							$urllist[$key] = array('name' => $value['name'], 'url' => '', 'url_wxapp' => '/pages/custom/index?pageid=' . $value['id']);
							$diypage = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE id=:id AND uniacid = :uniacid', array(':id' => $value['id'], ':uniacid' => $_W['uniacid']));
							$diypageData = json_decode(base64_decode($diypage['data']), true);

							if (!empty($diypageData['items'])) {
								foreach ($diypageData['items'] as $dk => $dv) {
									if ($dv['id'] == 'topmenu' || $dv['id'] == 'tabbar') {
										unset($urllist[$key]);
									}
								}
							}
						}
						else {
							$urllist[$key] = array('name' => $value['name'], 'url' => '', 'url_wxapp' => '/pages/custom/index?pageid=' . $value['id']);
						}
					}

					$addUrl['list'] = $urllist;
					array_push($allUrls, $addUrl);
				}
			}
		}

		if ($platform == 'pc') {
			$allUrls = array();
			$allUrls = p('pc')->getLinkList();
		}

		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$type = trim($_GPC['type']);
		$kw = trim($_GPC['kw']);
		$full = intval($_GPC['full']);
		$platform = trim($_GPC['platform']);
		if (!empty($kw) && !empty($type)) {
			if ($type == 'good') {
				$list = pdo_fetchall('SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and status=:status and deleted=0 AND title LIKE :title ', array(':title' => '%' . $kw . '%', ':uniacid' => $_W['uniacid'], ':status' => '1'));
				$list = set_medias($list, 'thumb');
			}
			else if ($type == 'goods_data_diy') {
				if ($kw == 'all') {
					$list = pdo_fetchall('SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and status=:status and deleted=0 ', array(':uniacid' => $_W['uniacid'], ':status' => '1'));
					$list = set_medias($list, 'thumb');
				}
				else {
					$list = pdo_fetchall('SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and status=:status and deleted=0 AND title LIKE :title ', array(':title' => '%' . $kw . '%', ':uniacid' => $_W['uniacid'], ':status' => '1'));
					$list = set_medias($list, 'thumb');
				}
			}
			else if ($type == 'article') {
				$list = pdo_fetchall('select id,article_title from ' . tablename('ewei_shop_article') . ' where article_title LIKE :title and article_state=1 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
			}
			else if ($type == 'coupon') {
				$list = pdo_fetchall('select id,couponname,coupontype from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
			}
			else if ($type == 'groups') {
				$list = pdo_fetchall('select id,title from ' . tablename('ewei_shop_groups_goods') . ' where title LIKE :title and status=1 and deleted=0 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
			}
			else if ($type == 'sns') {
				$list_board = pdo_fetchall('select id,title from ' . tablename('ewei_shop_sns_board') . ' where title LIKE :title and status=1 and enabled=0 and uniacid=:uniacid order by id desc ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
				$list_post = pdo_fetchall('select id,title from ' . tablename('ewei_shop_sns_post') . ' where title LIKE :title and checked=1 and deleted=0 and uniacid=:uniacid order by id desc ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
				$list = array();
				if (!empty($list_board) && is_array($list_board)) {
					foreach ($list_board as &$board) {
						$board['type'] = 0;
						$board['url'] = mobileUrl('sns/board', array('id' => $board['id'], 'page' => 1), $full);
					}

					unset($board);
					$list = array_merge($list, $list_board);
				}

				if (!empty($list_post) && is_array($list_post)) {
					foreach ($list_post as &$post) {
						$post['type'] = 1;
						$post['url'] = mobileUrl('sns/post', array('id' => $post['id']), $full);
					}

					unset($post);
					$list = array_merge($list, $list_post);
				}
			}
			else {
				if ($type == 'creditshop') {
					$list = pdo_fetchall('select id, thumb, title, price, credit, money from ' . tablename('ewei_shop_creditshop_goods') . ' where title LIKE :title and status=1 and deleted=0 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':title' => '%' . $kw . '%'));
				}
			}
		}

		include $this->template('util/selecturl_tpl');
	}
}

?>
