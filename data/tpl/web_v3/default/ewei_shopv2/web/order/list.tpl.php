<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
    .trhead td {  background:#efefef;text-align: center}
    .trbody td {  text-align: center; vertical-align:top;border-left:1px solid #f2f2f2;overflow: hidden; font-size:12px;}
    .trorder { background:#f8f8f8;border:1px solid #f2f2f2;text-align:left;}
    .ops { border-right:1px solid #f2f2f2; text-align: center;}
    .ops a,.ops span{
        margin: 3px 0;
    }
    .table-top .op:hover{
        color: #000;
    }
    .tables{
        border:1px solid #e5e5e5;
        font-size: 12px;
        line-height: 18px;
    }
    .tables:hover{
        border:1px solid #b1d8f5;
    }
    .table-row,.table-header,.table-footer,.table-top{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        -webkit-justify-content: center;
        -webkit-align-content: space-around;
        align-content: space-around;
    }
    .tables  .table-row>div{
        padding: 14px 0 !important;
    }
    .tables  .table-row>div.columnFlex{
        padding: 0 !important;
    }
    .tables  .table-row.table-top>div{
        margin: 0 !important;
        padding: 16px 0;
    }
    .tables    .table-row .ops.list-inner{
        border-right:none;
    }
    .tables .list-inner{
       border-right: 1px solid #efefef;
        vertical-align: middle;
    }
    .table-row .goods-des .title{
        width:180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-row .goods-des{
        width:300px;
        border-right: 1px solid #efefef;
        vertical-align: middle;
    }
    .table-row .goods-des.singleRefund{
        padding: 0px !important;
        display: flex;
        flex-direction: column;
        margin: 0 !important;
    }
    .table-row .goods-des.singleRefund{
        padding: 16px 0;

    }
    .table-row .goods-des.singleRefund .goodsRefund{
        border-bottom: 1px solid #efefef;
        flex-direction: initial;
        margin: 0 !important;
    }
    .table-row .list-inner{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        text-align: center;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-align-items: center;
        align-items: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-flex-direction: column;
        flex-direction: column;
    }
    .saler>div{
        width:130px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-row .list-inner.ops,  .table-row .list-inner.paystyle{
        -webkit-flex-direction: column;
        flex-direction: column;
       -webkit-justify-content: center;
       justify-content: center;
    }
    .table-header .others{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        text-align: center;
    }
    .table-footer{
        border-top: 1px solid #efefef;
    }
    .table-footer>div, .table-top>div{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        height:100%;
    }
    .fixed-header div{
        padding:0;
    }
    .fixed-header.table-header{
        display: none;
    }
    .fixed-header.table-header.active{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .shop{
        display: inline-block;
        width:48px;
        height:18px;
        text-align: center;
        border:1px solid #1b86ff;
        color: #1b86ff;
        margin-right: 10px;
    }
    .min_program{
        display: inline-block;
        width:48px;
        height:18px;
        text-align: center;
        border:1px solid #ff5555;
        color: #ff5555;
        margin-right: 10px;
    }
    .columnFlex{
        display: flex;
        flex-direction: column;
    }
    .columnFlex .noRefund{
        flex:1;
        width:100%;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /*border-bottom: 1px solid #efefef;*/
        padding: 16px 10px;
        align-items: center;
    }
    .goodsRefund{
        height:103px;
        display: flex;
        width:100%;
        position: relative;
        flex-direction: column;
        justify-content: center;
        border-bottom: 1px solid #efefef;
        padding: 16px 10px;
        align-items: center;
    }
    .table-row .list-inner.goodsRefund{
        flex: inherit;
    }
    .rr-label{
        width: 75px;
        margin-right: 8px;
        padding: 5px;
        border: 1px solid #eee;
        border-radius: 4px;
        background: #44ABF7;
        color: #fff;
        text-align: center;
    }
    .rr-process{
        color: #44ABF7;
        cursor: pointer;

    }
    .rr-process .input-group {
        display: none;
    }
    .rr-process .input-group:first-of-type{
        display: block;
    }
    .rr-process .form-control {
        display: none;
    }
    .rr-process .input-group-btn .btn{
        background: none!important;
        border: none!important;
        color: #44ABF7!important;
        outline: none!important;
    }
    .rr-process .input-group-btn .btn:active {
        border: none!important;
        box-shadow: none!important;
    }
</style>

<div class="page-header">

    <span>?????????:  <span class='text-danger'><?php  echo $total;?></span> ????????????:  <span class='text-danger'>???<?php  echo $totalmoney;?></span> <?php  if(!empty($magent['nickname'])) { ?>???????????????:  <span class='text-danger'><?php  echo $magent['nickname'];?></span><?php  } ?></span>
</div>
<div class="page-content">

    <div class="fixed-header table-header" style="padding: 0 50px;">
        <div style='border-left:1px solid #f2f2f2;width: 400px;text-align: left;'>??????</div>
        <div class="others">??????</div>
        <div class="others">??????/??????</div>
        <div class="others">??????</div>
        <div class="others">??????</div>
        <div class="others">??????</div>
    </div>
    <form action="./index.php" method="get" class="form-horizontal table-search" role="form"  id="search">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="order.list<?php  echo $st;?>" />
        <input type="hidden" name="status" value="<?php  echo $status;?>" />
        <input type="hidden" name="agentid" value="<?php  echo $_GPC['agentid'];?>" />
        <input type="hidden" name="refund" value="<?php  echo $_GPC['refund'];?>" />
        <input type="hidden" name="headsid" value="<?php  echo $_GPC['headsid'];?>" />
        <div class="page-toolbar">
            <div class="input-group">
                <span class="input-group-select">
                    <select name="paytype" class="form-control" style="width:100px;padding:0 5px;">
                        <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>????????????</option>
                        <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                        <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name='searchtime'  class='form-control'   style="width:100px;padding:0 5px;"  id="searchtime">
                        <option value=''>????????????</option>
                        <option value='create' <?php  if($_GPC['searchtime']=='create') { ?>selected<?php  } ?>>????????????</option>
                        <option value='pay' <?php  if($_GPC['searchtime']=='pay') { ?>selected<?php  } ?>>????????????</option>
                        <option value='send' <?php  if($_GPC['searchtime']=='send') { ?>selected<?php  } ?>>????????????</option>
                        <option value='finish' <?php  if($_GPC['searchtime']=='finish') { ?>selected<?php  } ?>>????????????</option>
                    </select>
                </span>
                <span class="input-group-btn">
                    <?php  echo tpl_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true, true);?>
                </span>
                <span class="input-group-select">
                    <select name='searchfield'  class='form-control'   style="width:110px;padding:0 5px;"  >
                        <option value='ordersn' <?php  if($_GPC['searchfield']=='ordersn') { ?>selected<?php  } ?>>?????????</option>
                        <option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>????????????</option>
                        <option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>???????????????</option>
                        <option value='location' <?php  if($_GPC['searchfield']=='location') { ?>selected<?php  } ?>>????????????</option>
                        <option value='expresssn' <?php  if($_GPC['searchfield']=='expresssn') { ?>selected<?php  } ?>>????????????</option>
                        <option value='goodstitle' <?php  if($_GPC['searchfield']=='goodstitle') { ?>selected<?php  } ?>>????????????</option>
                        <option value='goodssn' <?php  if($_GPC['searchfield']=='goodssn') { ?>selected<?php  } ?>>????????????</option>
                        <option value='saler' <?php  if($_GPC['searchfield']=='saler') { ?>selected<?php  } ?>>?????????</option>
                        <option value='store' <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>????????????</option>
                        <option value='selfget' <?php  if($_GPC['searchfield']=='selfget') { ?>selected<?php  } ?>>????????????</option>
                        <option value='mid' <?php  if($_GPC['searchfield']=='mid') { ?>selected<?php  } ?>>??????id</option>
                        <?php  if($merch_plugin) { ?>
                        <option value='merch' <?php  if($_GPC['searchfield']=='merch') { ?>selected<?php  } ?>>????????????</option>
                            <?php  } ?>
                    </select>
                </span>
                <input type="text" class="form-control input-sm"  name="keyword" id="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="??????????????????"/>
                <input type="hidden" name="export" id="export" value="0">
                <span class="input-group-select">
                    <select name="order_type" class="form-control" style="width:110px;padding:0 5px;">
                        <option value="" <?php  if($_GPC['order_type']=='') { ?>selected<?php  } ?>>????????????</option>
                        <option value='general' <?php  if($_GPC['order_type']=='general') { ?>selected<?php  } ?>>????????????</option>
                        <option value='fullback' <?php  if($_GPC['order_type']=='fullback') { ?>selected<?php  } ?>>????????????</option>
                    </select>
                </span>
                <span class="input-group-btn">
                        <button type="button" data-export="0" class="btn btn-primary btn-submit"> ??????</button>
                        <button type="button" data-export="1" class="btn btn-success btn-submit">??????</button>
                </span>
            </div>

        </div>

    </form>


    <?php  if(count($list)>0) { ?>
    <div class="row">
        <div class="col-md-12">
            <div  class="">
                <div class="table-header" style='background:#f8f8f8;height: 35px;line-height: 35px;padding: 0 20px'>
                    <div style='border-left:1px solid #f2f2f2;width: 400px;text-align: left;'>??????</div>
                    <div class="others">??????</div>
                    <div class="others">??????/??????</div>
                    <div class="others">??????</div>
                    <div class="others">??????</div>
                    <div class="others">??????</div>
                </div>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <div class="table-row"><div style='height:20px;padding:0;border-top:none;'>&nbsp;</div></div>
                <div class="tables">
                    <div class='table-row table-top' style="padding:0  20px;background: #f7f7f7">
                        <div style="text-align: left;color: #8f8e8e;">
                            <span style="font-weight: bold;margin-right: 10px;color: #2d2d31">

                                <?php  if($item['iswxappcreate']==0) { ?><span class="shop">??????</span><?php  } else { ?><span class="min_program">?????????</span><?php  } ?>
                                <?php  if($item['giftSign']==1) { ?><span class="min_program" style=" border:1px solid orange; color: orange;">??????</span><?php  } ?>
                                <?php  if($item['is_cashier'] == 1) { ?><span class="shop">?????????</span><?php  } ?><?php  echo date('Y-m-d',$item['createtime'])?>&nbsp <?php  echo date('H:i:s',$item['createtime'])?>

                            </span>
                            ????????????:  <?php  echo $item['ordersn'];?><?php  if($item['is_peerpay']) { ?><span class="label label-primary">??????</span><?php  } ?><?php  if($item['ispackage']) { ?>&nbsp;<span class="label label-success">??????</span><?php  } ?>
                            <?php  if(!empty($item['refundstate']) && $item['refundstate'] !=3) { ?><label class='label label-danger'><?php  echo $r_type[$item['rtype']];?>??????</label><?php  } ?>
                            <?php  if(!empty($item['refundstate']) && $item['refundstate'] !=3 && $item['rstatus'] == 4) { ?><label class='label label-default'>??????????????????</label><?php  } ?>
                        </div>
                        <div style='text-align:right;font-size:12px;' class='aops'>
                            <?php  if($item['merchid'] == 0) { ?>
                                <?php if(cv('order.op.remarksaler')) { ?>
                                <a class='op'  data-toggle="ajaxModal" href="<?php  echo webUrl('order/op/remarksaler', array('id' => $item['id']))?>" >
                                    <?php  if(!empty($item['remarksaler'])) { ?>
                                    <i class="icow icow-flag-o" style="color: #df5254;display: inline-block;vertical-align: middle" title="  ????????????"></i>
                                    ??????
                                    &nbsp
                                    <?php  } else { ?>
                                    <i class="icow icow-yibiaoji" style="color: #999;display: inline-block;vertical-align: middle" title="  ????????????" ></i>
                                    ??????
                                    &nbsp
                                    <?php  } ?>
                                </a>
                                <?php  } ?>
                            <?php  } ?>
                            <?php  if($item['merchid'] == 0) { ?>
                                <?php  if(($item['statusvalue']>=2 || $item['sendtype']>0) && !empty($item['addressid']) && $item['statusvalue']!=3 &&$item['city_express_state']==0) { ?>
                                    <?php if(cv('order.op.send')) { ?>
                                    <a class="op" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/changeexpress', array('id' => $item['id']))?>">
                                        <i class="icow icow-wuliu" title="????????????" style="color: #999;display: inline-block;vertical-align: middle"></i>
                                        ????????????
                                        &nbsp
                                    </a>
                                    <?php  } ?>
                                <?php  } ?>
                            <?php  } ?>
                            <?php  if($item['merchid'] == 0) { ?>
                                <?php  if(empty($item['statusvalue'])) { ?>
                                    <?php if(cv('order.op.changeprice')) { ?>
                                        <?php  if($item['ispackage'] ==0) { ?>
                                        <a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/changeprice',array('id'=>$item['id']))?>">
                                            <i class="icow icow-gaijia" title="????????????"  style="color: #999;display: inline-block;vertical-align: middle"></i>
                                            ????????????
                                            &nbsp
                                        </a>
                                        <?php  } ?>
                                    <?php  } ?>
                            <?php  if($item['ismerch'] == 0) { ?>
                                <?php if(cv('order.op.close')) { ?>
                                <a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/close',array('id'=>$item['id']))?>" >
                                    <i class="icow icow-shutDown" title="????????????"  style="color: #999;margin-right: 3px;display: inline-block;vertical-align: middle"></i>
                                    ????????????
                                    &nbsp
                                </a>

                                <?php  } ?>
                            <?php  } ?>
                                <?php  } ?>
                            <?php  } ?>

                            <!--<a class='op'   href="<?php  echo webUrl('order', array('op' => 'detail', 'id' => $item['id']))?>" >??????</a>-->
                        </div>
                    </div>
                    <div class='table-row' style="margin:0  20px">
                        <!----------------singleRefund----------------->
                        <div class="goods-des singleRefund" style='width:400px;text-align: left'>
                            <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>
                            <div class="<?php  if($g['single_refundstate']>0) { ?>goodsRefund<?php  } ?>"  style="display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;margin: 10px 0">
                                <img src="<?php  echo tomedia($g['thumb'])?>" style='width:70px;height:70px;border:1px solid #efefef; padding:1px;'onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'">
                                <div style="-webkit-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;margin-left: 10px;text-align: left;display: flex;align-items: center">
                                    <div >
                                       <div class="title">
                                           <?php  if($g['ispresell']==1) { ?>
                                           <label class="fui-tag fui-tag-danger">???</label>
                                           <?php  } ?>
                                           <?php  echo $g['title'];?><br/>
                                           <span style="color: #999"> <?php  if(!empty($g['optiontitle'])) { ?><?php  echo $g['optiontitle'];?><?php  } ?><?php  echo $g['goodssn'];?></span>
                                       </div>
                                              <?php  if($g['seckill_task']) { ?>
                                        <div>
                                                <span class="label label-danger"><?php  echo $g['seckill_task']['tag'];?></span>
                                                <?php  if($g['seckill_room']) { ?>
                                                    <span class="label label-primary">
                                                        <?php echo $g['seckill_room']['tag']?:$g['seckill_room']['title']?>
                                                    </span>
                                                <?php  } ?>
                                        </div>
                                           <?php  } ?>


                                    </div>

                                    <?php  if(!empty($g['fullbackid'])) { ?>
                                    <div>

                                        <div class="rr-label">??????</div>
                                        <?php  if($item['status'] == "?????????") { ?>
                                        <div class="rr-process" id="">
                                        <?php  echo tpl_selector_new('goodsid',array(
                                    'required'=>true,
                                            'type'=>'goods',
                                            'url'=>webUrl('sale/fullback/info', array(
                                                    'order_id' => $item['id'],
                                                    'goods_id'=>$g['id'],
                                                    'option_id'=>$g['option_id']
                                                )
                                            ),
                                            'items'=>$item,
                                            'nokeywords'=>1,
                                            'autosearch'=>1,
                                            'buttontext' => "????????????",
                                            ))
                                            ?></div>
                                        <?php  } ?>
                                    </div>
                                    <?php  } ?>

                                    <span style="float: right;text-align: right;display: inline-block;position: relative;right:5px ;">
                                        ???<?php  echo number_format($g['oldprice']/$g['total'],2)?><br/>
                                        x<?php  echo $g['total'];?><br/>
                                        <?php  if($g['single_refundstate']==8) { ?>
                                            <span class="text-danger">?????????</span>
                                        <?php  } else if($g['single_refundstate']==9) { ?>
                                            <span class="text-danger">????????????</span>
                                        <?php  } else if($g['single_refundstate']==1) { ?>
                                            <span class="text-danger">?????????</span>
                                        <?php  } else if($g['single_refundstate']==2) { ?>
                                            <span class="text-danger">?????????</span>
                                        <?php  } ?>
                                    </span>
                                </div>
                            </div>
                            <?php  } } ?>
                        </div>

                        <div class="list-inner saler columnFlex"   style='text-align: center;' >
                            <div class="">
                                <?php if(cv('member.list.edit')) { ?>
                                <a href="<?php  echo webUrl('member/list/detail',array('id'=>$item['mid']))?>"> <?php  echo $item['nickname'];?></a>
                                <?php  } else { ?>
                                <?php  echo $item['nickname'];?>
                                <?php  } ?>
                                <?php  echo $item['addressdata']['realname'];?><br/><?php  echo $item['addressdata']['mobile'];?>
                            </div>
                        </div>
                        <div class="list-inner paystyle columnFlex"  style='text-align:center;' >
                            <div class="">
                                <!-- ????????? -->
                                <?php  if($item['statusvalue'] > 0) { ?>
                                <?php  if($item['paytypevalue']==1) { ?>
                                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;"></i><span>????????????</span></span>
                                <?php  } else if($item['paytypevalue']==11) { ?>
                                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>????????????</span>
                                <?php  } else if($item['paytypevalue']==21) { ?>
                                <span> <i class="icow icow-weixinzhifu text-success" style="font-size: 17px"></i>????????????</span>
                                <?php  } else if($item['paytypevalue']==22) { ?>
                                <span><i class="icow icow-zhifubaozhifu text-primary" style="font-size: 17px"></i>???????????????</span>
                                <?php  } ?>
                                <?php  } else if($item['statusvalue'] == 0) { ?>
                                <!-- ????????? -->
                                <?php  if($item['paytypevalue']!=3) { ?>
                                <label class='label label-default'>?????????</label>
                                <?php  } else { ?>
                                <span> <i class="text-primary icow icow-icon" style="font-size: 17px"></i>????????????</span>
                                <?php  } ?>
                                <?php  } else if($item['statusvalue'] == -1) { ?>
                                <?php  if($item['paytypevalue']==1) { ?>
                                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;display:inline-block;height: 17px;width: 17px;padding-top: 3px"></i><span>????????????</span></span>
                                <?php  } else if($item['paytypevalue']==11) { ?>
                                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>????????????</span>
                                <?php  } else if($item['paytypevalue']==21) { ?>
                                <span> <i class="icow icow-weixin text-success" style="font-size: 17px"></i>????????????</span>
                                <?php  } else if($item['paytypevalue']==22) { ?>
                                <span><i class="icow icow-zhifubao text-primary" style="font-size: 17px"></i>???????????????</span>
                                <?php  } ?>
                                <?php  } ?>

                                <?php  if($item['paytypevalue'] == 3 && $item['is_cashier'] == 1) { ?>
                                <span style='margin-top:5px;display:block;'>?????????????????????</span>
                                <?php  } else { ?>
                                <span style='margin-top:5px;display:block;'><?php  echo $item['dispatchname'];?></span>
                                <?php  } ?>
                            </div>
                        </div>
                        <div class="columnFlex" style="flex: 1;">
                            <div  class="list-inner" data-toggle='popover' data-html='true' data-placement='right' data-trigger="hover"
                                data-content="<table style='width:100%;'>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>???<?php  echo number_format( $item['goodsprice'] ,2)?></td>
                                    </tr>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????</td>
                                        <td  style='border:none;text-align:right;;'>???<?php  echo number_format( $item['olddispatchprice'],2)?></td>
                                    </tr>
                                    <?php  if($item['taskdiscountprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['taskdiscountprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['lotterydiscountprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['lotterydiscountprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['discountprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['discountprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['deductprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['deductprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['deductcredit2']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['deductcredit2'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['deductenough']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['deductenough'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['merchdeductenough']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['merchdeductenough'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['couponprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>??????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['couponprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['isdiscountprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['isdiscountprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if($item['buyagainprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>?????????????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['buyagainprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>
                                      <?php  if($item['seckilldiscountprice']>0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'>-???<?php  echo number_format( $item['seckilldiscountprice'],2)?></td>
                                    </tr>
                                    <?php  } ?>

                                    <?php  if(intval($item['changeprice'])!=0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>???????????????</td>
                                        <td  style='border:none;text-align:right;;'><span style='<?php  if(0<$item['changeprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?>???<?php  echo number_format(abs($item['changeprice']),2)?></span></td>
                                    </tr>
                                    <?php  } ?>
                                    <?php  if(intval($item['changedispatchprice'])!=0) { ?>
                                    <tr>
                                        <td  style='border:none;text-align:right;'>??????????????????</td>
                                        <td  style='border:none;text-align:right;;'><span style='<?php  if(0<$item['changedispatchprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changedispatchprice']) { ?>+<?php  } else { ?>-<?php  } ?>???<?php  echo abs($item['changedispatchprice'])?></span></td>
                                    </tr>
                                    <?php  } ?>
                                    <tr>
                                        <td style='border:none;text-align:right;'>????????????</td>
                                        <td  style=`'border:none;text-align:right;color:green;'>???<?php  echo number_format($item['price'],2)?></td>
                                    </tr>

                                </table>
                    "> <div style='text-align:center'>
                                ???<?php  echo number_format($item['price'],2)?>
                                <?php  if($item['dispatchprice']>0) { ?>
                                <br/>(?????????:???<?php  echo number_format( $item['dispatchprice'],2)?>)
                                <?php  } ?>
                            </div>
                            </div>
                        </div>


                        <!----------------------columnFlex---------------------------------------------->
                        <div  class="list-inner columnFlex" style='text-align:center'>

                            <?php  if($item['refundstate']==3) { ?>
                                <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>
                                    <?php  if($g['single_refundstate']>0) { ?>
                                    <div class="<?php  if($g['single_refundstate']>0) { ?>goodsRefund<?php  } else { ?>noRefund<?php  } ?>">
                                        <a class='op text-primary'  href="<?php  echo webUrl('order/detail', array('id' => $item['id']))?>" >????????????</a>
                                        <?php if(cv('order.op.refund')) { ?>
                                            <?php  if(!empty($g['single_refundid'])) { ?>
                                                <a class='op  text-primary'  href="<?php  echo webUrl('order/op/single_refund', array('id' => $g['ogid']))?>" >??????<?php  if($g['single_refundstate']!=9) { ?>??????<?php  } else { ?>??????<?php  } ?></a>
                                            <?php  } ?>
                                        <?php  } ?>
                                        <?php  if($item['addressid']!=0 && $item['statusvalue']>=2 && $item['sendtype']==0 && $item['city_express_state']==0) { ?>
                                            <a class='op  text-primary'  data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn'],'mobile'=>$item['addressdata']['mobile']))?>">????????????</a>
                                        <?php  } ?>

                                        <?php  if($item['city_express_state']==1) { ?>
                                            <a class='op  text-primary' href="javascript:tip.msgbox.err('??????????????????????????????????????????');">????????????</a>
                                        <?php  } ?>
                                        <?php  if($item['invoicename'] && $item['sta']>0) { ?>
                                            <?php  $invoice_info = m('sale')->parseInvoiceInfo($item['invoicename']);?>
                                            <?php  if($invoice_info['title'] && $invoice_info['entity'] === false) { ?>
                                                <a class='<?php  if($item['invoice_img']) { ?>text-success<?php  } else { ?>text-danger<?php  } ?>' data-toggle="ajaxModal"href="<?php  echo webUrl('order.op.upload_invoice',array('order_id'=>$item['id']));?>">
                                                <?php  if($item['invoice_img']) { ?>????????????<?php  } else { ?>????????????<?php  } ?></a>
                                            <?php  } ?>
                                        <?php  } ?>
                                    </div>
                                    <?php  } ?>

                                    <?php  if($k+1==count($item['goods']) && $g['single_refundstate']==0) { ?>
                                        <div class="<?php  if($g['single_refundstate']>0) { ?>goodsRefund<?php  } else { ?>noRefund<?php  } ?>">
                                            <a class='op text-primary'  href="<?php  echo webUrl('order/detail', array('id' => $item['id']))?>" >????????????</a>
                                                <?php  if($item['addressid']!=0 && $item['statusvalue']>=2 && $item['sendtype']==0 && $item['city_express_state']==0) { ?>
                                                    <a class='op  text-primary'  data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn'],'mobile'=>$item['addressdata']['mobile']))?>">????????????</a>
                                                <?php  } ?>

                                                <?php  if($item['city_express_state']==1) { ?>
                                                    <a class='op  text-primary' href="javascript:tip.msgbox.err('??????????????????????????????????????????');">????????????</a>
                                                <?php  } ?>
                                                <?php  if($item['invoicename'] && $item['sta']>0) { ?>
                                                    <?php  $invoice_info = m('sale')->parseInvoiceInfo($item['invoicename']);?>
                                                    <?php  if($invoice_info['title'] && $invoice_info['entity'] === false) { ?>
                                                        <a class='<?php  if($item['invoice_img']) { ?>text-success<?php  } else { ?>text-danger<?php  } ?>' data-toggle="ajaxModal"href="<?php  echo webUrl('order.op.upload_invoice',array('order_id'=>$item['id']));?>">
                                                        <?php  if($item['invoice_img']) { ?>????????????<?php  } else { ?>????????????<?php  } ?></a>
                                                    <?php  } ?>
                                                <?php  } ?>
                                        </div>
                                    <?php  } ?>
                                <?php  } } ?>
                            <?php  } else { ?>
                                <div class="noRefund">
                                    <a class='op text-primary'  href="<?php  echo webUrl('order/detail', array('id' => $item['id']))?>" >????????????</a>
                                    <?php if(cv('order.op.refund')) { ?>
                                        <?php  if(!empty($item['refundid'])) { ?>
                                        <a class='op text-primary' style="line-height: 30px;"  href="<?php  echo webUrl('order/op/refund', array('id' => $item['id']))?>" >??????<?php  if($item['refundstate']>0) { ?>??????<?php  } else { ?>??????<?php  } ?></a>
                                        <?php  } ?>
                                    <?php  } ?>
                                    <?php  if($item['addressid']!=0 && $item['statusvalue']>=2 && $item['sendtype']==0 && $item['city_express_state']==0) { ?>
                                        <a class='op  text-primary'  data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn'],'mobile'=>$item['addressdata']['mobile']))?>">????????????</a>
                                    <?php  } ?>

                                    <?php  if($item['city_express_state']==1) { ?>
                                        <a class='op  text-primary' href="javascript:tip.msgbox.err('??????????????????????????????????????????');">????????????</a>
                                    <?php  } ?>
                                    <?php  if($item['invoicename'] && $item['status_id']>0) { ?>
                                        <?php  $invoice_info = m('sale')->parseInvoiceInfo($item['invoicename']);?>
                                        <?php  if($invoice_info['title'] && $invoice_info['entity'] === false) { ?>
                                            <a class='<?php  if($item['invoice_img']) { ?>text-success<?php  } else { ?>text-danger<?php  } ?>' data-toggle="ajaxModal"href="<?php  echo webUrl('order.op.upload_invoice',array('order_id'=>$item['id']));?>">
                                            <?php  if($item['invoice_img']) { ?>????????????<?php  } else { ?>????????????<?php  } ?></a>
                                        <?php  } ?>
                                    <?php  } ?>
                                </div>
                            <?php  } ?>
                        </div>

                        <div  class='ops list-inner columnFlex' style='line-height:20px;text-align:center' >
                           <div class="">
                               <span class='text-<?php  echo $item['statuscss'];?>'><?php  echo $item['status'];?></span>
                               <?php  if($item['merchid'] == 0) { ?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('order/ops', TEMPLATE_INCLUDEPATH)) : (include template('order/ops', TEMPLATE_INCLUDEPATH));?><?php  } ?>
                           </div>
                        </div>
                    </div>
            <?php  if(!empty($item['remark'])) { ?>
            <div class="table-row"><div  style='background:#fdeeee;color:red;flex: 1;;'>????????????: <?php  echo $item['remark'];?></div></div>
            <?php  } ?>

            <?php  if((!empty($level)&&!empty($item['agentid'])) || (!empty($item['merchname']) && $item['merchid'] > 0)) { ?>
            <div class="table-footer table-row" style="margin:0 20px">
                <div  style='text-align:left'>
                    <?php  if(!empty($item['merchname']) && $item['merchid'] > 0) { ?>
                    ???????????????<span class="text-info"><?php  echo $item['merchname'];?></span>
                    <?php  } ?>
                    <?php  if(!empty($agentid)) { ?>
                    <b>??????????????????:</b> <?php  echo $item['level'];?>??? <b>????????????:</b> <?php  echo $item['commission'];?> ???
                    <?php  } ?>
                </div>
                <div  style='text-align:right'>
                    <?php  if(empty($agentid)) { ?>
                    <?php  if($item['commission1']!=-1) { ?><b>1?????????:</b> <?php  echo $item['commission1'];?> ??? <?php  } ?>
                    <?php  if($item['commission2']!=-1) { ?><b>2?????????:</b> <?php  echo $item['commission2'];?> ??? <?php  } ?>
                    <?php  if($item['commission3']!=-1) { ?><b>3?????????:</b> <?php  echo $item['commission3'];?> ??? <?php  } ?>
                    <?php  } ?>

                    <?php  if(!empty($item['agentid']) && !$is_merch[$item['id']]) { ?>
                    <?php if(cv('commission.apply.changecommission')) { ?>
                    <a class="text-primary" data-toggle="ajaxModal"  href="<?php  echo webUrl('commission/apply/changecommission', array('id' => $item['id']))?>">????????????</a>
                    <?php  } ?>
                    <?php  } ?>
                </div>
            </div>
            <?php  } ?>
            </div>
            <?php  } } ?>
                <div style="padding: 20px;text-align: right" >
                        <?php  echo $pager;?>
                </div>
            </div>
        </div>
    </div>
    <?php  } else { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">????????????????????????!</div>
    </div>
    <?php  } ?>
</div>

<script>
    //?????????????????????????????????
    $(function () {
        $('.btn-submit').click(function () {
            var e = $(this).data('export');
            if(e==1 ){
                if($('#keyword').val() !='' ){
                    $('#export').val(1);
                    $('#search').submit();
                }else if($('#searchtime').val()!=''){
                    $('#export').val(1);
                    $('#search').submit();
                }else{
                    tip.msgbox.err('????????????????????????!');
                    return;
                }
            }else{
                $('#export').val(0);
                $('#search').submit();
            }
        })




    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
