<?php 
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
//允许所有跨域请求，测试用，生产环境请使用具体域名代替
header('Access-Control-Allow-Origin:'.$origin);
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Headers:x-requested-with, content-type');


Class Api{

	public function __construct(){
		
		define('IN_IA',true);
		include("../data/config.php");
		$this->con =mysqli_connect('101.32.33.161',$config['db']['master']['username'],$config['db']['master']['password'],$config['db']['master']['database']);
		$this->config = $config;
		
	}

	public function ip(){
		$ip_white_list=array('192.168.1.30','192.168.1.24'); // IP白名单
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos=array_search('unknown',$arr);
			if(false!==$pos)unset($arr[$pos]);
			$ip=trim($arr[0]);
		}else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}else if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip=$_SERVER['REMOTE_ADDR'];
		}else if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip=$_SERVER['REMOTE_ADDR'];
		} else {
			$ip=null;
		}
		if(!in_array($ip,$ip_white_list)) { // 判断客户端IP是否在白名单中
			echo '<h1 align=center> HTTP/1.1 403 Forbidden</h1>';
			exit();
		}
	}

	public function index(){
		$this->ip();
		$game_info = mysqli_query($this->con,'select * from ims_ewei_game_setting');
		$game_list = mysqli_fetch_all($game_info,MYSQLI_ASSOC);
		foreach($game_list as $k=>$v){
			$game_list[$k]['game_img'] = "https://gang.jixunxi.com/attachment/".$v['game_img'];
			$game_list[$k]['goods_id'] = json_decode($v['goods_id']);
			$game_list[$k]['ok_where'] = json_decode($v['ok_where']);
		}
		return json_encode($game_list,JSON_UNESCAPED_UNICODE);
	}

	public function addGameMenber(){
		var_dump($_COOKIE);
	}



}