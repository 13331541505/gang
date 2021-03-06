<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">

    .full>span{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        vertical-align: middle;
        align-items: center;

        word-break: break-all;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

</style>
<div class="page-header">当前位置：<span class="text-primary"><?php  if($type=='credit1') { ?>积分<?php  } else { ?>余额<?php  } ?>明细</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="finance.credit.<?php  echo $type;?>" />
        <div class="page-toolbar">
            <div class="input-group">
                <span class="pull-left">
                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'操作时间'),true);?>
                </span>
                <span class="input-group-select">
                    <select name="groupid" class="form-control" style="width:100px;float: left;"  >
                        <option value="">会员分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value="<?php  echo $group['id'];?>" <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="level" class="form-control" style="width:100px;float: left;"  >
                        <option value="">会员等级</option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <input type="text" class="form-control "  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入会员信息/操作人信息" />
                <span class="input-group-btn">
                    <button class="btn  btn-primary" type="submit"> 搜索</button>
                    <?php  if($type=='credit1') { ?>
                        <?php if(cv('finance.credit.credit1.export')) { ?>
                        <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>
                        <?php  } ?>
                    <?php  } else { ?>
                        <?php if(cv('finance.credit.credit2.export')) { ?>
                        <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>
                        <?php  } ?>
                    <?php  } ?>
                </span>
            </div>
        </div>
    </form>
    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead class="navbar-inner">
                <tr>
                    <th style='width:120px;'>粉丝</th>
                    <th style='width:100px;'>会员信息</th>
                    <th style='width:80px;'><?php  if($type=='credit1') { ?>积分<?php  } else { ?>余额<?php  } ?>变化</th>
                    <th style='width:80px;'><?php  if($type=='credit1') { ?>当前积分<?php  } else { ?>当前余额<?php  } ?></th>
                    <th style='width:80px;'>备注</th>
                    <th style='width:80px;'>操作人</th>
                    <th style='width:100px;'>操作时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr >
                    <td>
                    <?php if(cv('member.list.edit')) { ?>
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
                    <td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>
                    <td><?php  echo $row['num'];?></td>
                    <td><?php  echo $row['presentcredit'];?></td>
                    <td  class="full"  data-toggle='popover' data-html='true' data-placement='top' data-trigger='hover' data-content='<?php  echo $row['remark'];?>'><span><?php  echo $row['remark'];?></span></td>
                    <td>
                        <?php  if(empty($row['username']) || $row['username']=='wechat' || $row['username']=='alipay' || $row['username']=='wxapp') { ?>
                            本人
                        <?php  } else { ?>
                            <?php  echo $row['username'];?>
                        <?php  } ?>
                    </td>
                    <td><?php  echo date('Y-m-d H:i:s',$row['createtime'])?></td>
                </tr>
                <?php  } } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <div class="btn-group"></div>
                    </td>
                    <td colspan="5" style="text-align: right">
                        <?php  echo $pager;?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>