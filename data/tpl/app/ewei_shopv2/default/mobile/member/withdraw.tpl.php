<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .fui-cell-group .fui-cell .fui-cell-icon{
        width: auto;
    }
    .fui-cell-group .fui-cell .fui-cell-icon img{
        width: 1.3rem;
        height: 1.3rem;
    }
    .fui-cell-group .fui-cell.no-border{
        padding-top: 0;
    }
    .fui-cell-group .fui-cell.no-border .fui-cell-info{
        font-size: .6rem;
        color: #999;
    }
    .fui-cell-group .fui-cell.applyradio  .fui-cell-info{
        line-height: normal;
    }
</style>
<div class='fui-page  fui-page-current'>
    <!--<div class="fui-header">-->
    <!--    <div class="fui-header-left">-->
    <!--        <a class="back"></a>-->
    <!--    </div>-->
    <!--    <div class="title"><?php  echo $_W['shopset']['trade']['moneytext'];?>提现-->
    <!--    </div>-->
    <!--    <div class="fui-header-right">&nbsp;</div>-->
    <!--</div>-->
    <div class='fui-content ' >
        <div class='fui-cell-title' style="height: 2.45rem">
            <div class='fui-cell-info' style='font-size:.7rem;color:#666;position: relative;height: 100%;line-height: 1.425rem'>可提现金额: ￥<span id='current'><?php  echo number_format($credit,2)?></span> <a id='btn-all' class='text-danger external' href='#' style="position: absolute;right: 0;text-decoration: underline">全部提现</a></div>
        </div>
        <div class='fui-cell-group' style="margin-top: 0">
            <div class='fui-cell-title'  style="height: 2.45rem;font-size:.7rem;color:#666;line-height: 1.425rem">提现金额
                <?php  if(floatval($set['withdrawmoney'])>0) { ?>
                <!--<small>提现额度最小为: <span class='text-danger'>￥<?php  echo number_format($set['withdrawmoney'],2)?></span></small>-->
                <?php  } ?>
            </div>
            <div class='fui-cell' style="padding: 0 .6rem .6rem;">
                <div class='fui-cell-label big' style='width:auto; font-size:1rem;color: #000; '>￥</div>
                <div class='fui-cell-info'><input type='number' class='fui-input' id='money' style='font-size:1rem;' ></div>
            </div>
        </div>
        <div class='fui-cell-group'>
            <div class="fui-cell">
                <div class="fui-cell-label" style="width: 120px;"><span class="re-g">提现方式</span></div>
                <!--<div class="fui-cell-info">-->

                    <!--<select id="applytype">-->
                        <?php  if(is_array($type_array)) { foreach($type_array as $key => $value) { ?>
                        <!--<option value="<?php  echo $key;?>" <?php  if(!empty($value['checked'])) { ?>selected<?php  } ?>><?php  echo $value['title'];?></option>-->
                        <?php  } } ?>
                    <!--</select>-->
                <!--</div>-->
                <!--<div class="fui-cell-remark"></div>-->
            </div>
            <?php  if(!empty($type_array['0'])) { ?>
            <div class="fui-cell applyradio">
                <div class="fui-cell-icon"><img src="<?php echo EWEI_SHOPV2_STATIC;?>images/wx.png" alt=""></div>
                <div class="fui-cell-info">
                    提现到微信钱包
                </div>
                <div class="fui-cell-remark noremark"><input    name="1" type="radio"class="fui-radio fui-radio-danger"  data-type="0" <?php  if(!empty($type_array[0]['checked']) ) { ?>checked="cheched "id="applytype"<?php  } ?>></div>
            </div>
            <?php  } ?>
            <?php  if(!empty($type_array['2'])) { ?>
            <div class="fui-cell applyradio">
                <div class="fui-cell-icon"><img src="<?php echo EWEI_SHOPV2_STATIC;?>images/zfb.png" alt=""></div>
                <div class="fui-cell-info">
                    提现到支付宝
                </div>
                <div class="fui-cell-remark noremark"><input  name="1"  type="radio"class="fui-radio fui-radio-danger" data-type="2"  <?php  if(!empty($type_array[2]['checked']) ) { ?>checked="cheched"  id="applytype"<?php  } ?>></div>
            </div>
            <?php  } ?>
            <?php  if(!empty($type_array['2'])) { ?>
            <div class="fui-cell ab-group" <?php  if(empty($type_array[2]['checked']) ) { ?>style="display: none;"<?php  } ?>>
                <div class="fui-cell-label" style="width: 120px;">姓名</div>
                <div class="fui-cell-info"><input type="text" id="realname" placeholder="请填写姓名"  name="realname" class='fui-input' value="<?php  echo $last_data['realname'];?>" max="25"/></div>
            </div>
            <div class="fui-cell alipay-group" <?php  if(empty($type_array[2]['checked'])) { ?>style="display: none;"<?php  } ?>>
                <div class="fui-cell-label" style="width: 120px;">支付宝帐号</div>
                <div class="fui-cell-info"><input type="text" id="alipay" placeholder="请填写支付宝账号"  name="alipay" class='fui-input' value="<?php  echo $last_data['alipay'];?>" max="25"/></div>
                </div>

                    <div class="fui-cell alipay-group" <?php  if(empty($type_array[2]['checked'])) { ?>style="display: none;"<?php  } ?>>
                    <div class="fui-cell-label" style="width: 120px;">确认帐号</div>
                    <div class="fui-cell-info"><input type="text" id="alipay1" placeholder="请确认账号"  name="alipay1" class='fui-input' value="<?php  echo $last_data['alipay'];?>" max="25"/></div>
                </div>
            <?php  } ?>
