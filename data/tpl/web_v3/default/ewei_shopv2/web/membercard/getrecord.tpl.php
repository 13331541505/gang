<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">会员卡领取记录</span>
</div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="membercard.getrecord" />
        <div class="page-toolbar m-b-sm m-t-sm">
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <div class="input-group-select">
                        <select name="enabled" class='form-control'>
                            <option value="" <?php  if($_GPC['enabled'] == '') { ?> selected<?php  } ?>>状态</option>
                            <option value="1" <?php  if($_GPC['enabled'] == '1') { ?> selected<?php  } ?>>使用中</option>
                            <option value="0" <?php  if($_GPC['enabled']== '0') { ?> selected<?php  } ?>>已过期</option>
                        </select>
                    </div>
                    <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button> </span>
                </div>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <?php  if($list) { ?>
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner">
                <tr style="background:#f8f8f8">
                    <th>客户信息</th>
                    <th>会员卡名称</th>
                    <th>创建时间</th>
                    <th>领取时间</th>
                    <th>有效期</th>
                    <th>价格</th>
                    <th>支付方式</th>
                </tr>
            </thead>
            <tbody id="sort">
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td>
                            <?php if(cv('member.list.detail')) { ?>
                            <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['mid']));?>" target='_blank'>
                                <img  class="radius50"  src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding:1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/>
                                <?php  if(strexists($row['openid'],'sns_wa')) { ?><i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="" data-original-title="来源: 小程序"></i><?php  } ?>
                                <?php  if(strexists($row['openid'],'sns_qq')||strexists($row['openid'],'sns_wx')||strexists($row['openid'],'wap_user')) { ?><i class="icow icow-app" style="color: #44abf7;vertical-align: top;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 全网通(<?php  if(strexists($row['openid'],'wap_user')) { ?>手机号注册<?php  } else { ?>APP<?php  } ?>)"></i><?php  } ?>
                                <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                            </a>
                            <?php  } else { ?>
                            <img  class="radius50"  src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'" />
                            <?php  if(strexists($row['openid'],'sns_wa')) { ?><i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="" data-original-title="来源: 小程序"></i><?php  } ?>
                            <?php  if(strexists($row['openid'],'sns_qq')||strexists($row['openid'],'sns_wx')||strexists($row['openid'],'wap_user')) { ?><i class="icow icow-app" style="color: #44abf7;vertical-align: top;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 全网通(<?php  if(strexists($row['openid'],'wap_user')) { ?>手机号注册<?php  } else { ?>APP<?php  } ?>)"></i><?php  } ?>
                            <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                            <?php  } ?>

                        </td>
                        <td><?php  echo $row['name'];?></td>
                        <td><?php  echo date('Y-m-d',$row['create_time'])?></td>
                        <td><?php  echo date('Y-m-d',$row['receive_time'])?></td>
                        <td>
                            <?php  if($row['expire_time']!='-1') { ?><?php  echo date('Y-m-d',$row['expire_time'])?><?php  } else { ?>永久有效<?php  } ?>
                        </td>
                        <td><?php  echo $row['price'];?></td>
                        <td>
                            <?php  if($row['pay_type']=='0') { ?>
                            <span> <i class="icow icow-yue text-warning" style="font-size: 17px;display:inline-block;height: 17px;width: 17px;padding-top: 3px"></i><span>余额支付</span></span>
                            <?php  } else if($row['pay_type']=='1') { ?>
                            <span> <i class="icow icow-weixin text-success" style="font-size: 17px"></i>微信支付</span>
                            <?php  } else if($row['pay_type']=='2') { ?>
                            <span><i class="icow icow-zhifubao text-primary" style="font-size: 17px"></i>支付宝支付</span>
                            <?php  } ?>
                        </td>
                    </tr>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
        <?php  } else { ?>
        <div class='panel panel-default'>
            <div class='panel-body' style='text-align: center;padding:30px;'>
                暂时没有任何领取记录
            </div>
        </div>
        <?php  } ?>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>