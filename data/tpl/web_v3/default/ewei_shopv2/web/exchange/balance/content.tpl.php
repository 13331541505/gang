<?php defined('IN_IA') or exit('Access Denied');?><div class="page-header">
    当前位置：<span class="text-primary">余额兑换任务</span>
</div>
<div class="page-content" style="display: block;">
   <div class="page-toolbar m-b-sm m-t-sm" style="margin-bottom: 0">
        <div class="col-sm-4">
            <?php if(cv('exchange.balance.edit')) { ?>
                <span class="">
                    <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('exchange/balance/setting',array('id'=>0));?>"><i class="fa fa-plus"></i> 添加余额兑换任务</a>
                </span>
            <?php  } ?>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group">
                <input type="text" class="input-sm form-control" name="keyword" value="" placeholder="请输入关键词" id="keyword">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" id="so">搜索</button>
                </span>
            </div>
        </div>
    </div>
    <ul class="nav nav-arrow-next nav-tabs" id="myTab">
        <li <?php  if($_W['action'] == 'balance') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/balance')?>">进行中 (<span class="goods-ing"><?php  echo $allStart;?></span>)</a>
        </li>
        <li <?php  if($_W['action'] == 'balance.nostart') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/balance/nostart')?>">未开始 (<span class="goods-ing"><?php  echo $allNostart;?></span>)</a>
        </li>
        <li <?php  if($_W['action'] == 'balance.end') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/balance/end')?>">已结束 (<span class="goods-sold"><?php  echo $allEnd;?></span>)</a>
        </li>
    </ul>
    <script language="JavaScript" type="text/javascript">
        function clearNoNum(obj){
            obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
            obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
            obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
            obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
            if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
                obj.value= parseFloat(obj.value);
            }
        }

        $(document).ready($('#so').click(function () {
                    var v = $('#keyword').val();
                    var so_url = '<?php  echo webUrl("exchange/balance/search")?>';
                    var canshu = '&keyword='+v;
                    var so_url = so_url + canshu;
                    window.location.href = so_url;
                })
                );
    </script>
    <?php  if(count($list)>0) { ?>
    <form action="" method="post">
        <div class="page-table-header" style="border: none">
            <input type="checkbox">
            <div class="btn-group">
                <?php if(cv('exchange.balance.delete')) { ?>
                <button class="btn btn-default btn-sm btn-op btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除选中的商品吗?" data-href="<?php  echo webUrl('exchange/goods/delete');?>" disabled="disabled">
                    <i class="icow icow-shanchu1"></i> 删除
                </button>
                <?php  } ?>
            </div>
        </div>
        <table class="table table-hover table-responsive table_kf active" id="tab_sold"><thead>
        <tr>
            <th style="width:25px;"></th>
            <th style="width:60px;">排序</th>
            <th>兑换标题</th>
            <th >&nbsp;</th>
            <th>已兑/总量</th>
            <th >结束时间</th>
            <th class="text-center">类型</th>
            <th  class="text-center">状态</th>
            <th style="width: 95px;">操作</th>
        </tr>
        </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $key => $value) { ?>
            <tr>
                <!--<td colspan="10" style="text-align: center;">暂时没有任何商品!</td>-->
                <td><input type="checkbox" name="checkbox[]" value="<?php  echo $value['id'];?>" class="checkbox"></td>
                <td><?php  echo $key+$pstart+1;?></td>
                <td colspan="2"><a href="<?php  echo webUrl('exchange/balance/dno',array('id'=>$value['id']));?>"><?php  echo $value['title'];?></a></td>
                <td>
                    <?php  if($value['repeat'] >0) { ?>
                    <?php  echo $value['hadex'];?>/<?php  echo $value['allex'];?>
                    <?php  } else { ?>
                    <?php  echo $value['use'];?>/<?php  echo $value['total'];?>
                    <?php  } ?>
                </td>
                <td><?php  echo substr($value['endtime'],0,10);?></td>
                <td align="center">
                    <?php  if($value['type'] == 1) { ?><span class="label label-success">指定</span><?php  } ?>
                    <?php  if($value['type'] == 2) { ?><span class="label label-danger">随机</span><?php  } ?>
                    <?php  if($value['type'] == 3) { ?><span class="label label-primary">充值</span><?php  } ?>
                </td>
                <td  class="text-center">
                    <?php  if($_W['action']=='balance') { ?>
                    <span class="label <?php  if($value['status']==1) { ?>label-primary<?php  } else { ?>label-danger<?php  } ?>" data-toggle="ajaxSwitch" data-confirm="确认暂停此兑换活动？" data-switch-refresh="true" data-switch-value="<?php  echo $value['status'];?>" data-switch-value0="0|已暂停|label label-default|<?php  echo webUrl('exchange/balance/status',array('id'=>$value['id'],'status'=>0));?>" data-switch-value1="1|进行中|label label-success|<?php  echo webUrl('exchange/balance/status',array('id'=>$value['id'],'status'=>1));?>"><?php  if($value['status']==1) { ?>进行中<?php  } else { ?>已暂停<?php  } ?></span>
                    <?php  } ?>
                    <?php  if($_W['action']=='balance.nostart') { ?>
                    <span class="label label-warning" <?php if(cv('exchange.balance.status')) { ?>data-toggle="ajaxSwitch"<?php  } ?> data-confirm="确认立即开始此兑换活动？" data-switch-refresh="true" data-switch-value="1" data-switch-value0="">未开始</span>
                    <?php  } ?>
                    <?php  if($_W['action']=='balance.end') { ?>
                    <span class="label label" data-toggle="ajaxSwitch" data-confirm="确认再次开启兑换活动？" data-switch-refresh="true" data-switch-value="1" data-switch-value0="">已结束</span>
                    <?php  } ?>
                </td>
                <td>
                    <a class="btn btn-default btn-sm btn-op btn-operation" title="查看" href="<?php  echo webUrl('exchange/balance/dno',array('id'=>$value['id']));?>">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="查看兑换码">
                            <i class='icow icow-chakan-copy'></i>
                       </span>
                    </a>
                    <?php if(cv('exchange.balance.edit')) { ?>
                    <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('exchange/balance/setting',array('id'=>$value['id']));?>" title="编辑">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑">
                            <i class='icow icow-bianji2'></i>
                       </span>
                    </a>
                    <?php  } ?>
                    <?php if(cv('exchange.balance.delete')) { ?>
                    <a class="btn btn-default btn-sm btn-op btn-operation" data-toggle="ajaxRemove" href="<?php  echo webUrl('exchange/balance/delete',array('id'=>$value['id']));?>" data-confirm="确认删除此兑换组？">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                            <i class='icow icow-shanchu1'></i>
                       </span>
                    </a>
                    <?php  } ?>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <div class="btn-group">
                            <?php if(cv('exchange.balance.delete')) { ?>
                            <button class="btn btn-default btn-sm btn-op btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除选中的商品吗?" data-href="<?php  echo webUrl('exchange/goods/delete');?>" disabled="disabled">
                                <i class="icow icow-shanchu1"></i> 删除
                            </button>
                            <?php  } ?>
                        </div>
                    </td>
                    <td colspan="7" class="text-right"> <?php  echo $pager;?></td>
                </tr>
            </tfoot>
        </table>
    </form>
    <?php  } else { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">暂时没有任何兑换任务</div>
    </div>
    <?php  } ?>
</div>