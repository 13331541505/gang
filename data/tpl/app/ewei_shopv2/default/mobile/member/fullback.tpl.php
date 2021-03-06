<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .fui-list:before{border:none;}
    .fui-according-header .remark:after {
        -webkit-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
        transform: rotate(135deg);
    }
    .fui-according-header .active.remark:after {
        -webkit-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }
    .fullback-container{background: #fafafa;padding:0.5rem;font-size:0.6rem;color:#666;}
    .fullback-container p{height:0.9rem;line-height: 0.9rem;}
    .fui-according{border-bottom:0.5rem solid #ededed;}
    .fui-list-media img{height:3rem;width:3rem;}


    .full-info{
        background: #ff5555;
        padding: 0.6rem;
        color: #fff;
        margin-bottom: 0.6rem;
    }
    .full-info .time{
        font-size: 0.55rem;
        opacity: 0.7;
    }
    .full-info .flex{
        display: flex;
    }
    .full-info .flex div{
        flex: 1;
        text-align: center;
        font-size: 0.75rem;
        margin-top: 0.6rem;
        font-weight: bold;
    }
    .full-info .flex div p{
        font-size: 0.6rem;
        line-height: 1.2rem;
        font-weight: normal;
    }
</style>
<div class='fui-page  fui-page-current member-log-page'>

    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title"><?php  m('sale')->getFullBackText(true)?>记录</div>
    </div>
    <div class='fui-content navbar' style="padding-bottom: 0;">
        <div class="full-info">
            <div class="time">
                创建时间: <span><?php echo date('Y/m/d H:i:s', $alldata['createtime'] ? $alldata['createtime'] : time() )?> </span>
            </div>
            <div class="flex">
                <div>
                        &yen;<?php  echo $alldata['allprice'];?> <p>全返总额</p>
                </div>
                <div>
                    &yen;<?php  echo $alldata['hasprice'];?><p>已返金额</p>
                </div>
                <div>
                    <?php  echo $alldata['day'];?> <p>返还天数 </p>
                </div>
                <div>
                    <?php  echo $alldata['fullbackday'];?> <p>已返天数</p>
                </div>
            </div>

        </div>

        <div id="tab" class="fui-tab fui-tab-danger">
            <a data-tab="tab1"  class="external <?php  if($_GPC['type']==0) { ?>active<?php  } ?>" data-type='0'>未完成</a>
            <a data-tab="tab2" class='external <?php  if($_GPC['type']==1) { ?>active<?php  } ?>'  data-type='1'>已完成</a>
        </div>


        <div class='content-empty' style='display:none;'>
            <i class='icon icon-searchlist'></i><br/>暂时没有任何记录!
        </div>

        <div class='fui-list-group container' style="display:none;"></div>
        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>
    </div>

    <script id="tpl_member_log_list" type="text/html">

        <%each list as log%>
        <div class="fui-list goods-item">
            <div class="fui-list-media image-media" style="padding-top:0.3rem;">
                <a href="<?php  echo mobileUrl('goods/detail');?>&id=<%log.goodsid%>">
                    <img class="round" src="<%log.thumb%>" data-lazyloaded="true">
                </a>
            </div>
            <div class="fui-list-inner">
                <div class='title' style="height:2rem;line-height: 1rem;font-size:0.7rem;overflow: hidden;">
                    <a href="<?php  echo mobileUrl('goods/detail');?>&id=<%log.goodsid%>" style="color:#000;">
                    <%log.title%>
                    </a>
                </div>
                <div class='text' style="height:1rem;line-height: 1rem;font-size:0.6rem;color:#999;">
                    规格：<%log.optionname%>
                </div>
                <!--<div class='text'><%log.createtime%></div>-->
            </div>
            <div class='fui-list-angle' style="height:3rem;">
                <%if log.isfullback==0%>
                <span style="color:#ffa800;font-size:0.7rem;">进行中</span>
                <%/if%>
                <%if log.isfullback==1%>
                <span style="color:#32c570;font-size:0.7rem;">已完成</span>
                <%/if%>
            </div>

        </div>
        <div class='fui-according-group'>
            <div class='fui-according'>
                <div class='fui-according-header fullback-item'>
                    <span class="text"></span>
                    <span class="remark" style="font-size:0.7rem;color:#000;">每天返<%log.priceevery%>元，剩余<%log.surplusday%>天</span>
                </div>
                <div class="fui-according-content store-container" style="display: block;">
                    <div class="fullback-container">
                        <p>总金额：&yen;<%log.price%></p>
                        <p>每天返：&yen;<%log.priceevery%></p>
                        <p>已返金额：&yen;<%log.surplusprice%></p>
                        <p>已返：<%log.fullbackday%>天</p>
                        <p>创建时间：<%log.createtime%></p>
                    </div>
                </div>
            </div>
        </div>
        <%/each%>
    </script>

    <script language='javascript'>
        require(['biz/member/fullback'], function (modal) {
            modal.init({page:"<?php  echo $_GPC['page'];?>",type:"<?php  echo $_GPC['type'];?>",orderid:"<?php  echo $_GPC['orderid'];?>"});
        });
    </script>
    <?php  $this->footerMenus()?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>