<?php
/**
 * 拿来即用的token类
 * user Yang
 * QQ   952323608
 * wechat  ygy952323608
 * tip:此类与传统的token有点不一样，创建token时会返回一个值，一个是tokenname 一个是onlykey 检查是否有效时，需要两个值都进行传入
 */
class Token_EweiShopV2Page extends MobilePage
{
    private $redis;
    private $maxNum = 3;//可同时在线人数
    private $continueLife = false;//在检查token有效后，是否自动延长token的有效期
    private $resetKey = true;//在检查有效后，是否自动将其移动到队列末端
    private $config = array(
        'tokenTiming'=>3600*24*14,//token有效期
        'secret'=>'Hkasnu765./HBViasp;.12',//秘钥请勿泄露
        'tokenPrefix'=>'tokenOnlyYang',//token前缀，保证redis的key值不被覆盖   此项请勿随意修改，否则会影响 destructToken 方法的有效性
    );
    private $randLength = 35;//获取token时，onlykey的长度
    //public $errTip = false;//挤退是否进行提醒---待开发  被挤退后对 onlykey 进行一定时间内的缓存，保存被挤退的状态
    /**
     * 可闯入config设置项来区别不同类型的 token 避免token重名
     */
    public function __construct($config=[])
    {
        $this->redis = getRedis();
        if ($this->maxNum<=0 || !is_numeric($this->maxNum)){
            $this->maxNum = 1;
        }
        if ($this->maxNum>=20){
            $this->maxNum = 20;
        }
        if (!empty($config)){
            isset($config['maxNum']) && $this->maxNum = $config['maxNum'];
            isset($config['continueLife']) && $this->continueLife = $config['continueLife'];
            isset($config['resetKey']) && $this->resetKey = $config['resetKey'];
            isset($config['config']) && $this->config = $config['config'];
            isset($config['randLength']) && $this->randLength = $config['randLength'];
        }
 
    }
    
    public function index(){
        //使用方法
        $uid = 1000;
        echo 123;die;
        $tokenArr = $this->createToken($uid);//新建token 必须保证uid是唯一的，如用户id
        $this->checkTokenStatus($tokenArr['token'],$tokenArr['onlykey'],true);//检查token是否有效，无效为false 有效则返回true或token保存的信息 

    }
    /**
     * 获取当前redis连接柄
     */
    public function getRedisConnect(){
        return $this->redis;
    }
 
    /**
     * 获取指定唯一值的token值
     */
    private function tokenName($onlyKey){
        return ($this->config['tokenPrefix']).$onlyKey.'_token';
    }
    /**
     * 创建token
     * @param  string $onlykey 创建的唯一值，保证每个用户对应的唯一性 如uid
     */
    public function createToken($onlyKey){
        $tokenName = $this->tokenName($onlyKey);
        $randStr = md5(getRandomStr($this->randLength,false).$this->config['secret']);//随机字符，用于挤兑下线
        $this->checkTokenLife($tokenName);
        $token_info = $this->redis->get($tokenName);
        $token_list = empty($token_info)?[]:json_decode($token_info,true);
        $num = count($token_list);
        $token_list[$num]['lifetime'] = time()+$this->config['tokenTiming'];
        $token_list[$num]['randstr'] = $randStr;
        $this->redis->set($tokenName,json_encode($token_list),$this->config['tokenTiming']);
        $this->checkMaxOnline($tokenName);
        $this->checkMaxLife($tokenName);
        return array(
            'token'=>$tokenName,
            'onlykey'=>$randStr
        );
    }
 
    /**
     * 处理token的过期数据
     * @param string $tokenName 令牌名称
     */
    private function checkTokenLife($tokenName){
        $token_strlist = array();
        $list_str = $this->redis->get($tokenName);
        !empty($list_str) && $token_strlist = json_decode($list_str,true);
        foreach ($token_strlist as $tk=>$tv){
            if ($tv['lifetime']<time()){
                unset($token_strlist[$tk]);
            }
        }
        $token_strlist = array_values($token_strlist);
        if (empty($token_strlist)){
            $this->redis->del($tokenName);
        }else{
            $this->redis->set($tokenName,json_encode($token_strlist));
            $this->checkMaxLife($tokenName);
        }
        return true;
    }
 
    /**
     * 检查同时在线人数限制
     * @param string $tokenName 检查的tokenname
     */
    private function checkMaxOnline($tokenName){
        $token_result = $this->redis->get($tokenName);
 
        $token_list = empty($token_result)?[]:json_decode($token_result,true);
        while (count($token_list)>$this->maxNum){
            //大于最多允许在线人数
            array_shift($token_list);
        }
        $new_list = array_values($token_list);
        $this->redis->set($tokenName,json_encode($new_list));
        return true;
    }
 
