<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">游戏管理</span>
</div>
<div class="page-content">
    <form action="" method="get">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="game" />
        <div class="page-toolbar">
            <div class="col-sm-6">
                <?php if(cv('store.add')) { ?>
                <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('game/add')?>"><i class='fa fa-plus'></i> 添加游戏</a>
                <?php  } ?>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    
                    <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="游戏标题">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>

                    </div>
                </div>
            </div>
    </form>

    <?php  if(count($list)>0) { ?>
    
    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th style='width:'>序号</th>
                <th style=''>游戏标题</th>
                <th style="width:;">抽奖资格</th>
                <th style="width:;">人数上限</th>
                <th style="width:;">最低开奖人数</th>
                <th style="width:;">最低开奖金额</th>
                <th style="width:;">报名金额</th>
                <th style="width:;">开始时间</th>
                <th style="width:;">核销方式</th>
                <th style="width:;">触发条件</th>
                <th style="width:;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <tr>
                <td><?php  echo $row['id'];?></td>
                <td><?php  echo $row['game_name'];?></td>
                <td><?php  if($row['is_cash']==1) { ?>现金,<?php  } ?><?php  if($row['is_tong']==1) { ?>通用优惠券,<?php  } ?><?php  if($row['is_te']==1) { ?>特殊优惠券<?php  } ?></td>
                <td><?php  echo $row['member_max'];?></td>
                <td><?php  echo $row['member_min'];?></td>
                <td><?php  echo $row['money_min'];?></td>
                <td><?php  echo $row['game_money'];?></td>
                <td><?php  if($row['time_for']>0) { ?>每<?php  echo $row['time_for'];?>分钟循环一次<?php  } else { ?>$row['start_time']<?php  } ?></td>
                <td>
                    <span class='label <?php  if($row['hexiao']==1) { ?>label-success<?php  } else { ?>label-primary<?php  } ?>' <?php if(cv('store.edit' )) { ?> data-toggle='ajaxSwitch' data-switch-value='{$row[' hexiao']}' data-switch-value0='0|线上核销|label label-default|<?php  echo webUrl(' game/hexiao',array('hexiao'=>1,'id'=>$row['id']))?>' data-switch-value1='1|线下核销|label label-success|<?php  echo webUrl(' game/hexiao',array('hexiao'=>0,'id'=>$row['id']))?>' <?php  } ?>>
                        <?php  if($row['hexiao']==1) { ?>线下核销<?php  } else { ?>线上核销<?php  } ?></span>
                </td>

                <td><?php  if(in_array(1,json_decode($row['ok_where']))) { ?>开始时间,<?php  } ?><?php  if(in_array(2,json_decode($row['ok_where']))) { ?>最低开奖金额,<?php  } ?><?php  if(in_array(3,json_decode($row['ok_where']))) { ?>最低开奖人数<?php  } ?>
                </td>

                <td>
                    <?php  if(p('newstore')) { ?>
                    <a class='btn btn-default  btn-sm btn-op btn-operation' href="<?php  echo webUrl('store/goods', array('id' => $row['id']))?>">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="商品">
                            <i class='icow icow-goods'></i>
                        </span>
                    </a>
                    <?php  } ?>
                    <?php if(cv('store.edit|store.view')) { ?>
                    <a class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('game/edit', array('id' => $row['id']))?>">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('shop.verify.store.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                            <?php if(cv('shop.verify.store.edit')) { ?>
                            <i class="icow icow-bianji2"></i>
                            <?php  } else { ?>
                            <i class="icow icow-chakan-copy"></i>
                            <?php  } ?>
                        </span>
                    </a>
                    <?php  } ?>
                    <?php  if(p('newstore')) { ?>
                    <?php if(cv('store.diypage')) { ?>
                    <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('store/diypage/settings', array('id'=>$row['id']))?>">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="装修">
                            <i class='icow icow-mendianzhuangxiu' style="font-weight: bolder"></i>
                        </span>
                    </a>
                    <?php  } ?>
                    <?php  } ?>
                    <a class='btn btn-default  btn-sm btn-op btn-operation' data-toggle="ajaxRemove" href="<?php  echo webUrl('game/delete', array('id' => $row['id']))?>" data-confirm="确认删除此门店吗？">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                            <i class='icow icow-shanchu1'></i>
                        </span>
                    </a>
                    
                </td>

            </tr>
            <?php  } } ?>
        </tbody>
        
    </table>

    </form>


    <?php  } else { ?>
    <div class='panel panel-default'>
        <div class='panel-body' style='text-align: center;padding:30px;'>
            暂时没有任何门店!
        </div>
    </div>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>