<?php  if(!empty($type_array['3'])) { ?>
            <div class="fui-cell applyradio">
                <div class="fui-cell-icon"><img src="<?php echo EWEI_SHOPV2_STATIC;?>images/yinhangka.png" alt=""></div>
                <div class="fui-cell-info">
                    提现到银行卡
                </div>
                <div class="fui-cell-remark noremark"><input  name="1"  type="radio"class="fui-radio fui-radio-danger" data-type="3"  <?php  if(!empty($type_array[3]['checked']) ) { ?>checked="cheched  "id="applytype"<?php  } ?>></div>
            </div>
<?php  } ?>
<?php  if(!empty($type_array['3'])) { ?>
            <div class="fui-cell ab-group2" <?php  if(empty($type_array[3]['checked']) ) { ?>style="display: none;"<?php  } ?>>
            <div class="fui-cell-label" style="width: 120px;">姓名</div>
            <div class="fui-cell-info"><input type="text" id="realname2"  placeholder="请填写姓名" name="realname" class='fui-input' value="<?php  echo $last_data['realname'];?>" max="25"/></div>
            </div>
                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>
                    <div class="fui-cell-label" style="width: 120px;"><span class="re-g">选择银行</span></div>
                    <div class="fui-cell-info">

                        <select id="bankname">
                            <?php  if(is_array($banklist)) { foreach($banklist as $key => $value) { ?>
                            <option value="<?php  echo $bankname;?>" <?php  if(!empty($last_data) && $last_data['bankname'] == $value['bankname']) { ?>selected<?php  } ?>><?php  echo $value['bankname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="fui-cell-remark"></div>
                </div>

                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>
                <div class="fui-cell-label" style="width: 120px;">银行卡号</div>
                <div class="fui-cell-info"><input type="text" id="bankcard" placeholder="请填写银行卡号" name="bankcard" class='fui-input' value="<?php  echo $last_data['bankcard'];?>" max="25"/></div>
                </div>

                <div class="fui-cell bank-group" <?php  if(empty($type_array[3]['checked'])) { ?>style="display: none;"<?php  } ?>>
                    <div class="fui-cell-label" style="width: 120px;">确认卡号</div>
                    <div class="fui-cell-info"><input type="text" id="bankcard1" placeholder="请确认银行卡号"  name="bankcard1`" class='fui-input' value="<?php  echo $last_data['bankcard'];?>" max="25"/></div>
                </div>
            <?php  } ?>


        </div>
        <?php  if($withdrawmoney > 0) { ?>
        <div class='fui-cell-title' style="height: 2.45rem">
            <div class='fui-cell-info' style='font-size:.7rem;color:#666;position: relative;height: 100%;line-height: 1.425rem'>
                最小提现金额为 ￥<?php  echo $withdrawmoney;?>
            </div>
        </div>
        <?php  } ?>
        <a id='btn-next' class='btn btn-danger block disabled '>提现</a>
        <div class='fui-cell-group' style="background: transparent;padding: .4rem 0;margin: 0;<?php  if(empty($withdrawcharge)) { ?>display: none;<?php  } ?>  ">
            <div class='fui-cell no-border'>
                <div class='fui-cell-info' id="chargeinfo">详细说明</div>
            </div>
            <?php  if(!empty($withdrawcharge)) { ?>
            <div class='fui-cell no-border charge-group' >
                <div class='fui-cell-info'>提现手续费为 <?php  echo $withdrawcharge;?>%</div>
            </div>
            <?php  } ?>
            <?php  if(!empty($withdrawend)) { ?>
            <div class='fui-cell no-border charge-group' >
                <div class='fui-cell-info'> 手续费金额在￥<?php  echo $withdrawbegin;?>到￥<?php  echo $withdrawend;?>间免收</div>
            </div>
            <?php  } ?>
            <div class='fui-cell no-border charge-group' >
                <div class='fui-cell-info'>本次提现将扣除手续费 ￥<span class='text-danger' id='deductionmoney'></span></div>
            </div>
            <div class='fui-cell no-border charge-group' >
                <div class='fui-cell-info'> 本次提现实际到账金额 ￥<span class='text-danger' id='realmoney'></span></div>
            </div>
            </div>

        </div>
        <?php  if(!empty($withdrawcharge)) { ?>
        <!--<div class='fui-cell-title'>提现手续费为 <?php  echo $withdrawcharge;?>%</div>-->
        <?php  } ?>

        <?php  if(!empty($withdrawend)) { ?>
        <!--<div class='fui-cell-title'>手续费金额在￥<?php  echo $withdrawbegin;?>到￥<?php  echo $withdrawend;?>间免收</div>-->
        <?php  } ?>

        <!--<div class='fui-cell-title charge-group' style="display: none;">本次提现将扣除手续费 ￥<span class='text-danger' id='deductionmoney'></span>-->
        <!--</div>-->

        <!--<div class='fui-cell-title charge-group' style="display: none;">本次提现实际到账金额 ￥<span class='text-danger' id='realmoney'></span>-->
        <!--</div>-->
    </div>
    <script language='javascript'>
            require(['biz/member/withdraw'], function (modal) {
                modal.init({
                    withdrawcharge:<?php  echo floatval($withdrawcharge)?>,
                    withdrawbegin:<?php  echo floatval($withdrawbegin)?>,
                    withdrawend:<?php  echo floatval($withdrawend)?>,
                    min:<?php  echo floatval($set['withdrawmoney'])?>,
                max:<?php  echo floatval($credit)?>,
            });
            });
    </script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>