<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'verify')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$paras = array(':uniacid' => $_W['uniacid']);
		$condition = ' uniacid = :uniacid';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND (game_name LIKE \'%' . $_GPC['keyword'] . '%\')';
		}

		if (!empty($_GPC['type'])) {
			$type = intval($_GPC['type']);
			$condition .= ' AND type = :type';
			$paras[':type'] = $type;
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_game_setting') . (' WHERE ' . $condition . ' ORDER BY id desc');
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$sql_count = 'SELECT count(1) FROM ' . tablename('ewei_game_setting') . (' WHERE ' . $condition);
		$total = pdo_fetchcolumn($sql_count, $paras);
		$pager = pagination2($total, $pindex, $psize);
		$list = pdo_fetchall($sql, $paras);

		
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{

		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if ($_W['ispost']) {
			if (!empty($_GPC['perms'])) {
				$perms = implode(',', $_GPC['perms']);
			}
			else {
				$perms = '';
			}

			if (empty($_GPC['game_img'])) {
				show_json(0, '活动图片不能为空');
			}

			if (empty($_GPC['ok_where'])) {
				show_json(0, '触发条件不能为空');
			}

			if (empty($_GPC['member_max'])) {
				show_json(0, '报名金额不能为空');
			}
			

			if (empty($_GPC['jiang']) && $_GPC['hexiao']!=1) {
				show_json(0, '请填写奖励金额');
			}

			// if(in_array(2,$_GPC['ok_where']) || in_array(3,$_GPC['ok_where']) && empty($_GPC['yan_time'])){
			// 	show_json(0, '请填写奖励金额');
			// }

			// if (100< mb_strlen($_GPC['content'], 'UTF-8')) {
			// 	show_json(0, '活动简介不能超过100个字符');
			// }
			
			//2021-5-8下班前截止  未完成添加到数据库

			$data = array('uniacid' => $_W['uniacid'],'yan_time'=>trim($_GPC['yan_time']),'ok_num'=>trim($_GPC['ok_num']),'ok_money'=>trim($_GPC['ok_money']), 'game_name' => trim($_GPC['game_name']), 'game_img' => trim($_GPC['game_img']), 'content' => trim($_GPC['content']), 'is_cash' => in_array(1,$_GPC['is_cash'])?1:0,'is_tong' => in_array(2,$_GPC['is_cash'])?1:0,'is_te' => $_GPC['is_te'],'is_te' => in_array(3,$_GPC['is_cash'])?1:0, 'member_max' => trim($_GPC['member_max']), 'member_min' => trim($_GPC['member_min']), 'game_money' => trim($_GPC['game_money']), 'money_min' => $_GPC['money_min'], 'start_time' => $_GPC['start_time'], 'time_for' => $_GPC['time_for'],'jiang' => $_GPC['jiang'], 'hexiao' => trim($_GPC['hexiao']), 'ok_where' => json_encode($_GPC['ok_where']),'goods_id'=>json_encode($_GPC['goodsids']));

			if (!empty($id)) {
				pdo_update('ewei_game_setting', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}else {
				pdo_insert('ewei_game_setting', $data);
				$id = pdo_insertid();
			}
			show_json(1, array('url' => webUrl('game')));
		}

		if (p('newstore')) {
			$storegroup = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_storegroup') . ' WHERE  uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid']));
			$category = pdo_fetchall('SELECT *FROM ' . tablename('ewei_shop_newstore_category') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_game_setting') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		$perms = explode(',', $item['perms']);

		if ($printer = com('printer')) {
			$item = $printer->getStorePrinterSet($item);
			$order_printer_array = $item['order_printer'];
			$ordertype = $item['ordertype'];
			$order_template = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE uniacid=:uniacid AND merchid=0', array(':uniacid' => $_W['uniacid']));
		}
		// var_dump(json_decode($item['goods_id']));die;
		$goods=  [];
		foreach(json_decode($item['goods_id']) as $ke=>$va){
			$goods[] = pdo_get('ewei_shop_goods',array('id'=>$va));
		}
		// var_dump($goods);die;

		$label = explode(',', $item['label']);
		$tag = explode(',', $item['tag']);
		$cates = explode(',', $item['cates']);
		include $this->template();
	}



	public function memberhexiao(){
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$paras = array(':uniacid' => $_W['uniacid']);
		$condition = ' uniacid = :uniacid AND hexiao=1 ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND (nickname LIKE \'%' . $_GPC['keyword'] . '%\')';
		}

		$sql = 'SELECT id,nickname,avatar,hexiao_type FROM ' . tablename('ewei_shop_member') . (' WHERE ' . $condition . ' ORDER BY id desc');
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$sql_count = 'SELECT count(1) FROM ' . tablename('ewei_shop_member') . (' WHERE ' . $condition);
		$total = pdo_fetchcolumn($sql_count, $paras);
		$pager = pagination2($total, $pindex, $psize);
		$list = pdo_fetchall($sql, $paras);
		$data = [];
		foreach($list as $k=>$v){
			// var_dump(json_decode($v['hexiao_type'],true));die;
			if(in_array('1',json_decode($v['hexiao_type'],true))){
				$list[$k]['hexiao_type'] = "线上核销,";
			}
			if(in_array('2',json_decode($v['hexiao_type'],true))){
				$list[$k]['hexiao_type'] .= "线下核销";
			}
		}

		include $this->template();
	}

	public function hexiaoinfo(){
		global $_W;
		global $_GPC;
		if ($_W['ispost']) {
			if(empty($_GPC['type'])){
				show_json(0, '请选择核销资格');
			}
			foreach($_GPC['openids'] as $k=>$v){
				$id = pdo_update('ewei_shop_member',array('hexiao'=>1,'hexiao_type'=>json_encode($_GPC['type'])),array('openid'=>$v));
			}
			show_json(1, array('url' => webUrl('game/memberhexiao')));
		}
		$member = pdo_get('ewei_shop_member',array('id'=>$_GPC['id']));

		include $this->template();
	}

	public function memberedit(){
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		pdo_update('ewei_shop_member', array('hexiao' => 0), array('id' => $id));
		
		show_json(1, array('url' => referer()));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_store', array('id' => $item['id']));
			plog('shop.verify.store.delete', '删除门店 ID: ' . $item['id'] . ' 门店名称: ' . $item['storename'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_store', array('displayorder' => $displayorder), array('id' => $id));
			plog('shop.verify.store.edit', '修改门店排序 ID: ' . $item['id'] . ' 门店名称: ' . $item['storename'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function hexiao()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		pdo_update('ewei_game_setting', array('hexiao' => intval($_GPC['hexiao'])), array('id' => $id));
			

		show_json(1, array('url' => referer()));
	}


	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		pdo_update('ewei_game_setting', array('status' => intval($_GPC['status'])), array('id' => $id));
			

		show_json(1, array('url' => referer()));
	}


	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$limittype = empty($_GPC['limittype']) ? 0 : intval($_GPC['limittype']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid  and status=1 ';

		if ($limittype == 0) {
			$condition .= '  and type in (1,2,3) ';
		}

		if (!empty($kwd)) {
			$condition .= ' AND `storename` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template('shop/verify/store/query');
		exit();
	}

	public function querygoods()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and deleted = 0 and `type` in (1,5,30)  and merchid =0';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
