<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">会员卡删除记录</span>
</div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="membercard.delrecord" />
        <div class="page-toolbar m-b-sm m-t-sm">
            <div class="col-sm-6 pull-right">
                <div class="input-group">
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
                <th>会员卡名称</th>
                <th>创建时间</th>
                <th>删除时间</th>
                <th>价格</th>
                <th>领取人数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="sort">
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <tr>
                <td><?php  echo $row['name'];?></td>
                <td><?php  echo date('Y-m-d H:i:s',$row['create_time'])?></td>
                <td><?php  echo date('Y-m-d H:i:s',$row['del_time'])?></td>
                <td><?php  echo $row['price'];?></td>
                <td>
                    <?php  echo $row['sale_count'];?>
                </td>
                <td>
                <?php if(cv('membercard.cardmanage.view')) { ?>
                <a href="<?php  echo webUrl('membercard/delrecord/view', array('id' => $row['id']))?>" class="btn btn-default btn-sm btn-op btn-operation">
                      <span data-toggle="tooltip" data-placement="top" title="" data-original-title="查看领取详情">
                       <i class='icow icow-chakan-copy'></i>
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
                暂时没有任何删除记录
            </div>
        </div>
        <?php  } ?>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>