    /**
     * 检查token及onlykey是否合法
     * @param string $token
     * @param string $onlykey createToken处返回的onlykey
     * @param string $getInfo 是否同时返回数据
     * @return bool/array
     */
    public function checkTokenStatus($tokenName,$randStr,$getInfo=false){
        $this->checkMaxOnline($tokenName);
        $this->checkTokenLife($tokenName);
        $token_rs = $this->redis->get($tokenName);
        if (empty($token_rs)){
            return false;
        }
        $token_list = empty($token_rs)?[]:json_decode($token_rs,true);
        foreach ($token_list as $tk=>$tv){
            if ($tv['randstr'] == $randStr){
                $this->continueLife === true && $token_list[$tk]['lifetime'] = time()+$this->config['tokenTiming'];//自动延期
                if ($this->resetKey === true){
                    //重置key
                    $token_list[count($token_list)] = $token_list[$tk];
                    unset($token_list[$tk]);
                    $token_list = array_values($token_list);
                }
                $this->redis->set($tokenName,json_encode($token_list));
                $this->checkMaxLife($tokenName);
                if ($getInfo === false){
                    return true;
                }else{
                    $info = !isset($tv['info'])||empty($tv['info'])?[]:json_decode($tv['info'],true);
                    return $info;
                }
            }
        }
        return false;
    }
 
    /**
     * 设置数据
     * @param string $tokenName token名
     * @param string $onlyKey 唯一标识
     * @param string $key 设置key
     * @param string/array $value 设置value
     * @param bool $allset 是否所有token 列表的所有者都设置
     * @return bool
     */
    public function setTokenInfo($tokenName,$onlyKey,$key,$value,$allset=true){
        if ($key == 'lifetime' || $key == 'randstr'){
            return false;//配置项不可修改
        }
        $old_continueLife = $this->continueLife;
        $old_resetKey = $this->resetKey;
        $this->continueLife = false;
        $this->resetKey = false;
        $status = $this->checkTokenStatus($tokenName,$onlyKey,false);
        $this->continueLife = $old_continueLife;
        $this->resetKey = $old_resetKey;
        if ($status === true){
            $token_list = json_decode($this->redis->get($tokenName),true);
            foreach ($token_list as $tk=>$tv){
                if ($allset == true){
                    $token_list[$tk][$key] = $value;
                }else{
                    if ($tv['randstr'] == $onlyKey){
                        $token_list[$tk][$key] = $value;
                        break;
                    }
                }
            }
            $this->redis->set($tokenName,json_encode($token_list));
            $this->checkMaxLife($tokenName);
            return true;
        }else{
            return false;
        }
    }
 
    /**
     * 删除数据
     * @param string $tokenName token名
     * @param string $onlyKey 唯一标识
     * @param string $key 设置key
     * @param bool $allset 是否所有token 列表的所有者都删除
     * @return bool
     */
    public function removeTokenInfo($tokenName,$onlyKey,$key,$allset=true){
        if ($key == 'lifetime' || $key == 'randstr'){
            return false;//配置项不可修改
        }
        $old_continueLife = $this->continueLife;
        $old_resetKey = $this->resetKey;
        $this->continueLife = false;
        $this->resetKey = false;
        $status = $this->checkTokenStatus($tokenName,$onlyKey,false);
        $this->continueLife = $old_continueLife;
        $this->resetKey = $old_resetKey;
        if ($status === true){
            $token_list = json_decode($this->redis->get($tokenName),true);
            foreach ($token_list as $tk=>$tv){
                if ($allset == true){
                    unset($token_list[$tk][$key]);
                }else{
                    if ($tv['randstr'] == $onlyKey){
                        unset($token_list[$tk][$key]);
                        break;
                    }
                }
            }
            $this->redis->set($tokenName,json_encode($token_list));
            $this->checkMaxLife($tokenName);
            return true;
        }else{
            return false;
        }
    }
 
    /**
     * 获取数据
     * @param string $tokenName token名
     * @param string $onlyKey 唯一标识
     * @param string $key 获取key
     * @return string
     */
    public function getTokenInfo($tokenName,$onlyKey,$key){
        $old_continueLife = $this->continueLife;
        $old_resetKey = $this->resetKey;
        $this->continueLife = false;
        $this->resetKey = false;
        $status = $this->checkTokenStatus($tokenName,$onlyKey,false);
        $this->continueLife = $old_continueLife;
        $this->resetKey = $old_resetKey;
        if ($status === true){
            $token_list = json_decode($this->redis->get($tokenName),true);
            foreach ($token_list as $tk=>$tv){
                if ($tv['randstr'] == $onlyKey){
                    return isset($tv[$key])?$tv[$key]:'';
                }
            }
            $this->redis->set($tokenName,json_encode($token_list));
            $this->checkMaxLife($tokenName);
            return true;
        }else{
            return false;
        }
    }
 
    /**
     * 检查token的最长周期
     */
    private function checkMaxLife($tokenName){
        $token_rs = $this->redis->get($tokenName);
        if (empty($token_rs)){
            return true;
        }
        $token_list = json_decode($token_rs,true);
        $max_lifetime = 0;
        foreach ($token_list as $tk=>$tv){
            if ($tv['lifetime']>$max_lifetime){
                $max_lifetime = $tv['lifetime']-time();
            }
        }
        if ($max_lifetime<=0){
            $this->redis->del($tokenName);
        }else{
            $this->redis->set($tokenName,json_encode($token_list),$max_lifetime);
        }
        return true;
    }
 
    /**
     * 设置配置项
     */
    public function setConfig($key,$value){
        $this->$key = $value;
    }
 
    /**
     * 销毁token  修改密码时使用
     */
    public function destructToken($tokenName){
        $this->redis->del($tokenName);
    }
}
 
 