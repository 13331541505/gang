<?php

/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{

	private $token;

	public function __construct($_com = 'verify')
	{

		global $_W;
		global $_GPC;
		date_default_timezone_set("PRC");
		session_start();
		parent::__construct($_com);
		if(!$this->member_id){
			$this->member_id = $_W['member']['uid'];
		}
		// $this->member_id=3;
	}

	//活动列表
	public function game_list(){
		global $_W;
		global $_GPC;

		$game_list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_game_setting') . ' WHERE  uniacid= 2 and status = 0 ', array('uniacid' => $_W['uniacid']));
		foreach($game_list as $k=>$v){
			$game_list[$k]['game_img'] = 'https://'.$_SERVER['SERVER_NAME']."/attachment/".$v['game_img'];
			$game_member = pdo_fetchall('select id from '.tablename('ewei_game_member')." where game_id=".$v['id']." and (status=1 or status=0) and (member_one_id=".$this->member_id." or member_two_id=".$this->member_id.")");
			$sum = pdo_fetchall('select count(*) from '.tablename('ewei_game_member')." where game_id=".$v['id']." and status = 0");
			$sum1 = pdo_fetchall('select count(*) from '.tablename('ewei_game_member')." where game_id=".$v['id']." and lun=1 and (status = 1 or status=2) ");
			$game_list[$k]['is_baoming'] = 	$game_member?1:0;
			$game_list[$k]['sum'] = $sum[0]['count(*)']+$sum1[0]['count(*)']*2;
			$game_list[$k]['is_man'] = $sum[0]['count(*)']==$v['member_max']?1:0;
			$goods_arr = [];
			foreach(json_decode($v['goods_id']) as $key=>$val){
				$goods = pdo_get('ewei_shop_goods',array('id'=>$val,'status'=>1),array('id','title','thumb','minprice'));
				$goods['thumb'] = '/attachment/'.$goods['thumb'];
				$goods_arr[] = $goods;
			}
			$ok_where = json_decode($v['ok_where']);
			
			$game_list[$k]['is_time'] = in_array('1',$ok_where)?1:0;
			$game_list[$k]['is_price'] = in_array('2',$ok_where)?1:0;
			$game_list[$k]['is_member'] = in_array('3',$ok_where)?1:0;
			
			$game_list[$k]['goods'] = $goods_arr;
			$game_list[$k]['content'] = $v['content'];
		}
		$data = m('common')->getSysset('shop');
		$arr['data'] = $game_list;

		$arr['num'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('ewei_game_log')." WHERE member_id=".$this->member_id);
		$arr['this_time'] = date('Y-m-d H:i:s');
		$arr['notice'] = $this->gao();
		$arr['uid'] = $this->member_id;
		return json_encode($arr,JSON_UNESCAPED_UNICODE);
	}
	//规则
	public function guize(){
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('shop');
		return $this->return(0,'',array('guize'=>$data['guize']));
	}

	public function uptime(){
		global $_W;
		global $_GPC;
		pdo_update('ewei_game_setting',array('start_time'=>$_GPC['time']),array('id'=>3));
	}
	//报名
	public function add_game_member(){
		global $_W;
		global $_GPC;

		$id = $this->member_id;
		if(empty($id)){
			return $this->return(1,'参数错误');
		}
		$game_id = $_GPC['id'];
		$game_info = pdo_get('ewei_game_setting',array('id'=>$game_id));
		if($game_info['jinxing']==1 || $game_info['member_max']==$game_info['ok_num']){
			return $this->return(1,'已截止报名,请等待下一轮开启！');
		}
		$member_info = pdo_get('ewei_shop_member',array('uid'=>$id));
		$member_setting = pdo_get('mc_members',array('uid'=>$id));
		$info = pdo_fetch('select * from '.tablename('ewei_game_member').' where game_id='.$game_id.' and (status=0 or status=1) and (member_two_id='.$id.' or member_one_id='.$id.')');
		if($info){
			return $this->return(1,'您已经报过名了');
		}
		if($_GPC['is_cash']==1){
			if($member_info['is_vip']!=1 && $game_info['game_money']>=2){
				return $this->return(1,'很抱歉非VIP用户无法报名');
			}
			//余额支付
			if($member_setting['credit2']>=$game_info['game_money']){
				$credit2 = $member_setting['credit2']-$game_info['game_money'];
				pdo_update('mc_members',array('credit2'=>$credit2),array('uid'=>$id));
				$arr['pay_type'] = 1;
				$arr['money'] = $game_info['game_money'];
			}else{
				return $this->return(1,'您的现金余额不足');
			}

		}elseif($_GPC['is_tong']==1){

			$arr['pay_type'] = 2;
			if($member_info['tong_num']>=1){
				$member_data['tong_num'] = $member_info['tong_num']-1;
				pdo_update('ewei_shop_member',$member_data,array('uid'=>$id));
			}else{
				return $this->return(1,'您剩余次数不足');
			}

		}elseif($_GPC['is_te']==1){
			$arr['pay_type'] = 3;
			if($member_info['te_num']>=1){
				$member_data['te_num'] = $member_info['te_num']-1;
				pdo_update('ewei_shop_member',$member_data,array('uid'=>$id));
			}else{
				return $this->return(1,'您剩余次数不足');
			}
		}
		$ran = rand(1,3);
		
		pdo_fetch('update '.tablename('ewei_game_setting').' set ok_num=ok_num+1 where id='.$game_id);

		$info = pdo_fetch('select id,member_one_id,member_one_hand from '.tablename('ewei_game_member').' where game_id='.$game_id.' and status=0');
		if(!$info && !empty($game_id)){
			$res = pdo_insert('ewei_game_member',array('game_id'=>$game_id,'member_one_id'=>$id,'member_one_hand'=>$ran));
			$gm_id = pdo_insertid();
		}else{
			$in = array(1,2,3);
			$res = array_rand(array_diff($in,[$info['member_one_hand']]),1);
			$ree = $this->caiquan($info['member_one_hand'],$in[$res]);
			$win = $ree==1?$info['member_one_id']:$id;
			$res = pdo_update('ewei_game_member',array('member_two_id'=>$id,'status'=>1,'member_two_hand'=>$in[$res],'win_id'=>$win),array('id'=>$info['id']));
			
			$one_member = pdo_get('ewei_shop_member',array('uid'=>$id),array('uid','nickname','avatar_wechat'));
			///workman 推送到客户端信息
			$client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1);
			// 推送的数据，包含uid字段，表示是给这个uid推送
			$data = array('uid'=>$info['member_one_id'],'type'=>1,'percent'=>json_encode($one_member));
			// 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
			fwrite($client, json_encode($data)."\n");

		}
		if($res){
			$arr['member_id'] = $id;
			$arr['game_id'] = $game_id;
			$arr['add_time'] = time();
			$arr['game_title'] = $game_info['game_name'];
			$arr['game_type'] = $game_info['hexiao'];
			pdo_insert('ewei_game_log',$arr);
			
			return $this->return(0,'报名成功,请等待开始');
		}else{
			return $this->return(1,'报名失败,请重试');
		}
	}

	//游戏界面 用户信息
	public function game_info(){
		global $_W;
		global $_GPC;

		$member_id = $this->member_id;
		$game_id = $_GPC['id'];
		if(!$game_id || !$member_id){
			return $this->return(1,'参数错误');
		}
		$game_info = pdo_get('ewei_game_setting',array('id'=>$game_id));
		$game_member = pdo_fetch('select * from '.tablename('ewei_game_member').' where game_id='.$game_id.' and status!=2 and (member_two_id='.$member_id.' or member_one_id='.$member_id.')');
		$data = [];
		$data['game_info'] = $game_info;
		$data['me'] = pdo_get('ewei_shop_member',array('uid'=>$member_id),array('uid','nickname','avatar_wechat'));
		if($game_member){
			//参与人数计算完成
			if($game_member['member_one_id']==$member_id){
				if($game_member['member_two_id']){
					$data['she'] = pdo_get('ewei_shop_member',array('uid'=>$game_member['member_two_id']),array('uid','nickname','avatar_wechat'));
				}else{
					$data['she']['nickname'] = '暂无';
					$data['she']['avatar_wechat'] = './img/user.png';
				}
				$data['me']['hand'] = $game_member['member_one_hand'];
				$data['she']['hand'] = $game_member['member_two_hand'];
				$ree = $this->caiquan($me['me_hand'],$me['she_hand']);
				
				if($ree==1){
					$data['is_win'] = 1;
				}else{
					$data['is_win'] = 0;
				}
			}else{
				if($game_member['member_one_id']){
					$data['she'] = pdo_get('ewei_shop_member',array('uid'=>$game_member['member_one_id']),array('uid','nickname','avatar_wechat'));
				}else{
					$data['she']['nickname'] = '暂无';
					$data['she']['avatar_wechat'] = './img/user.png';
				}
				$data['me']['hand'] = $game_member['member_two_hand'];
				$data['she']['hand'] = $game_member['member_one_hand'];
				$ree = $this->caiquan($me['me_hand'],$me['she_hand']);
				if($ree==1){
					$data['is_win'] = 0;
				}else{
					$data['is_win'] = 1;
				}
			}
			$data['lun'] = $game_member['lun'];
			$data['sum'] = $game_info['ok_num'];
			$data['is_ok'] = $game_member['is_ok'];
			$data['this_time'] = date('Y-m-d H:i:s');
			// $data['member_id'] = $this->member_id;
			return $this->return(0,'请求成功',$data);
		}else{
			return $this->return(1,'请求失败');
		}
	}

	//出招
	public function chuzhao(){
		global $_W;
		global $_GPC;
		$member_id = $this->member_id;
		$game_id = $_GPC['id'];
		$hand = $_GPC['hand'];
		if(!in_array($hand,array('1','2','3')) || !$game_id){
			return $this->return(1,'参数错误');
		}
		$in = array(1,2,3);
		$res = array_rand(array_diff($in,[$_GPC['hand']]),1);
		$game_member = pdo_fetch('select * from '.tablename('ewei_game_member').' where game_id='.$game_id.' and status!=2 and (member_two_id='.$member_id.' or member_one_id='.$member_id.')');
		$me['me_hand'] = $_GPC['hand'];
		if($game_member){
			if($game_member['member_one_id']==$member_id){
				$data['member_one_hand'] = $hand;
				if(!$game_member['member_two_hand'] && !$game_member['member_two_id']){
					$data['member_two_hand'] = $in[$res];
				}else{
					$data['member_two_hand'] = $game_member['member_two_hand'];
				}
				$ree = $this->caiquan($data['member_one_hand'],$data['member_two_hand']);
				$me['she_hand'] = $game_member['member_two_hand'];
				if($ree==1){
					$me['is_win'] = 1;
					$data['win_id'] = $game_member['member_one_id'];
				}else{
					$me['is_win'] = 0;
					$data['win_id'] = $game_member['member_two_id'];
				}
			}else{
				$data['member_two_hand'] = $hand;
				if(!$game_member['member_one_hand']){
					$data['member_one_hand'] = $in[$res];
				}else{
					$data['member_one_hand'] = $game_member['member_one_hand'];
				}
				$ree = $this->caiquan($data['member_two_hand'],$data['member_one_hand']);
				$me['she_hand'] = $game_member['member_one_hand'];
				if($ree==1){
					$me['is_win'] = 1;
					$data['win_id'] = $game_member['member_two_id'];
				}else{
					$me['is_win'] = 0;
					$data['win_id'] = $game_member['member_one_id'];
			    }
			}
			$me['is_ping'] = 0;
			$data['is_ping'] = 0;
			if($me['she_hand']==$me['me_hand']){
				$me['is_win'] = 0;
				$me['is_ping'] = 1;
				$data['is_ping'] = 1;
				$data['win_id'] = 0;
			}
			pdo_update('ewei_game_member',$data,array('id'=>$game_member['id']));
			
			return $this->return(0,'请求成功',$me);
		}else{
			return $this->return(1,'参数错误');
		}
	}

	//游戏记录
	public function myorder(){

		global $_W;
		global $_GPC;
		$m_id = $this->member_id;
		$loglist = pdo_fetchall('select * from '.tablename('ewei_game_log').' where member_id='.$m_id.' order by hexiao,status asc,add_time desc');
		foreach($loglist as $k=>$v){
			$loglist[$k]['sett'] = '请联系客服对二维码进行核销';
		}
		return $this->return(0,'ok',$loglist);

	}


	public function gao(){

		$log  = pdo_fetchall("select g.game_title,m.nickname from ".tablename('ewei_shop_member')." as m left join ".tablename('ewei_game_log')." as g on g.member_id=m.uid where g.status=1");
		return $log;
	
	}

	public function add(){

		for($i = 0;$i<1000;$i++){
			$data['game_id'] = 3;
			$data['member_one_id'] = rand(1000000,9999999);
			$data['member_two_id'] = rand(1000000,9999999);
			$data['member_one_hand'] = 3;
			$data['member_two_hand'] = 1;
			$data['status'] = 1;
			$data['lun'] = 1;
			$data['win_id'] = $data['member_two_id'];
			pdo_insert('ewei_game_member',$data);
		}

	}

	//获取开启下一轮
	public function xia(){

		global $_W;
		global $_GPC;
		$game_id = $_GPC['id'];
		$lun = $_GPC['lun'];
		$is = pdo_fetchall('select count(*) from '.tablename('ewei_game_member').' where lun='.$lun.' and game_id='.$game_id.' and status!=2');
		if($is>=1){
			return $this->return(1,'请耐心等待下一轮比赛');
		}else{
			return $this->return(0,'下一轮即将开始');
		}

	}


    //结果
    public function jieguo(){
  		global $_W;
		global $_GPC;
		$game_id = $_GPC['id'];
		$member_id = $this->member_id;
		
		$game_member = pdo_fetch('select * from '.tablename('ewei_game_member').' where game_id='.$game_id.' and status=1 and (member_two_id='.$member_id.' or member_one_id='.$member_id.')');
		if($game_member['member_one_id']==$member_id){
			$data['me_hand'] = $game_member['member_one_hand'];
			$data['she_hand'] = $game_member['member_two_hand'];

			$status['member_one_time'] = time();
			$status['status'] = $game_member['member_two_time']<time()?1:2;
		}else{
			$data['me_hand'] = $game_member['member_two_hand'];
			$data['she_hand'] = $game_member['member_one_hand'];
			$status['member_two_time'] = time();
			$status['status'] = $game_member['member_one_time']<time()?1:2;
		}
		$data['is_ping'] = $game_member['is_ping'];
		$data['is_win'] = $game_member['win_id']==$member_id?'1':'0';
		
		if(!empty($game_member['member_one_hand']) && !empty($game_member['member_two_hand'])){
			$data['game_id'] = $game_id;
			$data['member_id'] = $member_id;
			$data['add_time'] = time();
			pdo_insert('ewei_game_log',$data);
		}
		$data['is_ok'] = $game_member['is_ok'];
		return $this->return(0,'请求成功',$data);
    }
    
    
    //获取报名页面
    public function game(){
    	
    	global $_W;
		global $_GPC;
		$id = $this->member_id;
		$game_id = $_GPC['game_id'];
		$data['game'] = pdo_get('ewei_game_setting',array('id'=>$game_id));
		$data['game']['game_money'] = $data['game']['is_cash']==1?$data['game']['game_money']:0;
		$member = pdo_get('ewei_shop_member',array('uid'=>$id,'isblack'=>0),array('uid','tong_num','te_num'));
		$price = pdo_get('mc_members',array('uid'=>$id),array('credit2'));
		$member['price'] = $price['credit2'];
		$data['member'] = $member;
		
		return $this->return(0,'ok',$data);
    }
    
    
	//计算胜负
	public function caiquan($one,$two){
		if($one==$two){return 3;}
		if($one==1){
			$win = 2;
		}elseif($one==2){
			$win = 3;
		}elseif($one==3){
			$win = 1;
		}
		if($two!=$win){
			return 1;
		}else{
			return 2;
		}
	}

	public function return($code,$msg,$data){
		return json_encode([
			'code'=>$code,
			'msg'=>$msg,
			'data'=>$data
		],JSON_UNESCAPED_UNICODE);
	}

	public function qrcode($id){
		global $_W;
		global $_GPC;
		$qrcode =  m('qrcode')->createQrcode(mobileUrl('verify/gameinfo','', true));
	}

	//添加分组
	public function addgamemember($id,$game_id,$lun){
    	global $_W;
		global $_GPC;

		$info = pdo_fetch('select id,member_one_id,member_one_hand from '.tablename('ewei_game_member').' where game_id='.$game_id.' and status=0');
		$ran = rand(1,3);

		$l= $lun-1;
		$sum_info = pdo_fetch('select count(*) from ims_ewei_game_member where lun='.$l.' and is_ping=0 and game_id='.$game_id);

		if(!$info && !empty($game_id)){
			if(!$false_info && $sum_info['count(*)']%2==1){
				//添加机器人
				$one_hand = 1;
				$she_hand = 3;
				
				pdo_insert('ewei_game_member',array('game_id'=>$game_id,'member_one_id'=>$id,'member_one_time'=>time(),'member_one_hand'=>$one_hand,'lun'=>$lun,'member_two_id'=>1,'member_two_hand'=>$she_hand,'is_false'=>1,'status'=>1,'win_id'=>$id));

			}else{
				if(!$is_bototm_info){
					
					pdo_insert('ewei_game_member',array('game_id'=>$game_id,'member_one_id'=>$id,'member_one_time'=>time(),'member_one_hand'=>$ran,'lun'=>$lun));
					$gm_id = pdo_insertid();
				}
				
			}

		}else{
			//随机生成对手招数
			$in = array(1,2,3);
			$res = array_rand(array_diff($in,[$info['member_one_hand']]),1);
			$ree = $this->caiquan($info['member_one_hand'],$in[$res]);
			$win = $ree==1?$info['member_one_id']:$id;
			if($info['member_one_id']!=$id){
				$res = pdo_update('ewei_game_member',array('member_two_id'=>$id,'status'=>1,'member_two_hand'=>$in[$res],'win_id'=>$win),array('id'=>$info['id']));
			}
		}
	}
	
	public function moban($plan,$user,$time,$openid)
  	{
	 	global $_W;
	    //生成acces_token
	    $appid=$_W['account']['key'];       //填写微信后台的appid
	    $appsecret=$_W['account']['secret'];   //填写微信后台的appsecret
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

	    $json = file_get_contents($url);
	    $result=json_decode($json,true);
	    $ACCESS_TOKEN=$result['access_token'];
	    //模板消息    
	    $template=array(
	        'touser'=>'oqbM60yp3rm4XJJmncRXRPQhY-as',
	        'template_id'=>"qFSZ6jzFCx8NV_opZ8CAaVewCxbf5fvemsnYYMHoY8o",    //模板的id
	        'url'=>"https://gang.jixunxi.com/web/game/?i=2&v=162080",
	        'topcolor'=>"#FF0000",
	        'data'=>array(
	            'plan'=>array('value'=>333,'color'=>"#00008B"),   
	            'user'=>array('value'=>123,'color'=>'#00008B'),  
	            'time'=>array('value'=>333,'color'=>'#00008B'),   //时间
	        )
	    );
	    $json_template=json_encode($template);
	    $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACCESS_TOKEN;
	    $res=$this->http_request($url,urldecode($json_template));
	    print_r($res);
	}


	public function http_request($url,$data){
	    $ch = curl_init();//初始化
	    curl_setopt($ch, CURLOPT_URL, $url);//设置
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    $output = curl_exec($ch);//执行 
	    curl_close($ch);//关闭
	    return $output;//返回结果
	}

}

?>
