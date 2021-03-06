<?php defined('IN_IA') or exit('Access Denied');?><div class='fui-content params-block nofixed'>
    <div class="inner">

        <div class="param-item param-level">
            <div class="fui-title">会员等级</div>
            <div class="fui-cell-group fui-cell-click">
                <div class="fui-cell submit-params" data-value="0">
                    <div class="fui-cell-text"><?php echo empty($shop['levelname'])?'普通会员':$shop['levelname']?></div>
                    <div class="fui-cell-remark">选择</div>
                </div>
                <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                    <div class="fui-cell submit-params" data-value="<?php  echo $level['id'];?>">
                        <div class="fui-cell-text"><?php  echo $level['levelname'];?></div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                <?php  } } ?>
            </div>
        </div>

        <div class="param-item param-group">
            <div class="fui-title">会员分组</div>
            <div class="fui-cell-group fui-cell-click">
                <div class="fui-cell submit-params" data-value="0">
                    <div class="fui-cell-text">未分组</div>
                    <div class="fui-cell-remark">选择</div>
                </div>
                <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                    <div class="fui-cell submit-params" data-value="<?php  echo $group['id'];?>">
                        <div class="fui-cell-text"><?php  echo $group['groupname'];?></div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                <?php  } } ?>
            </div>
        </div>

        <?php  if($hascommission) { ?>
            <div class="param-item param-agentlevel">
                <div class="fui-title">分销商等级</div>
                <div class="fui-cell-group fui-cell-click">
                    <div class="fui-cell submit-params" data-value="0">
                        <div class="fui-cell-text"><?php echo empty($plugin_com_set['levelname'])?'普通等级':$plugin_com_set['levelname']?></div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                    <?php  if(is_array($agentlevels)) { foreach($agentlevels as $agentlevel) { ?>
                        <div class="fui-cell submit-params" data-value="<?php  echo $agentlevel['id'];?>">
                            <div class="fui-cell-text"><?php  echo $agentlevel['levelname'];?></div>
                            <div class="fui-cell-remark">选择</div>
                        </div>
                    <?php  } } ?>
                </div>
            </div>

            <div class="param-item param-goods">
                <div class="fui-title">自选商品设置</div>
                <div class="fui-cell-group fui-cell-click">
                    <div class="fui-cell submit-params" data-value="0">
                        <div class="fui-cell-text">系统设置</div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                    <div class="fui-cell submit-params" data-value="1">
                        <div class="fui-cell-text">强制禁止</div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                    <div class="fui-cell submit-params" data-value="2">
                        <div class="fui-cell-text">强制开启</div>
                        <div class="fui-cell-remark">选择</div>
                    </div>
                </div>
            </div>
        <?php  } ?>

    </div>

    <div class="fui-navbar">
        <div class="nav-item btn btn-success submit-params">确定</div>
        <div class="nav-item btn btn-gray cancel-params">取消</div>
    </div>
</div>
