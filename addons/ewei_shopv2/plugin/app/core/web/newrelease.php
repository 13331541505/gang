<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('EWEI_SHOPV2_NEW_AUTH_WXAPP', 'http://wxapp.wemecms.com/index.php?s=wxapp/upload/shop&appname=ewei_shopv2');
!defined('SITE_ID') && define("SITE_ID",base64_encode($_SERVER["HTTP_HOST"]));
class Newrelease_EweiShopV2Page extends PluginWebPage
{
    private $key = 'asdf734JH3464tr56GJ';

    public function main()
    {
        global $_W;
        $error = NULL;
        $app_info = ihttp_post(EWEI_SHOPV2_NEW_AUTH_WXAPP . '&do=geteweiversion' , array('site_id' => SITE_ID, 'uniacid' => $_W['uniacid']));
        $app_info = json_decode($app_info['content'], true);
        $app_info['update_time'] = date('Y-m-d H:i:s', $app_info['update_time']);

        $log = pdo_fetchall('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc', array(':uniacid' => $_W['uniacid']));
        $test_code = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/test_code_' . $_W['uniacid'] . '.jpg';
        $version_time = 0;
        if (!(filemtime($test_code)) || ((filemtime($test_code) + 1490) < time())) {
            $is_expire = 1;
        } else {
            $version_time = filemtime($test_code);
        }
        $wxcode = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/wxcode_' . $_W['uniacid'] . '.jpg';
        if (!(filemtime($wxcode)) || ((filemtime($wxcode) + 7200) < time())) {
            $accessToken = $this->model->getAccessToken();
            if (is_error($accessToken)) {
                $error = $accessToken['message'];
            } else {
                load()->func('communication');
                $result = ihttp_post('https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $accessToken, json_encode(array(
                    'scene' => 'index',
                    'path' => 'pages/index/index'
                )));
                file_put_contents($wxcode, $result['content']);
            }
        }
        include $this->template();
    }

    public function upload()
    {
        global $_W;
        global $_GPC;
        $sets = m('common')->getSysset(array('app'));
        $appid = $sets['app']['appid'];
        $is_goods = $_GPC['is_goods'] ?  $_GPC['is_goods'] : 0;
        if (empty($appid)) {
            header('location: ' . webUrl('app/setting'));
        }

        $last_log = pdo_fetch('select * from ' . tablename('ewei_shop_upwxapp_log') . ' where uniacid=:uniacid and type=1 order by id desc limit 1', array(':uniacid' => $_W['uniacid']));
        @session_start();
        $ticket = $_SESSION['wxapp_new_ticket'];
        if (empty($ticket)) {
            $need_scan = 1;
            load()->func('communication');

            $tabBar = '';
            $app_set = m('common')->getSysset('app');

            if (!empty($app_set)) {
                if (!empty($app_set['tabbar'])) {
                    $app_set['tabbar'] = iunserializer($app_set['tabbar']);

                    if (!empty($app_set['tabbar'])) {
                        $tabBar = $app_set['tabbar'];
                    }
                }
            }

            if (is_array($tabBar)) {
                if (is_array($tabBar['list'])) {
                    foreach ($tabBar['list'] as $index => &$item) {
                        $item['pagePath'] = ltrim($item['pagePath'], '/');
                    }
                    unset($index);
                    unset($item);
                }
                $tabBar = json_encode($tabBar);
            }
            $appid = $app_set['appid'];

            $diy_str = '';
            $list = pdo_fetchall('SELECT `data` FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
            foreach ($list as $li) {
                $diy_str .= base64_decode($li['data']);
            }

            preg_match_all('/"appid:(\\w*)/', $diy_str, $appid_arr);
            $appIds = '';

            if (isset($appid_arr[1])) {
                $appIds = json_encode($appid_arr[1]);
            }

            $res = ihttp_post(EWEI_SHOPV2_NEW_AUTH_WXAPP . '&do=generate' , array('site_id' => SITE_ID, 'uniacid' => $_W['uniacid'], 'appid' => $appid, 'appIds' => $appIds, 'tabBar' => $tabBar, 'is_goods'=>$is_goods));
            $content = json_decode($res['content'], true);
            if (!empty($content)) {
                $uuid = $content['data']['uuid'];
                $qrcode = $content['data']['qrcode'];
                $code_token = $content['data']['code_token'];
            }
        }
        else {
            $need_scan = 0;
        }

        include $this->template();
    }

    public function getstatus()
    {
        global $_W;
        global $_GPC;
        load()->func('communication');
        $uuid = $_GPC['uuid'];
        $code_token = $_GPC['code_token'];

        if (empty($uuid)) {
            show_json(0);
        }

        $res = ihttp_get(EWEI_SHOPV2_NEW_AUTH_WXAPP . '&do=checkscan&site_id=' . SITE_ID . '&uuid=' . $uuid . '&code_token=' . $code_token . '&uniacid=' .  $_W['uniacid']);
        $content = json_decode($res['content'], true);

        if (empty($content['data']['status'])) {
            show_json(0);
        }

        show_json(1, array('wx_errcode' => $content['data']['wx_errcode'], 'wx_code' => $content['data']['wx_code']));
    }

    public function getticket()
    {
        global $_W;
        global $_GPC;
        load()->func('communication');
        $code = $_GPC['code'];
        $code_token = $_GPC['code_token'];
        if (empty($code)) {
            show_json(0);
        }

        $res = ihttp_get(EWEI_SHOPV2_NEW_AUTH_WXAPP . '&do=getticket&site_id=' . SITE_ID . '&code=' . $code . '&code_token=' . $code_token. '&uniacid=' .  $_W['uniacid']);
        $content = json_decode($res['content'], true);
        if (!empty($content['data']['status']) && !empty($content['data']['new_ticket'])) {
            @session_start();
            $_SESSION['wxapp_new_ticket'] = $content['data']['new_ticket'];
        }
        else {
            show_json(0, 'ticket获取失败');
        }

        show_json(1, array('new_ticket' => $content['data']['new_ticket']));
    }

    public function submit()
    {
        global $_W;
        global $_GPC;
        $uuid = $_GPC['uuid'];

        $version = $_GPC['version'];

        if (empty($version)) {
            show_json(0, '版本号不能为空！');
        }

        $describe = $_GPC['describe'];

        if (empty($describe)) {
            show_json(0, '版本描述不能为空！');
        }

        @session_start();
        $ticket = $_SESSION['wxapp_new_ticket'];

        if (empty($ticket)) {
            show_json(0, 'ticket为空，请刷新后重试！');
        }

        $tabBar = '';
        $app_set = m('common')->getSysset('app');

        if (!empty($app_set)) {
            if (!empty($app_set['tabbar'])) {
                $app_set['tabbar'] = iunserializer($app_set['tabbar']);

                if (!empty($app_set['tabbar'])) {
                    $tabBar = $app_set['tabbar'];
                }
            }
        }

        if (is_array($tabBar)) {
            if (is_array($tabBar['list'])) {
                foreach ($tabBar['list'] as $index => &$item) {
                    $item['pagePath'] = ltrim($item['pagePath'], '/');
                }

                unset($index);
                unset($item);
            }

            $tabBar = json_encode($tabBar);
        }
        $appid = $app_set['appid'];

        $diy_str = '';
        $list = pdo_fetchall('SELECT `data` FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));

        foreach ($list as $li) {
            $diy_str .= base64_decode($li['data']);
        }

        preg_match_all('/"appid:(\\w*)/', $diy_str, $appid_arr);
        $appIds = '';

        if (isset($appid_arr[1])) {
            $appIds = json_encode($appid_arr[1]);
        }

        $request = ihttp_post(EWEI_SHOPV2_NEW_AUTH_WXAPP . '&do=commitcode' , array('version' => $version, 'describe' => $describe, 'tabBar' => $tabBar, 'ticket' => $ticket, 'uuid' => $uuid, 'appid' => $appid , 'site_id' => SITE_ID,'uniacid' => $_W['uniacid'], 'appIds' => $appIds));
        if ($request['code'] != 200) {
            show_json(0, '信息查询失败！稍后重试(' . $request['code'] . ')');
        }

        if (empty($request['content'])) {
            show_json(0, '信息查询失败！稍后重试(nodata)');
        }

        $content = json_decode($request['content'], true);
        if (!is_array($content)) {
            show_json(0, '信息查询失败！稍后重试(dataerror)');
        }

        if ($content['status'] == 402 || $content['status'] == 403) {
            @session_start();
            $_SESSION['wxapp_new_ticket'] = NULL;
        }

        if ($content['status'] != 1) {
            show_json(0, $content['message']);
        }
        else {
            $data['uniacid'] = $_W['uniacid'];
            $data['type'] = 1;
            $data['version'] = $version;
            $data['describe'] = $describe;
            $data['version_time'] = time();
            pdo_insert('ewei_shop_upwxapp_log', $data);
            $wxcode = IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/test_code_' . $_W['uniacid'] . '.jpg';
            file_put_contents($wxcode, base64_decode($content['testcode']));
            show_json(1,$content);
        }
    }

    public function deletes()
    {
        global $_W;
        global $_GPC;
        @session_start();
        $_SESSION['wxapp_new_ticket'] = NULL;
    }

    public function wechatset()
    {
        include $this->template();
    }
}