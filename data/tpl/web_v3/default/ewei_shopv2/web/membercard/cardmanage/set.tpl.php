<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label must" style="padding-top: 12px;">有效期</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="validity" value="1" <?php  if($item['validate'] >0) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> />
            <input type="text" name="validate" class="form-control" <?php  if($item['validate'] >0) { ?> value="<?php  echo $item['validate'];?>" <?php  } ?> style="width:120px;display: inline;margin-right: 5px;" aria-invalid="false" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?>>
            个月
        </label>
        <label class="radio-inline">
            <input type="radio" name="validity" value="2" <?php  if($item['validate'] == -1) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> /> 永久有效
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($item['validate'] > 0) { ?><?php  echo $item['validate'];?>个月<?php  } else { ?>永久有效<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">价格</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <div class="input-group fixsingle-input-group">
            <input type="text" name="price" class="form-control" value="<?php  echo $item['price'];?>" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?> />
            <span class="input-group-addon">元</span>
        </div>
        <span class='help-block'>用户购买会员卡需要支付的金额 , 不填或填0用户将可以免费领取</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['price'];?> 元</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">库存</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <div class="input-group fixsingle-input-group">
            <input type='text' class="form-control" name='stock' value='<?php  echo $item['stock'];?>' />
        </div>
        <span class='help-block'>会员卡剩余可以领取的数量</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['stock'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">状态</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="status" value="1" <?php  if($item['status'] == 1) { ?>checked="true"<?php  } ?>  /> 启用
        </label>
        <label class="radio-inline">
            <input type="radio" name="status" value="0" <?php  if(empty($item['status']) ) { ?>checked="true"<?php  } ?>  /> 停发
        </label>
        <?php  if(!empty($_GPC['id'])) { ?>
        <span class='help-block' style="color: #f00;<?php  if($item['status'] == 1) { ?>display: none;<?php  } ?>" id="status_help">停发后 , 会员卡不再发放 , 已经够购买领取的可以继续使用不受影响</span>
        <?php  } ?>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if(empty($item['status'])) { ?>停发<?php  } else { ?>启用<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label must">使用须知</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <textarea name="description" class="form-control" rows="10" data-rule-required="true" aria-required="true"><?php  echo $item['description'];?></textarea>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['description'];?></div>
        <?php  } ?>
    </div>
</div>
<!--
<div class="form-group">
    <label class="col-lg control-label">客服电话</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <input type='text' class="form-control" name='kefu_tel' value='<?php  echo $item['kefu_tel'];?>' />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['kefu_tel'];?></div>
        <?php  } ?>
    </div>
</div>-->

<script type="text/javascript">
    $(function(){
        $("input[name='status']").click(function(){
            if(this.value == 0){
                $("#status_help").show()
            }else{
                $("#status_help").hide();
            }
        });
    });


</script>
