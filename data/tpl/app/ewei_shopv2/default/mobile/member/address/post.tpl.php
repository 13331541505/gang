<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .fui-cell-group:not(.fui-cell-group-o):before{
        border:0
    }
    .fui-cell-group:first-child{
        margin-top: 0;
    }
</style>
<div class='fui-page  fui-page-current'>
    <!--<div class="fui-header">-->
    <!--    <div class="fui-header-left">-->
    <!--        <a class="back"></a>-->
    <!--    </div>-->
    <!--    <div class="title"><?php  if(empty($address)) { ?>新建地址<?php  } else { ?>编辑地址<?php  } ?></div>-->
    <!--    <div class="fui-header-right"><a data-toggle="delete" data-addressid="<?php  echo $address['id'];?>"><?php  if(!empty($address)) { ?>删除<?php  } ?></a></div>-->
    <!--</div>-->
    <div class='fui-content'>
        <?php  if(is_weixin() && $_W['shopset']['trade']['shareaddress']) { ?>
        <!--<div class="fui-cell-group order-info noborder">-->
            <!--<a class="fui-cell" id="btn-address">-->
                <!--<div class="fui-cell-text">-->
                    <!--从微信选择地址-->
                <!--</div>-->
                <!--<div class="fui-cell-remark text-danger">-->
                <!--</div>-->
            <!--</a>-->


        <!--</div>-->
        <?php  } ?>
        <form method='post' class='form-ajax' >
            <input type='hidden' id='addressid' value="<?php  echo $address['id'];?>"/>
            <div class='fui-cell-group'>
                <div class='fui-cell'>

                    <div class='fui-cell-label'>收货人</div>
                    <div class='fui-cell-info c000'><input type="text" id='realname'  name='realname' value="<?php  echo $address['realname'];?>" placeholder="请填写收货人姓名" class="fui-input"/></div>
                </div>
                <div class='fui-cell'>
                    <div class='fui-cell-label'>联系电话</div>

                    <div class='fui-cell-info c000'><input type="tel" id='mobile' name='mobile' value="<?php  echo $address['mobile'];?>" placeholder="请填写联系电话"  class="fui-input"/></div>
                </div>

                <div class='fui-cell'>
                    <div class='fui-cell-label'>所在地区</div>
                    <div class='fui-cell-info c000'><input type="text" id='areas'  name='areas' data-value="<?php  if(!empty($show_data) && !empty($address)) { ?><?php  echo $address['datavalue'];?><?php  } ?>" value="<?php  if(!empty($address)) { ?><?php  echo $address['province'];?> <?php  echo $address['city'];?> <?php  echo $address['area'];?><?php  } ?>" placeholder="所在地区"  class="fui-input" readonly=""/></div>
                </div>

                <?php  if(!empty($new_area) && !empty($address_street)) { ?>
                <div class='fui-cell'>
                    <div class='fui-cell-label'>所在街道</div>
                    <div class='fui-cell-info c000'><input type="text" id='street'  name='street' data-value="<?php  if(!empty($address)) { ?><?php  echo $address['streetdatavalue'];?><?php  } ?>" value="<?php  if(!empty($address)) { ?><?php  echo $address['street'];?><?php  } ?>" placeholder="所在街道"  class="fui-input" readonly=""/></div>
                </div>
                <?php  } ?>

                <div class='fui-cell'>
                    <div class='fui-cell-label'>详细地址</div>
                    <div class='fui-cell-info c000'><input type="text" id='address' name='address' value="<?php  echo $address['address'];?>" placeholder='街道，楼牌号等'  class="fui-input"/></div>
                </div>


                <?php  if(empty($address['isdefault'])) { ?>
                    <div class="fui-cell ">
                        <div class="fui-cell-label" style="width:auto">设置默认地址</div>
                        <div class="fui-cell-info ">
                            <input type="checkbox" id='isdefault' class="fui-switch fui-switch-danger pull-right">
                        </div>
                    </div>
 				<!--<div class="fui-cell ">-->
                    <!--<div class="fui-cell-label" style="width:auto">设置默认地址</div>-->
                    <!--<div class="fui-cell-info  c000"><input type="checkbox" class="fui-switch fui-switch-danger pull-right"data-toggle="setdefault" data-addressid="<?php  echo $address['id'];?>"></div>-->
                <!--</div>-->
                <?php  } ?>
            </div>

            
            <a id="btn-submit" class='external btn btn-danger block' style="margin-top:1.25rem">保存地址</a>
              <?php  if(is_weixin() && $_W['shopset']['trade']['shareaddress']) { ?>
                <!--<a id="btn-address" class='btn btn-success block'>读取微信地址</a>-->
            <?php  } ?>


        </form>
    </div>
    <script language='javascript' type="text/javascript">

//        if(queryArr.indexOf('is_from_wx=1')!=-1 &&  sessionStorage.getItem('addressParams')){
//           var  res =  JSON.parse(sessionStorage.getItem('addressParams'))
//            $("#realname").val(res.userName);
//            $('#mobile').val(res.telNumber);
//            $('#address').val(res.detailInfo);
//            $('#areas').val(res.provinceName + " " + res.cityName + " " + res.countryName);
//            var provinceName = res.provinceName, cityName = res.cityName, countyName = res.countryName;
//            var province_code = 0, city_code = 0, county_code = 0;
//            var xmlfile = '../addons/ewei_shopv2/static/js/dist/area/AreaNew.xml?v=5';
//            xmlDoc = loadXmlFile(xmlfile);
//            if (window.ActiveXObject) {
//                TopnodeList = xmlDoc.selectSingleNode("address").childNodes
//            } else {
//                TopnodeList = xmlDoc.childNodes[0].getElementsByTagName("province")
//            }
//            if (TopnodeList.length > 0) {
//                for (var province_index = 0; province_index < TopnodeList.length; province_index++) {
//                    province = TopnodeList[province_index];
//                    if (province.getAttribute("name") == provinceName && provinceName != null && provinceName.trim().length > 0) {
//                        province_code = province.getAttribute("code");
//                        citys = TopnodeList[province_index].getElementsByTagName("city");
//                        for (var citys_index = 0; citys_index < citys.length; citys_index++) {
//                            if (citys[citys_index].getAttribute("name") == cityName && cityName != null && cityName.trim().length > 0) {
//                                city_code = citys[citys_index].getAttribute("code");
//                                county = TopnodeList[province_index].getElementsByTagName("city")[citys_index].getElementsByTagName("county");
//                                for (var county_index = 0; county_index < county.length; county_index++) {
//                                    if (county[county_index].getAttribute("name") == countyName && countyName != null && countyName.trim().length > 0) {
//                                        county_code = county[county_index].getAttribute("code")
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//            $("#areas").attr("data-value", province_code + " " + city_code + " " + county_code);
//
//        }
//        sessionStorage.setItem('addressParams','')
        require(['biz/member/address'], function (modal) {
            modal.initPost({new_area: <?php  echo $new_area?>, address_street: <?php  echo $address_street?>});
        });
    </script>
    <script language='javascript'>require(['biz/member/address'], function (modal) {
        modal.initList();
    });</script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>