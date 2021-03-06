<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('commission.agent')) {
			header('location: ' . webUrl('commission/agent'));
			exit();
		}
		else if (cv('commission.apply.view1')) {
			header('location: ' . webUrl('commission/apply', array('status' => 1)));
			exit();
		}
		else if (cv('commission.apply.view2')) {
			header('location: ' . webUrl('commission/apply', array('status' => 2)));
			exit();
		}
		else if (cv('commission.apply.view3')) {
			header('location: ' . webUrl('commission/apply', array('status' => 3)));
			exit();
		}
		else if (cv('commission.apply.view_1')) {
			header('location: ' . webUrl('commission/apply', array('status' => -1)));
			exit();
		}
		else if (cv('commission.increase')) {
			header('location: ' . webUrl('commission/increase'));
			exit();
		}
		else if (cv('commission.notice')) {
			header('location: ' . webUrl('commission/notice'));
			exit();
		}
		else if (cv('commission.cover')) {
			header('location: ' . webUrl('commission/cover'));
			exit();
		}
		else if (cv('commission.level')) {
			header('location: ' . webUrl('commission/level'));
			exit();
		}
		else {
			if (cv('commission.set')) {
				header('location: ' . webUrl('commission/set'));
				exit();
			}
		}
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getPluginset('commission', false);
		$data = $data['tm'];
		$salers1 = array();

		if (isset($data['openid1'])) {
			if (!empty($data['openid1'])) {
				$openids1 = array();
				$strsopenids = explode(',', $data['openid1']);

				foreach ($strsopenids as $openid) {
					$openids1[] = '\'' . $openid . '\'';
				}

				@$salers1 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids1) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$salers3 = array();

		if (isset($data['openid3'])) {
			if (!empty($data['openid3'])) {
				$openids3 = array();
				$strsopenids3 = explode(',', $data['openid3']);

				foreach ($strsopenids3 as $openid3) {
					$openids3[] = '\'' . $openid3 . '\'';
				}

				@$salers3 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids3) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$salers2 = array();

		if (isset($data['openid2'])) {
			if (!empty($data['openid2'])) {
				$openids2 = array();
				$strsopenids2 = explode(',', $data['openid2']);

				foreach ($strsopenids2 as $openid2) {
					$openids2[] = '\'' . $openid2 . '\'';
				}

				@$salers2 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids2) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			$post_data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if ($post_data['is_advanced'] == 0) {
				if (is_array($_GPC['openids2'])) {
					$post_data['openid2'] = implode(',', $_GPC['openids2']);
				}
				else {
					$post_data['openid2'] = '';
				}

				$post_data['openid'] = $post_data['openid2'];

				if (!empty($data['openid1'])) {
					$post_data['openid1'] = $data['openid1'];
				}
			}
			else {
				if ($post_data['is_advanced'] == 1) {
					if (is_array($_GPC['openids1'])) {
						$post_data['openid1'] = implode(',', $_GPC['openids1']);
						$post_data['openid'] = $post_data['openid1'];
					}
					else {
						$post_data['openid1'] = '';
					}

					if (is_array($_GPC['openids3'])) {
						$post_data['openid3'] = implode(',', $_GPC['openids3']);
						$post_data['openid'] = $post_data['openid3'];
					}
					else {
						$post_data['openid3'] = '';
					}

					if (!empty($data['openid2'])) {
						$post_data['openid2'] = $data['openid2'];
					}
				}
			}

			m('common')->updatePluginset(array(
				'commission' => array('tm' => $post_data)
			));
			plog('commission.notice.edit', '??????????????????');
			show_json(1);
		}

		$data = m('common')->getPluginset('commission');
		$template_lists = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_lists as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		$template_list = $template_group;
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			if ($data['cansee'] == 1 && empty($data['seetitle'])) {
				show_json(0, '???????????????????????????');
			}

			$data['cashcredit'] = intval($data['cashcredit']);
			$data['cashweixin'] = intval($data['cashweixin']);
			$data['cashother'] = intval($data['cashother']);
			$data['cashalipay'] = intval($data['cashalipay']);
			$data['cashcard'] = intval($data['cashcard']);

			if (!empty($data['withdrawcharge'])) {
				$data['withdrawcharge'] = trim($data['withdrawcharge']);
				$data['withdrawcharge'] = floatval(trim($data['withdrawcharge'], '%'));
			}

			$data['withdrawbegin'] = floatval(trim($data['withdrawbegin']));
			$data['withdrawend'] = floatval(trim($data['withdrawend']));
			$data['register_bottom_content'] = m('common')->html_images($data['register_bottom_content']);
			$data['applycontent'] = m('common')->html_images($data['applycontent']);
			$data['regbg'] = save_media($data['regbg']);
			$data['become_goodsid'] = intval($_GPC['become_goodsid']);
			$data['texts'] = is_array($_GPC['texts']) ? $_GPC['texts'] : array();
			if ($data['become'] == 4 && empty($data['become_goodsid'])) {
				show_json(0, '???????????????');
			}

			m('common')->updatePluginset(array('commission' => $data));
			m('cache')->set('template_' . $this->pluginname, $data['style']);
			$selfbuy = $data['selfbuy'] ? '??????' : '??????';
			$become_child = $data['become_child'] ? ($data['become_child'] == 1 ? '????????????' : '????????????') : '????????????????????????';

			switch ($data['become']) {
			case '0':
				$become = '?????????';
				break;

			case '1':
				$become = '??????';
				break;

			case '2':
				$become = '????????????';
				break;

			case '3':
				$become = '????????????';
				break;

			case '4':
				$become = '????????????';
				break;
			}

			plog('commission.set.edit', '??????????????????<br>' . '???????????? -- ' . $selfbuy . '<br>?????????????????? -- ' . $become_child . '<br>????????????????????? -- ' . $become);
			show_json(1, array('url' => webUrl('commission/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$styles = array();
		$dir = IA_ROOT . '/addons/ewei_shopv2/plugin/' . $this->pluginname . '/template/mobile/';

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		$data = m('common')->getPluginset('commission');
		$goods = false;

		if (!empty($data['become_goodsid'])) {
			$goods = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $data['become_goodsid'], ':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}
}

?>
