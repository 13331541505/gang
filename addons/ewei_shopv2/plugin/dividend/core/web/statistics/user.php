<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/dividend_page_web.php';
class User_EweiShopV2Page extends DividendWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$params = array();
		$searchstart = intval($_GPC['searchstart']);
		$keyword = trim($_GPC['keyword']);
		$headsid = intval($_GPC['id']);
		$params[':headsid'] = $headsid;
		$params[':uniacid'] = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 100;
		$sql = 'select * from ' . tablename('ewei_shop_member') . ' where headsid = :headsid and uniacid = :uniacid ORDER BY headstime desc';
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		dump(456);
		exit();

		if (!empty($searchstart)) {
			$userlist = pdo_fetchall($sql, $params);
			$total_sql = 'select COUNT(1) from ' . tablename('ewei_shop_member') . ' where headsid = :headsid and uniacid = :uniacid';
			$total = pdo_fetchcolumn($total_sql, $params);
			$pager = pagination($total, $pindex, $psize);
		}

		$list = array();

		if (!empty($userlist)) {
			$has_createtime = 0;
			$has_agenttime = 0;
			if (!empty($_GPC['createtime']['start']) && !empty($_GPC['createtime']['end'])) {
				$has_createtime = 1;
				$cstarttime = strtotime($_GPC['createtime']['start']);
				$cendtime = strtotime($_GPC['createtime']['end']);
				$sql_createtime = ' AND dm.createtime >= :cstarttime AND dm.createtime <= :cendtime ';
			}

			if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
				$has_agenttime = 1;
				$astarttime = strtotime($_GPC['time']['start']);
				$aendtime = strtotime($_GPC['time']['end']);
				$sql_agenttime = ' AND dm.agenttime >= :astarttime AND dm.agenttime <= :aendtime ';
			}

			foreach ($userlist as $k => $v) {
				$agentid = $v['id'];
				$member = $this->model->getInfo($agentid);

				if (empty($member['agentcount'])) {
					continue;
				}

				$level1 = $member['level1'];
				$level2 = $member['level2'];
				$level3 = $member['level3'];
				$level11 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where isagent=0 and agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $agentid, ':uniacid' => $_W['uniacid']));
				$condition = '';
				$params = array();

				if (empty($level)) {
					$condition = ' and ( dm.agentid=' . $member['id'];

					if (0 < $level1) {
						$condition .= ' or  dm.agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ')';
					}

					if (0 < $level2) {
						$condition .= ' or  dm.agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ')';
					}

					$condition .= ' )';
					$hasagent = true;
				}
				else if ($level == 1) {
					if (0 < $level1) {
						$condition = ' and dm.agentid=' . $member['id'];
						$hasagent = true;
					}
					else {
						continue;
					}
				}
				else if ($level == 2) {
					if (0 < $level2) {
						$condition = ' and dm.agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ')';
						$hasagent = true;
					}
					else {
						continue;
					}
				}
				else {
					if ($level == 3) {
						if (0 < $level3) {
							$condition = ' and dm.agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ')';
							$hasagent = true;
						}
						else {
							continue;
						}
					}
				}

				if (!empty($_GPC['mid'])) {
					$condition .= ' and dm.id=:mid';
					$params[':mid'] = intval($_GPC['mid']);
				}

				if ($_GPC['isagent'] != '') {
				}

				$condition .= ' and dm.isagent=1 and dm.status=1';

				if ($_GPC['status'] != '') {
				}

				if (!empty($searchstart) && !empty($keyword)) {
					$condition .= ' and ( dm.mobile like :keyword or dm.nickname like :keyword or dm.realname like :keyword)';
					$params[':keyword'] = '%' . $keyword . '%';
				}

				if (!empty($has_createtime)) {
					$condition .= $sql_createtime;
					$params[':cstarttime'] = $cstarttime;
					$params[':cendtime'] = $cendtime;
				}

				if (!empty($has_agenttime)) {
					$condition .= $sql_agenttime;
					$params[':astarttime'] = $astarttime;
					$params[':aendtime'] = $aendtime;
				}

				if ($_GPC['followed'] != '') {
					if ($_GPC['followed'] == 2) {
						$condition .= ' and f.follow=0 and dm.uid<>0';
					}
					else {
						$condition .= ' and f.follow=' . intval($_GPC['followed']);
					}
				}

				if ($_GPC['isagentblack'] != '') {
					$condition .= ' and dm.agentblack=' . intval($_GPC['isagentblack']);
				}

				if ($hasagent) {
					$child_sql = 'select dm.* from ' . tablename('ewei_shop_member') . ' dm ' . ' left join ' . tablename('mc_mapping_fans') . ('f on f.openid=dm.openid  and f.uniacid=' . $_W['uniacid']) . ' where dm.uniacid = ' . $_W['uniacid'] . (' ' . $condition . '   ORDER BY dm.agenttime desc');
					$child_list = pdo_fetchall($child_sql, $params);

					if (!empty($child_list)) {
						foreach ($child_list as &$row) {
							$row['pagent'] = $v;
							$info = $this->model->getInfo($row['openid'], array('total', 'pay'));
							$row['levelcount'] = $info['agentcount'];

							if (1 <= $this->set['level']) {
								$row['level1'] = $info['level1'];
							}

							if (2 <= $this->set['level']) {
								$row['level2'] = $info['level2'];
							}

							if (3 <= $this->set['level']) {
								$row['level3'] = $info['level3'];
							}

							$row['credit1'] = m('member')->getCredit($row['openid'], 'credit1');
							$row['credit2'] = m('member')->getCredit($row['openid'], 'credit2');
							$row['commission_total'] = $info['commission_total'];
							$row['commission_pay'] = $info['commission_pay'];
							$row['followed'] = m('user')->followed($row['openid']);

							if ($row['agentid'] == $member['id']) {
								$row['level'] = 1;
							}
							else if (in_array($row['agentid'], array_keys($member['level1_agentids']))) {
								$row['level'] = 2;
							}
							else {
								if (in_array($row['agentid'], array_keys($member['level2_agentids']))) {
									$row['level'] = 3;
								}
							}
						}

						$list = array_merge($list, $child_list);
					}
				}

				unset($row);
			}
		}

		$list_total = count($list);

		if ($_GPC['export'] == 1) {
			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['agentime'] = empty($row['agenttime']) ? '' : date('Y-m-d H:i', $row['agentime']);
				$row['groupname'] = empty($row['groupname']) ? '?????????' : $row['groupname'];
				$row['levelname'] = empty($row['levelname']) ? '????????????' : $row['levelname'];
				$row['parentname'] = empty($row['pagent']['nickname']) ? '??????' : '[' . $row['agentid'] . ']' . $row['pagent']['nickname'];
				$row['statusstr'] = empty($row['status']) ? '' : '??????';
				$row['followstr'] = empty($row['followed']) ? '' : '?????????';
				if (p('diyform') && !empty($row['diymemberfields']) && !empty($row['diymemberdata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diymemberfields']), iunserializer($row['diymemberdata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$row['member_diyformdata'] = $diyformdata;
				}

				if (p('diyform') && !empty($row['pagent']['diycommissionfields']) && !empty($row['pagent']['diycommissiondata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['pagent']['diycommissionfields']), iunserializer($row['pagent']['diycommissiondata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$row['pagent_diyformdata'] = $diyformdata;
				}

				if (p('diyform') && !empty($row['pagent']['diymemberfields']) && !empty($row['pagent']['diymemberdata'])) {
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['pagent']['diymemberfields']), iunserializer($row['pagent']['diymemberdata']));
					$diyformdata = '';

					foreach ($diyformdata_array as $da) {
						$diyformdata .= $da['name'] . ': ' . $da['value'] . '
';
					}

					$row['pmember_diyformdata'] = $diyformdata;
				}
			}

			unset($row);
			$columns = array(
				array('title' => 'ID', 'field' => 'id', 'width' => 12),
				array('title' => '??????', 'field' => 'nickname', 'width' => 12),
				array('title' => '??????', 'field' => 'realname', 'width' => 12),
				array('title' => '?????????', 'field' => 'mobile', 'width' => 12),
				array('title' => '?????????', 'field' => 'weixin', 'width' => 12),
				array('title' => 'openid', 'field' => 'openid', 'width' => 24),
				array('title' => '??????', 'field' => 'parentname', 'width' => 12),
				array('title' => '???????????????', 'field' => 'levelname', 'width' => 12),
				array('title' => '?????????', 'field' => 'clickcount', 'width' => 12),
				array('title' => '?????????????????????', 'field' => 'levelcount', 'width' => 12),
				array('title' => '????????????????????????', 'field' => 'level1', 'width' => 12),
				array('title' => '????????????????????????', 'field' => 'level2', 'width' => 12),
				array('title' => '????????????????????????', 'field' => 'level3', 'width' => 12),
				array('title' => '????????????', 'field' => 'commission_total', 'width' => 12),
				array('title' => '????????????', 'field' => 'commission_pay', 'width' => 12),
				array('title' => '????????????', 'field' => 'createtime', 'width' => 12),
				array('title' => '?????????????????????', 'field' => 'createtime', 'width' => 12),
				array('title' => '????????????', 'field' => 'createtime', 'width' => 12),
				array('title' => '????????????', 'field' => 'followstr', 'width' => 12)
			);

			if (p('diyform')) {
				$columns[] = array('title' => '???????????????????????????', 'field' => 'member_diyformdata', 'width' => 36);
				$columns[] = array('title' => '????????????????????????????????????', 'field' => 'agent_diyformdata', 'width' => 36);
				$columns[] = array('title' => '??????????????????????????????', 'field' => 'pmember_diyformdata', 'width' => 36);
				$columns[] = array('title' => '???????????????????????????????????????', 'field' => 'pagent_diyformdata', 'width' => 36);
			}

			m('excel')->export($list, array('title' => '????????????-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		load()->func('tpl');
		include $this->template();
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$wechatid = intval($_GPC['wechatid']);

		if (empty($wechatid)) {
			$wechatid = $_W['uniacid'];
		}

		$params = array();
		$params[':uniacid'] = $wechatid;
		$condition = ' and uniacid=:uniacid and isagent=1 and status=1';

		if (!empty($kwd)) {
			$condition .= ' AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword )';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		if (!empty($_GPC['selfid'])) {
			$condition .= ' and id<>' . intval($_GPC['selfid']);
		}

		$ds = pdo_fetchall('SELECT id,avatar,nickname,openid,realname,mobile FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		include $this->template('commission/query');
	}

	public function check()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$status = intval($_GPC['status']);
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile,status FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
		$time = time();

		foreach ($members as $member) {
			if ($member['status'] === $status) {
				continue;
			}

			if ($status == 1) {
				pdo_update('ewei_shop_member', array('status' => 1, 'agenttime' => $time), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('commission.agent.check', '??????????????? <br/>???????????????:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);

				if (!empty($member['agentid'])) {
					$this->model->upgradeLevelByAgent($member['agentid']);

					if (p('globonus')) {
						p('globonus')->upgradeLevelByAgent($member['agentid']);
					}

					if (p('author')) {
						p('author')->upgradeLevelByAgent($member['agentid']);
					}
				}
			}
			else {
				pdo_update('ewei_shop_member', array('status' => 0, 'agenttime' => 0), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
				plog('commission.agent.check', '???????????? <br/>???????????????:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function agentblack()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$agentblack = intval($_GPC['agentblack']);
		$members = pdo_fetchall('SELECT id,openid,nickname,realname,mobile,agentblack FROM ' . tablename('ewei_shop_member') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($members as $member) {
			if ($member['agentblack'] === $agentblack) {
				continue;
			}

			if ($agentblack == 1) {
				pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 0, 'agentblack' => 1), array('id' => $member['id']));
				plog('commission.agent.agentblack', '??????????????? <br/>???????????????:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
			else {
				pdo_update('ewei_shop_member', array('isagent' => 1, 'status' => 1, 'agentblack' => 0), array('id' => $member['id']));
				plog('commission.agent.agentblack', '??????????????? <br/>???????????????:  ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
			}
		}

		show_json(1, array('url' => referer()));
	}
}

?>
