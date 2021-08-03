<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .table_kf {display: none;width:100%}
    .table_kf.active {display: table;}
    .pagination{
        margin-top: 20px;
    }
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/membercard/static/css/common.css">
<div class="page-header">
    当前位置：<span class="text-primary">会员卡管理</span>
</div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal" plugins="form">
        <input type='hidden' id='tab' name='type' value="<?php  echo $_GPC['type'];?>"/>
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="membercard.cardmanage"/>
        <div class="page-toolbar m-b-sm m-t-sm">
            <div class="col-sm-6">
                <span class='pull-left'>
                <?php if(cv('membercard.cardmanage.add')) { ?>
                    <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('membercard/cardmanage/add')?>"><i class='fa fa-plus'></i> 创建会员卡</a>
                <?php  } ?>
               </span>
                &nbsp;
               <!-- <span class="btn btn-default btn-sm cutlist-card">列表模式</span>-->


                <span class='btn btn-default btn-sm cutlist-card '
                <?php if(cv('membercard.cardmanage.edit')) { ?>
                data-toggle='ajaxSwitch'
                data-switch-value='<?php  echo $view;?>'
                data-switch-value0='gird|缩略图模式|btn btn-default btn-sm cutlist-card|<?php  echo webUrl('membercard/cardmanage/enabled',array('view'=>'list'))?>'
                data-switch-value1='list|列表模式|btn btn-default btn-sm cutlist-card|<?php  echo webUrl('membercard/cardmanage/enabled',array('view'=>'gird'))?>'
                <?php  } ?>
                >
                <?php  if($view=='gird') { ?>缩略图模式<?php  } else { ?>列表模式<?php  } ?></span>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <div class="input-group-select">
                        <select name='status' class='form-control  input-sm' style='width:100px;'>
                            <option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>发卡状态</option>
                            <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>启用</option>
                            <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?> >停发</option>
                        </select>
                    </div>
                    <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">搜索</button>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <!--卡片式 缩略图样式 start-->
    <div class="card-group-list">
        <?php  if($list) { ?>
        <div class="card-group">
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <div class="card-list-item <?php  echo $row['card_style'];?>">
                <i class="iconbg icow icow-huangguan-copy"></i>
                <div class="line"></div>
                <div class="content">
                    <div class="content-title">
                        <div class="title-l"><img src="../addons/ewei_shopv2/static/images/ic_member.png" width="18px" height="18px" style="margin-right: 10px;position: relative;top: -2px;"><?php  echo $row['name'];?></div>
                        <div class="title-r"><?php  echo $row['sale_count'];?>/<?php  echo $row['stock']+$row['sale_count']?></div>
                    </div>
                    <div class="price"><?php  echo $row['price'];?>元</div>
                    <div class="date">有效期：<?php  if($row['validate']!='-1') { ?><?php  echo $row['validate'];?>个月<?php  } else { ?>永久<?php  } ?></div>
                    <div class="equity"><?php  echo $row['equity'];?></div>
                </div>
                <div class="status">
                    <div class="status-icon"><img src="../addons/ewei_shopv2/static/images/ic_unissued.png" width="16px" height="16px" style="margin-right: 10px;position: relative;top: -2px;"><?php  if($row['status']==1) { ?>使用中<?php  } else { ?>未发放<?php  } ?></div>
                    <div class="status-btn">
                        <?php if(cv('membercard.cardmanage.edit')) { ?>
                            <div class="item btn-edit">  <a href="<?php  echo webUrl('membercard/cardmanage/edit', array('id' => $row['id']))?>" style="color: #fff">编辑 </a></div>
                        <?php  } ?>
                        <?php  if($row['status']==0) { ?>
                            <?php if(cv('membercard.cardmanage.status')) { ?>
                            <div class="item btn-pause"><a  style="color: #fff" data-toggle='batch' data-href="<?php  echo webUrl('membercard/cardmanage/status',array('id' => $row['id'],'status'=>1))?>" data-confirm='确认要启用这张会员卡吗'>启用</a>
                            </div>
                            <?php  } else { ?>
                            <div class="item btn-pause">启用</div>
                            <?php  } ?>
                        <?php  } ?>
                        <?php  if($row['status']==1) { ?>
                            <?php if(cv('membercard.cardmanage.status')) { ?>
                            <div class="item btn-pause"><a  style="color: #fff" data-toggle='batch' data-href="<?php  echo webUrl('membercard/cardmanage/status',array('id' => $row['id'],'status'=>0))?>" data-confirm='确认要停发这张会员卡吗?停发之后这张卡暂停发放'>停发</a>
                            </div>
                            <?php  } else { ?>
                            <div class="item btn-pause">停发</div>
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
                <?php  if($row['status']==0) { ?>
                <div class="paused">
                    <div class="text">已停发</div>
                </div>
                <?php  } ?>
            </div>
       <?php  } } ?>
        </div>
        <?php  echo $pager;?>
        <?php  } else { ?>
        <div class='panel panel-default'>
            <div class='panel-body' style='text-align: center;padding:30px;'>
                暂时没有任何会员卡记录
            </div>
        </div>
        <?php  } ?>
    </div>

    <!--卡片式 列表样式 end-->
    <form action="" method="post" class="list-group">
        <?php  if($list) { ?>
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner">
                <tr style="background:#f8f8f8">
                    <th style='width:80px'>排序</th>
                    <th>会员卡名称</th>
                    <th>创建时间</th>
                    <th>有效期</th>
                    <th>价格</th>
                    <th>折扣</th>
                    <th>领取情况</th>
                    <th style="width: 100px;">状态</th>
                    <th style="width: 65px;">操作</th>
                </tr>
            </thead>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <tbody id="sort">
            <tr>
                <td><?php  echo $row['sort_order'];?></td>
                <td><?php  echo $row['name'];?></td>
                <td><?php  echo  date('Y-m-d H:i:s',$row['create_time'])?></td>
                <td><?php  if($row['validate']!='-1') { ?><?php  echo $row['validate'];?>个月<?php  } else { ?>永久<?php  } ?></td>
                <td><?php  echo $row['price'];?></td>
                <td>
                    <?php  if($row['member_discount']) { ?>
                        <?php  echo $row['discount_rate'];?>折
                    <?php  } else { ?>
                        ----
                    <?php  } ?>
                </td>
                <td><?php  echo $row['sale_count'];?>/<?php  echo $row['stock']+$row['sale_count']?></td>
                <td>

                <span class='label <?php  if($row['status']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>'
                <?php if(cv('membercard.cardmanage.status')) { ?>
                data-toggle='ajaxSwitch'
                data-switch-value='<?php  echo $row['status'];?>'
                <?php  if($row['status']==1) { ?> data-confirm='确认要停发这张会员卡吗' <?php  } else { ?> data-confirm='确认要启用这张会员卡吗' <?php  } ?>
                data-switch-value0='0|停发|label label-default|<?php  echo webUrl('membercard/cardmanage/status',array('id' => $row['id'],'status'=>1))?>'
                data-switch-value1='1|启用|label label-success|<?php  echo webUrl('membercard/cardmanage/status',array('id' => $row['id'],'status'=>0))?>'
                <?php  } ?>
                >
                <?php  if($row['status']==1) { ?>启用<?php  } else { ?>停发<?php  } ?></span>
                </td>
                <td style="text-align:left;">
                    <?php if(cv('membercard.cardmanage.view|membercard.cardmanage.edit')) { ?>
                    <a href="<?php  echo webUrl('membercard/cardmanage/edit', array('id' => $row['id']))?>" class="btn btn-default btn-sm btn-op btn-operation">
                                  <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('groups.category.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">
                                   <?php if(cv('membercard.cardmanage.edit')) { ?>
                                        <i class='icow icow-bianji2'></i>
                                    <?php  } else { ?>
                                        <i class='icow icow-chakan-copy'></i>
                                    <?php  } ?>
                               </span>
                    </a>
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
                暂时没有任何会员卡记录
            </div>
        </div>
        <?php  } ?>
    </form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<script>
$(document).ready(function () {
    var view='<?php  echo $view;?>';
    if(view=='list'){
        $('.card-group-list').toggleClass('in');
        $('.list-group').toggleClass('none');
    }else{
        $('.card-group-list').removeClass('in');
        $('.list-group').removeClass('none');
    }
})


    console.log(localStorage.disp);
    myrequire(['../../plugin/membercard/static/js/cardmanage'], function (modal) {
        modal.init();
    });
</script>