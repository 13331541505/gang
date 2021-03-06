<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
    .form-group .container .input-group {margin-top: 10px;}
    .form-group .container .input-group:first-child {margin-top: 0;}
    .help-block-validate {padding: 0;}
    .btn-disabled {background: #eee; cursor: not-allowed}
</style>


<div class='page-header'>当前位置：<span class="text-primary">签到规则设置</span></div>
<div class="page-content">
<form id="setform"  action="" method="post" class="form-horizontal form-validate" novalidate="novalidate" >

    <div class="summary_box">
        <div class="summary_title">
            <span class="title_inner">签到规则说明</span>
        </div>
        <div class="summary_lg">
            <p>签到周期：签到周期是计算连续签到天数、总签到天数的依据，自然月则读取本月的连续签到天数、总签到天数，不限制签则计算所有签到天数</p>
            <p>补签设置：可以设置开启补签功能，可设置补签费用(积分或者余额)，费用可为空</p>
            <p>普通奖励：可以使用自定义替换页面中出现的文字</p>
            <p>普通奖励：普通奖励分为首次签到奖励、日常签到奖励</p>
            <p>连签奖励：可设置连续签到指定天数领取指定奖励，不设置则不显示</p>
            <p>总签奖励：可设置总签到到达指定天数领取指定奖励，不设置则不显示</p>
            <p>特殊奖励：可根据日期设置特殊日期，并可以设置奖励，例如“周年庆”奖励100积分(可只设置标题不设置奖励)</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">开启积分签到</label>
        <div class="col-sm-9 col-xs-12">
            <label class="radio radio-inline">
                <input type="radio" value="1" <?php  if(!empty($set['isopen'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="isopen"<?php  } else { ?>disabled<?php  } ?>> 开启
            </label>
            <label class="radio radio-inline">
                <input type="radio" value="0" <?php  if(empty($set['isopen'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="isopen"<?php  } else { ?>disabled<?php  } ?>> 关闭
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">补签规则设置</label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group" style="width: 450px;">
                <span class="form-control" style="width: 120px;">
                    <label class="checkbox-inline" style="padding-top: 0;"><input type="checkbox" style="margin-top: -9px" value="1" <?php  if(!empty($set['signold'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="signold"<?php  } else { ?>disabled<?php  } ?>> 开启补签</label>
                </span>
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">补签扣除(每天/次)</span>
                <input class="form-control" type="number" value="<?php  echo intval($set['signold_price'])?>" style="width: 100px;" <?php if(cv('sign.rule.edit')) { ?>name="signold_price"<?php  } else { ?>disabled<?php  } ?>>
                <span class="input-group-addon" style="border-left: 0;">
                    <label class="radio-inline" style="padding-top: 0;"><input style="margin-top: -9px" type="radio" value="0" <?php  if(empty($set['signold_type'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="signold_type"<?php  } else { ?>disabled<?php  } ?>> 余额</label>
                    <label class="radio-inline" style="padding-top: 0;"><input style="margin-top: -9px" type="radio" value="1" <?php  if(!empty($set['signold_type'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="signold_type"<?php  } else { ?>disabled<?php  } ?>> 积分</label>
                </span>
            </div>
            <div class="help-block text-danger">提示：补签只发放日常奖励请在规则中说明，仅可扣除余额或积分，补签只可为当月漏签日期补签</div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">文字自定义</label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">积分</span>
                <input type="text" class="form-control" value="<?php  if(empty($set['textcredit'])) { ?>积分<?php  } else { ?><?php  echo $set['textcredit'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="textcredit"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">签到</span>
                <input type="text" class="form-control"  value="<?php  if(empty($set['textsign'])) { ?>签到<?php  } else { ?><?php  echo $set['textsign'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="textsign"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">补签</span>
                <input type="text" class="form-control"  value="<?php  if(empty($set['textsignold'])) { ?>补签<?php  } else { ?><?php  echo $set['textsignold'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="textsignold"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">已签</span>
                <input type="text" class="form-control"  value="<?php  if(empty($set['textsigned'])) { ?>已签<?php  } else { ?><?php  echo $set['textsigned'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="textsigned"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">漏签</span>
                <input type="text" class="form-control"  value="<?php  if(empty($set['textsignforget'])) { ?>漏签<?php  } else { ?><?php  echo $set['textsignforget'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="textsignforget"<?php  } else { ?>disabled<?php  } ?> />
            </div>
            <div class="help-block">注意：手机端 所有包含“积分”、“签到”、“补签”、“已签”文字均可自定义</div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">签到页面主色调</label>
        <div class="col-sm-9 col-xs-12">
                <div class="input-group" style="width: 150px;">
                    <input type="color" name="maincolor" class="form-control" style="padding: 0px;" value="<?php  if(empty($set['maincolor'])) { ?>#24b2f4<?php  } else { ?><?php  echo $set['maincolor'];?><?php  } ?>" <?php if(cv('sign.rule.edit')) { ?>name="maincolor"<?php  } else { ?>disabled<?php  } ?> />
                    <?php if(cv('sign.rule.edit')) { ?>
                    <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#24b2f4')">重置</span>
                    <?php  } ?>
                </div>
        </div>
    </div>


    <div class="form-group-title">签到规则</div>

    <div class="form-group">
        <label class="col-lg control-label">签到周期</label>
        <div class="col-sm-9 col-xs-12">
                <label class="radio radio-inline"><input type="radio" value="0" class="change" data-show="" data-hide=".signdate" <?php  if(empty($set['cycle'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="cycle"<?php  } else { ?>disabled<?php  } ?>> 不限</label>
                <label class="radio radio-inline"><input type="radio" value="1" class="change" data-show="" data-hide=".signdate" <?php  if(!empty($set['cycle'])) { ?>checked<?php  } ?> <?php if(cv('sign.rule.edit')) { ?>name="cycle"<?php  } else { ?>disabled<?php  } ?>> 自然月</label>
                <div class="help-block">不限制签到周期则统计时间为平台上线至今日，自然月统计周期则为本月，下月清空</div>
        </div>
    </div>

    <div class="form-group-title"></div> 

    <div class="form-group">
        <label class="col-lg control-label">普通奖励<br><small>(自动发放)</small></label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">首次奖励</span>
                <input class="form-control" type="number" value="<?php  echo intval($set['reward_default_first'])?>" <?php if(cv('sign.rule.edit')) { ?>name="reward_default_first"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0; border-right: 0;">积分 日常奖励</span>
                <input class="form-control" type="number" value="<?php  echo intval($set['reward_default_day'])?>" <?php if(cv('sign.rule.edit')) { ?>name="reward_default_day"<?php  } else { ?>disabled<?php  } ?> />
                <span class="input-group-addon" style="border-left: 0;">积分</span>
            </div>
        </div>
    </div>

    <div class="form-group reward">
        <label class="col-lg control-label">连签奖励<br><small>(需手动领取)</small></label>
        <div class="col-sm-9 col-xs-12 container">
            <?php  $tpltype = 1?>
            <?php  if(!empty($set['reword_order'])) { ?>
                <?php  if(is_array($set['reword_order'])) { foreach($set['reword_order'] as $item) { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sign/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sign/tpl', TEMPLATE_INCLUDEPATH));?>
                <?php  } } ?>
            <?php  } ?>
            <?php if(cv('sign.rule.edit')) { ?>
                <div class="input-group form-control btn btn-default addrule" data-type="1"><i class="fa fa-plus"></i> 添加一个连签奖励规则</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group reward">
        <label class="col-lg control-label">总签奖励<br><small>(需手动领取)</small></label>
        <div class="col-sm-9 col-xs-12 container">
            <?php  $tpltype = 2?>
            <?php  if(!empty($set['reword_sum'])) { ?>
                <?php  if(is_array($set['reword_sum'])) { foreach($set['reword_sum'] as $item) { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sign/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sign/tpl', TEMPLATE_INCLUDEPATH));?>
                <?php  } } ?>
            <?php  } ?>
            <?php if(cv('sign.rule.edit')) { ?>
                <div class="input-group form-control btn btn-default addrule" data-type="2"><i class="fa fa-plus"></i> 添加一个总签奖励规则</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">特殊奖励<br><small>(自动发放)</small></label>
        <div class="col-sm-9 col-xs-12 container">
            <?php  $tpltype = 3?>
            <?php  if(!empty($set['reword_special'])) { ?>
                <?php  if(is_array($set['reword_special'])) { foreach($set['reword_special'] as $item) { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sign/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sign/tpl', TEMPLATE_INCLUDEPATH));?>
                <?php  } } ?>
            <?php  } ?>
            <?php if(cv('sign.rule.edit')) { ?>
                <div class="input-group form-control btn btn-default addrule" data-type="3"><i class="fa fa-plus"></i> 添加一个特殊奖励规则</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label">签到规则</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.rule.edit')) { ?>
                <?php echo tpl_ueditor('sign_rule',isset($set['sign_rule'])?$set['sign_rule']:"",array('height'=>'200'))?>
            <?php  } else { ?>
                <textarea id='sign_rule' style='display:none;'><?php  echo $set['sign_rule'];?></textarea>
                <a href='javascript:preview_html("#sign_rule")' class="btn btn-default">查看内容</a>
            <?php  } ?>
        </div>
    </div>


    <?php if(cv('sign.rule.edit')) { ?>
         <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9">
                	<input type="submit" value="提交" class="btn btn-primary" />
            </div>
        </div>
    <?php  } ?>

</form>
</div>

<script type="text/javascript">
    $(function () {
        $(".change").on('click', function () {
            var show = $(this).data('show');
            var hide = $(this).data('hide');
            if (show) {
                $(show).show();
            }
            if (hide) {
                $(hide).hide();
            }
        });

        $(".addrule").on('click', function () {
            var _this = $(this);
            var type = _this.data('type');
            $.get("<?php  echo webUrl('sign/tpl')?>", {tpltype: type}, function (tpl) {
                _this.before(tpl);
            });
        });

        $(document).on('click','.delrule', function () {
            $(this).closest('.input-group').remove();
        });
    });
</script>





<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
