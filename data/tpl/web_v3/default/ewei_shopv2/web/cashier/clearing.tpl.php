<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">收银台结算</span>
</div>
<div class="page-content">
    <form action="./cashier.php" method="get" class="form-horizontal table-search" role="form">
        <input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>" />
        <input type="hidden" name="r" value="clearing" />
        <div class="page-toolbar m-b-sm m-t-sm">
            <div class="col-sm-5">
                <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'按结算时间查询'),true);?>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <div class="input-group-select">
                        <select name='status'  class='form-control  input-sm select-md'   style="width:120px;">
                            <option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>结算状态</option>
                            <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>未结算</option>
                            <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>结算中</option>
                            <option value='2' <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?>>已结算</option>
                        </select>
                    </div>
                    <input type="text" class="form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="可搜索收银台名称/姓名/手机号/完整编号"/>
                     <span class="input-group-btn">
                         <button class="btn btn-primary" type="submit"> 搜索</button>
                         <!--<button type="submit" name="export" value="1" class="btn btn-success btn-sm">导出</button>-->
                    </span>
                </div>

            </div>
        </div>
    </form>

    <?php  if(count($list)>0) { ?>
    <table class="table table-hover table-responsive">
        <thead class="navbar-inner">
        <tr>
            <th style="width:200px;">结算编号</th>
            <th style="width:120px;">收银台信息</th>
            <th style="width:100px;">申请金额</th>
            <th style="width:120px;">申请时间</th>
            <th style="width:80px;">状态</th>
            <th style="width:40px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
            <td><?php  echo $row['clearno'];?></td>
            <td><?php  echo $row['name'];?><br/><?php  echo $row['mobile'];?></td>
            <td><?php  echo $row['money'];?>元</td>
            <td><?php  echo date('Y/m/d H:i',$row['createtime'])?></td>
            <td>
                <?php  if($row['status'] == '0') { ?>
                <label class="label label-default">待确认</label>
                <?php  } else if($row['status'] == '1') { ?>
                <label class="label label-warning">待结算</label>
                <?php  } else if($row['status'] == '2') { ?>
                <label class="label label-primary">已结算</label>
                <?php  } ?>


            </td>
            <td style="overflow:visible;">
                    <a class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('cashier/clearing/edit',array('id' => $row['id']))?>">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="详情">
                            <i class="icow icow-bianji2"></i>
                         </span>
                    </a>
            </td>
        </tr>
        <?php  } } ?>
        </tbody>
        <!--<tfoot>-->
            <!--<tr>-->
                <!--<td colspan="6" class="text-right">-->
                    <?php  echo $pager;?>
                <!--</td>-->
            <!--</tr>-->
        <!--</tfoot>-->
    </table>
    <?php  } else { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">暂时没有任何结算信息</div>
    </div>
    <?php  } ?>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
