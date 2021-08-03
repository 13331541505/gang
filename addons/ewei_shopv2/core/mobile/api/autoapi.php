<?php
set_time_limit(0); // 执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Autoapi_EweiShopV2Page extends MobilePage
{
	public function __construct($_com = 'verify')
	{

		global $_W;
		global $_GPC;
		date_default_timezone_set("PRC");
		set_time_limit(0);//无限请求超时时间 
		session_start();
		parent::__construct($_com);

	}

	public function cece(){
		include("../data/config.php");
		global $con;
		$con = mysqli_connect($config['db']['master']['host'],$config['db']['master']['username'],$config['db']['master']['password'],$config['db']['master']['database']);

		// ignore_user_abort(); // 即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行

		// do{
			$re = mysqli_query($con,'insert into ims_aa(data)value("'.date('Y-m-d H:i:s').'")');
			$game_list_info = mysqli_query($con,'select * from ims_ewei_game_setting where status=0');
			$game_list = mysqli_fetch_all($game_list_info,MYSQLI_ASSOC);

			foreach($game_list as $k=>$v){
				//判断游戏在不在进行中
				if($v['jinxing']==1){
					$member = mysqli_query($con,'select * from ims_ewei_game_member where status=1 and game_id='.$v['id']);
					$member_info = mysqli_fetch_all($member,MYSQLI_ASSOC);
					foreach($member_info as $key=>$val){

						if((strtotime($v['start_time'])-time())==300){
							var_dump($this->send($val['member_one_id'],$val['member_two_id'],$v));
						}

						//当前时间大于等于开赛时间则开始匹配下一轮
						if($v['start_time']<=date('Y-m-d H:i:s')){
							//平局直接晋级下一轮
							if($val['is_ok']!=1){
								if($val['is_ping']==1){
									$lun = $val['lun']+1;
									mysqli_query($con,'insert into ims_ewei_game_member(game_id,member_one_id,member_one_hand,lun,member_two_id,member_two_hand,is_false,status,win_id,end_time)value('.$v['id'].','.$val['member_one_id'].',3,'.$lun.','.$val['member_two_id'].',1,0,1,'.$val['member_two_id'].',1)');
									var_dump(1);
								}else{
									if($val['win_id']==$val['member_one_id']){
										mysqli_query($con,'update ims_ewei_game_log set status=2 where status=0 and game_id='.$v['id'].' and member_id='.$val['member_two_id']);
									}else{
										mysqli_query($con,'update ims_ewei_game_log set status=2 where status=0 and game_id='.$v['id'].' and member_id='.$val['member_one_id']);
									}	
									var_dump($this->addmember($val['win_id'],$v['id'],$val['lun']+1));
									//修改游戏记录
								}
							}else{
								$code = rand(10000000,99999999);
								//修改游戏记录
								mysqli_query($con,'update ims_ewei_game_log set code='.$code.',ok_money='.$v['jiang'].' where status=0 and game_id='.$v['id'].' and member_id='.$val['win_id']);

								//查询记录id后创建二维码
								$log = mysqli_query($con,'select id,member_id,code from ims_ewei_game_log where game_id='.$v['id'].' and member_id='.$val['win_id'].' and status=0');
								$loginfo = mysqli_fetch_assoc($log);

								//增加用户获胜次数
								mysqli_query($con,'update ims_ewei_shop_member set win_num=win_num+1 where uid = '.$val['win_id']);
								$this->qrcode($loginfo);
								//生成兑奖二维码
								var_dump('select id,member_id,code from ims_ewei_game_log where game_id='.$v['id'].' and member_id='.$val['win_id'].' and status=0');

								$start = date('Y-m-d H:i:s',time()+$v['time_for']*60);

								//修改游戏设置
								if(!$v['time_for']){
									mysqli_query($con,'update ims_ewei_game_setting set jinxing=0,status=1,start_time="'.$start.'",ok_num=0,ok_money=0 where id='.$v['id']);
									
								}else{
									
									mysqli_query($con,'update ims_ewei_game_setting set jinxing=0,start_time="'.$start.'",ok_num=0,ok_money=0 where id='.$v['id']);
								}
								
								
								if($val['win_id']==$val['member_one_id']){
									mysqli_query($con,'update ims_ewei_game_log set status=2 where status=0 and game_id='.$v['id'].' and member_id='.$val['member_two_id']);
								}else{
									mysqli_query($con,'update ims_ewei_game_log set status=2 where status=0 and game_id='.$v['id'].' and member_id='.$val['member_one_id']);
								}	
								
							}
							
							mysqli_query($con,'update ims_ewei_game_member set status=2 where id='.$val['id']);
						}
					}
				}else{
					
					//触发条件
					$ok_where = json_decode($v['ok_where']);
					$ok_time = in_array('1',$ok_where)?1:0;
					$ok_price = in_array('2',$ok_where)?1:0;
					$ok_member = in_array('3',$ok_where)?1:0;

					$date = date('Y-m-d H:i:s',time()+3600);
					//延时时间
					$save_time = date("Y-m-d H:i:s",strtotime($v['start_time'])+$v['yan_time']*60);
					if($ok_time && $ok_price!=1 && $ok_member!=1 && strtotime($v['start_time'])<=time()){

						var_dump(1);
						$this->addauto($v['id']);
						mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
						$this->q($v['id']);
					}elseif($ok_time && $ok_price && $ok_member!=1 && strtotime($v['start_time'])<=time()){

						var_dump(2);
						if($v['ok_money']>=$v['money_min']){
							$this->addauto($v['id']);
							mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
							$this->q($v['id']);
						}else{
							mysqli_query($con,'update ims_ewei_game_setting set start_time="'.$save_time.'" where id='.$v["id"]);
						}
						
					}elseif($ok_time && $ok_price!=1 && $ok_member && strtotime($v['start_time'])<=time()){

						var_dump(3);
						if($v['member_min']<=$v['ok_num']){
							$this->addauto($v['id']);
							mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
							$this->q($v['id']);
						}else{
							mysqli_query($con,'update ims_ewei_game_setting set start_time="'.$save_time.'" where id='.$v["id"]);
						}
						
					}elseif($ok_time!=1 && $ok_price && $ok_member!=1 && $v['ok_money']>=$v['money_min']){

						var_dump(4);
						$this->addauto($v['id']);
						mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
						$this->q($v['id']);
					}elseif($ok_time!=1 && $ok_price && $ok_member && $v['ok_money']>=$v['money_min'] && $v['member_min']<=$v['ok_num']){

						var_dump(5);
						$this->addauto($v['id']);
						mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
						$this->q($v['id']);
					}elseif($ok_time && $ok_price && $ok_member && strtotime($v['start_time'])<=time()){

						var_dump(6);
						if($v['ok_money']>=$v['money_min'] && $v['member_min']<=$v['ok_num']){
							$this->addauto($v['id']);
							mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
							$this->q($v['id']);
						}else{
							mysqli_query($con,'update ims_ewei_game_setting set start_time="'.$save_time.'" where id='.$v["id"]);
						}	
						
					}elseif($ok_time!=1 && $ok_price!=1 && $ok_member && $v['member_min']<=$v['ok_num']){

						var_dump(7);
						$this->addauto($v['id']);
						mysqli_query($con,'update ims_ewei_game_setting set jinxing=1,start_time="'.$date.'" where id='.$v['id']);
						$this->q($v['id']);
					}
				}
			}
			
		    // sleep(1);// 休眠
		// }while(true);
	}


	public function addmember($id,$game_id,$lun){
		$con = $GLOBALS['con'];

		mysqli_query($con,'update ims_ewei_game_setting set start_time="'.date('Y-m-d H:i:s',time()+25).'" where id='.$game_id);

		//查询有没有下一轮未匹配成功的
		$info_data = mysqli_query($con,'select id,member_one_id,member_one_hand from ims_ewei_game_member where game_id='.$game_id.' and status=0 and lun='.$lun);
		$info = mysqli_fetch_assoc($info_data);
		$l= $lun-1;
		$sum = mysqli_query($con,'select count(*) from ims_ewei_game_member where lun='.$l.' and is_ping!=1 and game_id='.$game_id);
		$sum_info = mysqli_fetch_assoc($sum);

		$ran = rand(1,3);
		if(!$info){
			//添加下一轮数据 

			//如果为单数则添加一个机器人
			$false = mysqli_query($con,"select id from ims_ewei_game_member where is_false=1 and lun=".$lun);
			$false_info = mysqli_fetch_assoc($false);
			//查询是否已经添加过下一轮
			$is_bototm = mysqli_query($con,"select id from ims_ewei_game_member where game_id=".$game_id." and lun=".$lun." and (member_two_id=".$id." or member_one_id=".$id.")");
			$is_bototm_info = mysqli_fetch_assoc($is_bototm);

			if(!$false_info && $sum_info['count(*)']%2==1){
				var_dump(2);
				//添加机器人
				mysqli_query($con,'insert into ims_ewei_game_member(game_id,member_one_id,member_one_hand,lun,member_two_id,member_two_hand,is_false,status,win_id,end_time)value('.$game_id.','.$id.',1,'.$lun.',1,3,1,1,'.$id.','.$sum_info['count(*)'].')');
			}else{
				if(!$is_bototm_info){
					var_dump(3);
					mysqli_query($con,'insert into ims_ewei_game_member(game_id,member_one_id,member_one_hand,member_one_time,lun,end_time)value('.$game_id.','.$id.','.$ran.','.time().','.$lun.',11)');
				}
			}

		}else{

			//随机生成对手招数
			$in = array(1,2,3);
			$res = array_rand(array_diff($in,[$info['member_one_hand']]),1);
			$ree = $this->caiquan($info['member_one_hand'],$in[$res]);
			$win = $ree==1?$info['member_one_id']:$id;
			//查询是否为最后一轮
			$top_lun = $lun-1;
			$is_end = mysqli_query($con,'select count(*) from ims_ewei_game_member where lun='.$top_lun);
			$endinfo = mysqli_fetch_assoc($is_end);		
			$is_ok = $endinfo['count(*)']<=2?1:0;
			if($info['member_one_id']!=$id){
			
				//判断是不是最后一轮
				// if($is_ok==1){
				// 	//开始最后一轮业务代码
				// 	mysqli_query($con,'update ims_ewei_game_member set member_two_id='.$id.',member_two_time='.time().',status=2,member_two_hand='.$in[$res].',win_id='.$win.',is_ok='.$is_ok.'  where id='.$info['id']);
				// }else{
					mysqli_query($con,'update ims_ewei_game_member set member_two_id='.$id.',member_two_time='.time().',status=1,member_two_hand='.$in[$res].',win_id='.$win.',is_ok='.$is_ok.'  where id='.$info['id']);
				// }
			
			}
		}
	}

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

	public function qrcode($log){

		global $_W;
		global $_GPC;
		$con = $GLOBALS['con'];
		$qrcode =  m('qrcode')->createQrcode(mobileUrl('verify/gameinfo',array('id'=>$log['id']), true));
		mysqli_query($con,'update ims_ewei_game_log set code_img = "'.$qrcode.'",status=1 where id='.$log['id']);
		$arr['qrcode'] = $qrcode;
		$arr['code'] = $log['code'];
		$this->client($log['member_id'],$arr);
		return $log;

	}

	public function q($id){

		$con = $GLOBALS['con'];

		//检测有没有单人未匹配的
		$game_info = mysqli_query($con,'select start_time,jinxing from ims_ewei_game_setting where id='.$id);
		$game = mysqli_fetch_assoc($game_info);

		$member_info = mysqli_query($con,'select * from ims_ewei_game_member where game_id='.$id);
		$member = mysqli_fetch_all($member_info,MYSQLI_ASSOC);
		sleep(3);
		foreach($member as $k=>$v){
			$arr['save_time'] = $game['start_time'];
			$arr['jinxing'] = $game['jinxing'];
			$this->client($v['member_one_id'],$arr);
			$this->client($v['member_two_id'],$arr);
		}

	}

	//向客户端推送更新后的时间
	public function client($id,$arr){
		
		///workman 推送到客户端信息
		$client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1);
		// 推送的数据，包含uid字段，表示是给这个uid推送

		$data = array('uid'=>$id,'percent'=>json_encode($arr));

		// 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
		fwrite($client, json_encode($data)."\n");
		
	}

	public function addauto($id){
		$con = $GLOBALS['con'];
		$me = mysqli_query($con,'select * from ims_ewei_game_member where status=0 and game_id='.$id);
		$me_info = mysqli_fetch_all($me,MYSQLI_ASSOC);
		foreach($me_info as $k=>$v){
			switch ($v['member_one_hand']) {
				case '1':
					$hand = 3;
					break;
				case '2':
					$hand = 1;
					break;
				default:
					$hand = 2;
					break;
			}
			mysqli_query($con,'update ims_ewei_game_member set member_two_id=1,member_two_hand='.$hand.',status=1,win_id=member_one_id where status=0 and game_id='.$id.' and id='.$v['id']);
		}
	}

	// public function send($one_id,$two_id,$game){
	// 	$member = pdo_fetchall('select openid,uid from '.tablename('ewei_shop_member').' where uid='.$one_id.' or uid ='.$two_id);
	// 	$text = "您报名的".$game['game_name']."将在5分钟后开始,请及时登录活动界面进行查看！";
	// 	foreach($member as $k=>$v){
	// 		var_dump(m('message')->sendTexts($v['openid'], $text));
	// 	}
		
	// }
}


?>