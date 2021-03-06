<?php defined('IN_IA') or exit('Access Denied');?><style>
    #modModal .modal-body {padding: 10px 15px; min-height: 250px; overflow-y: auto}
    #modModal .btn {margin-bottom: 3px;}
    #modModal .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}
    #modModal .line .btn-sm {float: right; margin-top: 5px; height: 24px; line-height: 24px; padding: 0 10px;}
    #modModal .line .text {display: block;}
</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">选择公用模块</h4>
        </div>
        <div class="modal-body">
            <?php  if(empty($list)) { ?>
                <p style="line-height: 220px; text-align: center;">未查询到公用模块！</p>
            <?php  } else { ?>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <div class="line">
                        <nav title="选择" class="btn btn-default btn-sm" data-id="<?php  echo $item['id'];?>" data-name="<?php  echo $item['name'];?>">选择</nav>
                        <div class="text"><?php  echo $item['name'];?></div>
                    </div>
                <?php  } } ?>
            <?php  } ?>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">关闭</button>
        </div>
    </div>
</div>
