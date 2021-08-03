<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
.img-thumbnail {width: 100px;height: 100px;}
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/membercard/static/css/common.css">
<div class="form-group">
    <label class="col-lg control-label must">会员卡名称</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <input type='text' class="form-control" name='name' data-rule-required="true" aria-required="true" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?> value='<?php  echo $item['name'];?>' />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['name'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group splitter"></div>
<div class="form-group">
    <label class="col-lg control-label">卡片样式</label>
    <div class="col-sm-9 col-xs-12">
        <input style="display: none;" class="card_style" name="card_style" value="card-style-golden" />
        <div class="card-item card-style-golden <?php  if(empty($item) || $item['card_style']=='card-style-golden') { ?>active<?php  } ?>" id="card-style-golden">
            <i class="icow icow-huangguan-copy"></i>
        </div>
        <div class="card-item card-style-erythrine <?php  if($item['card_style']=='card-style-erythrine') { ?>active<?php  } ?>" id="card-style-erythrine">
            <i class="icow icow-huangguan-copy"></i>
        </div>
        <div class="card-item card-style-gray <?php  if($item['card_style']=='card-style-gray') { ?>active<?php  } ?>" id="card-style-gray">
            <i class="icow icow-huangguan-copy"></i>
        </div>
        <div class="card-item card-style-brown <?php  if($item['card_style']=='card-style-brown') { ?>active<?php  } ?>" id="card-style-brown">
            <i class="icow icow-huangguan-copy"></i>
        </div>
        <div class="card-item card-style-blue <?php  if($item['card_style']=='card-style-blue') { ?>active<?php  } ?>" id="card-style-blue">
            <i class="icow icow-huangguan-copy"></i>
        </div>
        <div class="card-item card-style-black <?php  if($item['card_style']=='card-style-black') { ?>active<?php  } ?>" id="card-style-black">
            <i class="icow icow-huangguan-copy"></i>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">排序</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <input type='text' class='form-control' name='sort_order' value="<?php  echo $item['sort_order'];?>" />
        <span class="help-block">数字越大，排名越靠前,如果为空，默认排序方式为创建时间</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['sort_order'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">会员卡模式</label>
    <div class="col-sm-9">
        <label class="radio-inline">
            <input type="radio" name="cardmodel" value="1" <?php  if($item['cardmodel'] != 2) { ?>checked<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> /> 所有商品
        </label>
        <label class="radio-inline">
            <input type="radio" name="cardmodel" value="2" <?php  if($item['cardmodel'] == 2) { ?>checked<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>/> 指定商品
        </label>
        <span class="help-block pointgoods" style="display: none">指定商品支持一张会员卡</span>
    </div>
</div>

<div class="form-group" id='goodsdiv' style="display: none">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <?php  echo tpl_selector_new('goodsid',array(
                            'preview'=>true,
                            'readonly'=>true,
                            'selectorid'=>'',
                            'multi'=>1,
                            'type'=>'card',
                            'value'=>$package_goods['title'],
                            'url'=>webUrl('membercard/cardmanage/querygoods'),
                            'items'=>$res,
                            'nokeywords'=>1,
                            'autosearch'=>1,
                            'buttontext'=>'选择商品',
                            'placeholder'=>'请选择商品')
                            )
        ?>

    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">折上折</label>
    <div class="col-sm-9">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="discount" value="1" <?php  if($item['discount'] == 1) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> /> 启用
        </label>
        <label class="radio-inline">
            <input type="radio" name="discount" value="0" <?php  if(empty($item['discount']) ) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> /> 禁用
        </label>
        <span class="help-block">启用后 , 会在会员等级折扣后再次折扣 , 即购买价格 = 会员折扣后的价格 * 会员卡折扣</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if(empty($item['discount'])) { ?>禁用<?php  } else { ?>启用<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label must">会员权益</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="checkbox-inline"><input type="checkbox" name="shipping" value="1" <?php  if(!empty($item['shipping'])) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  /> 包邮</label>
        <label class="checkbox-inline"><input type="checkbox" name="member_discount" value="1" <?php  if(!empty($item['member_discount'])) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  /> 会员折扣</label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($item['shipping'])) { ?>包邮;<?php  } ?>
            <?php  if(!empty($item['member_discount'])) { ?>会员折扣;<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="vipdiscount" <?php  if(empty($item['member_discount'])) { ?>style="display: none;"<?php  } ?>>
    <label class="col-lg control-label">&nbsp;</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <div class="input-group">
            <input type="text" name="discount_rate" class="form-control" data-rule-required="true" aria-required="true" value="<?php  echo $item['discount_rate'];?>" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?> />
            <span class="input-group-addon">折</span>
        </div>
        <span class='help-block'>请填写0-10之间的数值</span>
        <?php  } else { ?>
        <div class='form-control-static'>会员折扣：<?php  echo $item['discount_rate'];?> 折</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">开卡赠送</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="checkbox-inline"><input type="checkbox" name="is_card_points" value="1" <?php  if(!empty($item['is_card_points'])) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  /> <?php echo empty($data['credittext'])?'积分':$data['credittext']?></label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($item['is_card_points'])) { ?>积分<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="sendcredit1" <?php  if(empty($item['is_card_points'])) { ?>style="display: none;"<?php  } ?>>
    <label class="col-lg control-label">&nbsp;</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <div class="input-group">
            <input type="text" name="card_points" class="form-control" data-rule-required="true" aria-required="true" value="<?php  echo $item['card_points'];?>" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?> />
            <span class="input-group-addon"><?php echo empty($data['credittext'])?'积分':$data['credittext']?></span>
        </div>
        <span class='help-block'>开卡赠送的<?php echo empty($data['credittext'])?'积分':$data['credittext']?>数值</span>
        <?php  } else { ?>
        <div class='form-control-static'>积分：<?php  echo $item['card_points'];?> 分</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">&nbsp;</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="checkbox-inline"><input type="checkbox" name="is_card_coupon" value="1" <?php  if(!empty($item['is_card_coupon'])) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  /> 优惠券</label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($item['is_card_coupon'])) { ?>优惠券<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="sendcoupon" <?php  if(empty($item['is_card_coupon'])) { ?>style="display: none;"<?php  } ?>>
    <?php if( ce('sale.coupon.shareticket' ,$item) ) { ?>
        <label class="col-lg control-label" id="stitle1">&nbsp;</label>
        <div class="col-sm-9 col-xs-12" id="share1">
            <?php  echo tpl_selector('couponid1',array('required'=>false,'multi'=>1,'type'=>'coupon_shares','autosearch'=>1, 'preview'=>true,'url'=>webUrl('sale/coupon/querycplist'),'text'=>'couponname','items'=>$coupons_pay,'readonly'=>true,'buttontext'=>'选择优惠券','placeholder'=>'请选择优惠券'))?>
        </div>
    <?php  } else { ?>
        <?php  if(!empty($item)) { ?>
        <table class="table">
            <thead>
            <tr>
                <th style='width:100px;'>优惠券名</th>
                <th style='width:200px;'></th>
                <th></th>
                <th>优惠券数量</th>
            </tr>
            </thead>
            <tbody id="param-items1" class="ui-sortable">
            <?php  if(is_array($coupons_pay)) { foreach($coupons_pay as $row) { ?>
            <tr class='multi-product-item' data-id="<?php  echo $row['id'];?>">
                <input type='hidden' class='form-control img-textname' readonly='' value="<?php  echo $row['couponname'];?>">
                <input type='hidden' value="<?php  echo $row['id'];?>" name="couponids[]">
                <td style='width:80px;'>
                    <img src="<?php  echo tomedia($row['thumb'])?>" style='width:70px;border:1px solid #ccc;padding:1px'>
                </td>
                <td style='width:220px;'><?php  echo $row['couponname'];?></td>
                <td>
                    <input class='form-control valid' type='text' disabled value="<?php  echo $item['coupontotal'];?>" name="coupontotal<?php  echo $row['id'];?>">
                </td>
                <td>
                    <input class='form-control valid' type='text' disabled value="<?php  echo $item['couponlimit'];?>" name="couponlimit<?php  echo $row['id'];?>">
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  } else { ?>
            暂无优惠券
        <?php  } ?>
    <?php  } ?>
</div>
<div class="form-group">
    <label class="col-lg control-label">每月领取</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="checkbox-inline"><input type="checkbox" name="is_month_points" value="1" <?php  if(!empty($item['is_month_points'])) { ?>checked="true"<?php  } ?>  <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> /> <?php echo empty($data['credittext'])?'积分':$data['credittext']?></label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($item['is_month_points'])) { ?><?php echo empty($data['credittext'])?'积分':$data['credittext']?><?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="monthcredit1" <?php  if(empty($item['is_month_points'])) { ?>style="display: none;"<?php  } ?>>
    <label class="col-lg control-label">&nbsp;</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <div class="input-group">
            <input type="text" name="month_points" class="form-control" data-rule-required="true" aria-required="true" value="<?php  echo $item['month_points'];?>" <?php  if(!empty($item['id'])) { ?>readonly<?php  } ?> />
            <span class="input-group-addon"><?php echo empty($data['credittext'])?'积分':$data['credittext']?></span>
        </div>
        <span class='help-block'>开卡后每个月可以领取积分数值</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['month_points'];?> <?php echo empty($data['credittext'])?'积分':$data['credittext']?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">&nbsp;</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('membercard.cardmanage' ,$item) ) { ?>
        <label class="checkbox-inline"><input type="checkbox" name="is_month_coupon" value="1" <?php  if(!empty($item['is_month_coupon'])) { ?>checked="true"<?php  } ?> <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  /> 优惠券</label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($item['is_month_coupon'])) { ?>赠送优惠券<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="monthcoupon" <?php  if(empty($item['is_month_coupon'])) { ?>style="display: none;"<?php  } ?>>
    <?php if( ce('sale.coupon.shareticket' ,$item) ) { ?>
        <label class="col-lg control-label" id="stitle2">&nbsp;</label>
        <div class="col-sm-9 col-xs-12" id="share2">
            <?php  echo tpl_selector('couponid2',array('required'=>false,'multi'=>1,'type'=>'coupon_share','autosearch'=>1, 'preview'=>true,'url'=>webUrl('sale/coupon/querycplist'),'text'=>'couponname','items'=>$coupons_share,'readonly'=>true,'buttontext'=>'选择优惠券','placeholder'=>'请选择优惠券'))?>
        </div>
    <?php  } else { ?>
        <?php  if(!empty($item)) { ?>
        <table class="table">
            <thead>
            <tr>
                <th style='width:100px;'>优惠券名称</th>
                <th style='width:200px;'></th>
                <th></th>
                <th>优惠券数量</th>
            </tr>
            </thead>
            <tbody id="param-items2" class="ui-sortable">
            <?php  if(is_array($coupons_share)) { foreach($coupons_share as $row) { ?>
            <tr class='multi-product-item' data-id="<?php  echo $row['id'];?>">
                <input type='hidden' class='form-control img-textname' readonly='' value="<?php  echo $row['couponname'];?>">
                <input type='hidden' value="<?php  echo $row['id'];?>" name="couponid[]">
                <td style='width:80px;'>
                    <img src="<?php  echo tomedia($row['thumb'])?>" style='width:70px;border:1px solid #ccc;padding:1px'>
                </td>
                <td style='width:220px;'><?php  echo $row['couponname'];?></td>
                <td>
                    <input class='form-control valid' type='text' disabled value="<?php  echo $item['coupontotal'];?>" name="coupontotal<?php  echo $row['id'];?>">
                </td>
                <td>
                    <input class='form-control valid' type='text' disabled value="<?php  echo $item['couponlimit'];?>" name="couponlimit<?php  echo $row['id'];?>">
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  } else { ?>
            暂无优惠券
        <?php  } ?>
    <?php  } ?>
</div>

<!--<script src="../addons/ewei_shopv2/plugin/membercard/static/js/spec.js"></script>-->
<script language="javascript">
    myrequire(['../../plugin/membercard/static/js/basic'], function (modal) {
        modal.init();
    });

    require(['jquery.ui'],function(){
        $('.multi-img-details').sortable();
    });

    require(['bootstrap'], function () {
        $('#myTab a').click(function (e) {
            $('#tab').val( $(this).attr('href'));
            e.preventDefault();
            $(this).tab('show');
        })
    });
</script>
<script type="text/javascript">
$(function(){
    $("input[name='member_discount']").click(function(){
        if(this.checked == true){
            $("#vipdiscount").show()
        }else{
            $("#vipdiscount").hide();
        }
    });
    $("input[name='is_card_points']").click(function(){
        if(this.checked == true){
            $("#sendcredit1").show()
        }else{
            $("#sendcredit1").hide();
        }
    });
    $("input[name='is_card_coupon']").click(function(){
        if(this.checked == true){
            $("#sendcoupon").show()
        }else{
            $("#sendcoupon").hide();
        }
    });
    $("input[name='is_month_points']").click(function(){
        if(this.checked == true){
            $("#monthcredit1").show()
        }else{
            $("#monthcredit1").hide();
        }
    });
    $("input[name='is_month_coupon']").click(function(){
        if(this.checked == true){
            $("#monthcoupon").show()
        }else{
            $("#monthcoupon").hide();
        }
    });
    <?php  if(!empty($item['id'])) { ?>
    $("input.form-control.valid").attr('readonly',true);
    $("button.btn.btn-default").hide();
    $('.card-item').css("pointerEvents","none")
    <?php  } ?>

});

if ($("*[name='cardmodel']:checked").val() == 1) {
    $('#goodsdiv').hide();
    $('.pointgoods').hide();
} else {
    $('#goodsdiv').show();
    $('.pointgoods').show();
}

$("*[name='cardmodel']").click(function () {
    if ($("*[name='cardmodel']:checked").val() == 1) {
        $('#goodsdiv').hide();
        $('.pointgoods').hide();
    } else {
        $('#goodsdiv').show();
        $('.pointgoods').show();
    }

});


</script>
