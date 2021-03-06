<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：
    <span class="text-primary">基础设置</span>
</div>
<div class="page-content">
    <form id="setform"  action="" method="post" class="form-horizontal form-validate">
        <input type="hidden" id="tab" name="tab" value="<?php  echo $_GPC['tab'];?>" />
        <ul class="nav nav-tabs" id="myTab">
            <li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本设置</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?>" id="tab_basic">
                <div class='form-group-title'>周期购设置</div>
                <div class="form-group">
                    <label class="col-lg control-label">自动收货</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('cycelbuy.set.edit')) { ?>
                        <div class="input-group">
                            <input type="number" name="data[receive_goods]" class="form-control valid" value="<?php  echo $data['receive_goods'];?>" aria-invalid="false" aria-required="true">
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">周期购商品商家发货X天后，该期订单将被自动确认收货，不填写则默认15天</span>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">最快送达时间</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('cycelbuy.set.edit')) { ?>
                        <div class="input-group">
                            <input type="number" name="data[ahead_goods]" class="form-control valid" value="<?php  echo $data['ahead_goods'];?>" aria-invalid="false"  aria-required="true">
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">周期购商品的预计最快送达时间，买家选择最快在X天内收货，不填写则默认3天</span>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">首期送达时间</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('cycelbuy.set.edit')) { ?>
                        <div class="input-group">
                            <input type="number" name="data[days]" class="form-control valid" value="<?php  echo $data['days'];?>" aria-invalid="false"  aria-required="true">
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">用户可在该送达时间范围内选择首期商品的送达时间，不填写则默认7天</span>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">可延期收货时间</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('cycelbuy.set.edit')) { ?>
                        <div class="input-group">
                            <input type="number" name="data[max_day]" class="form-control valid" value="<?php  echo $data['max_day'];?>" aria-invalid="false"  aria-required="true">
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">用户可选择修改的当期周期购商品的送达时间范围，不填写则默认15天</span>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">定期发货提醒时间</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('cycelbuy.set.edit')) { ?>
                        <div class="input-group">
                            <input type="number" name="data[terminal]" class="form-control valid" value="<?php  echo $data['terminal'];?>" aria-invalid="false"  aria-required="true">
                            <span class="input-group-addon">天</span>
                        </div>
                        <span class="help-block">卖家定期发货提醒提前天数，不可小于等于0，默认为3天</span>
                        <?php  } ?>
                    </div>
                </div>

            </div>

        </div>
        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9">
                <?php if(cv('creditshop.set.edit')) { ?>
                <input type="submit" value="提交" class="btn btn-primary"/>
                <?php  } ?>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $(".btn-maxcredit").unbind('click').click(function () {
            var val = $(this).val();
            if(val==1){
                $(".maxcreditinput").css({'display':'inline-block'});
            }else{
                $(".maxcreditinput").css({'display':'none'});
            }
        });
    })
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>