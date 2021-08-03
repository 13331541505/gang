<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="tpl_credit">
    <%each list as item%>
        <div class="fui-list credit-list noclick">
            <a class="fui-list-media" href="<?php  echo mobileUrl('mmanage/member/detail')?>&id=<%item.mid%>" data-nocache="true">
                <img class="round" src="<%item.avatar%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg';" />
            </a>
            <div class="fui-list-inner">
                <div class="row">
                    <div class="row-text">
                        <%if item.username%><span class="fui-label fui-label-success round"><%item.username%></span><%else%><span class="fui-label fui-label-default round">本人</span><%/if%><%item.nickname||"未更新"%></div>
                    <div class="row-remark text-success"><%type==2?"积分":"余额"%> <%item.num%></div>
                </div>
                <div class="row gary">
                    <div class="row-text">姓名: <%item.realname||"未设置"%> 手机号: <%item.mobile||"未设置"%></div>
                </div>
                <div class="row">
                    <div class="row-text black">备注: <%item.remark||"无"%> </div>
                </div>
                <div class="row">
                    <div class="row-text gray">时间: <%item.createtime%></div>
                </div>
            </div>
        </div>
    <%/each%>
</script>

<script type="text/html" id="tpl_log_0">
    <%each list as item%>
        <div class="fui-list-group" data-id="<%item.id%>" data-rechargetype="<%item.rechargetype%>">
            <div class="fui-list order-list noclick">
                <div class="fui-list-inner">
                    <div class="row">
                        <div class="row-text"><%item.logno%></div>
                        <div class="row-remark text-success">金额 <%item.money%></div>
                    </div>
                </div>
            </div>
            <div class="fui-list recharge-list noclick">
                <a class="fui-list-media" href="<?php  echo mobileUrl('mmanage/member/detail')?>&id=<%item.mid%>" data-nocache="true">
                    <img class="round" src="<%item.avatar%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg';" />
                </a>
                <div class="fui-list-inner">
                    <div class="title"><%item.nickname%></div>
                    <div class="title">
                        <span class="total half black">真实姓名: <%item.realname||"未设置"%></span>
                        <span class="total half black">手机号: <%item.mobile||"未设置"%></span>
                    </div>
                    <div class="title">
                        <span class="total half black">充值状态: <%if item.status==0%><span class="fui-label fui-label-default round">未充值</span><%/if%>
                            <%if item.status==1%><span class="fui-label fui-label-success label-status round">成功</span><%/if%>
                            <%if item.status==-1%><span class="fui-label fui-label-warning round">失败</span><%/if%>
                            <%if item.status==3%><span class="fui-label fui-label-danger round">退款</span><%/if%></span>
                        <span class="total half black">充值方式: <%if item.rechargetype=='alipay'%><span class="fui-label fui-label-blue round">支付宝</span><%/if%>
                            <%if item.rechargetype=='wechat'%><span class="fui-label fui-label-success round">微信</span><%/if%>
                            <%if item.rechargetype=='system'%>
                                <%if item.money>0%><span class="fui-label fui-label-primary round">后台</span><%else%><span class="fui-label fui-label-default round">扣款</span><%/if%>
                            <%/if%>
                            <%if item.rechargetype=='ccard'%><span class="fui-label fui-label-primary round">充值卡返佣</span><%/if%>
                            <%if item.rechargetype=='' && item.status==0%>未充值<%/if%></span>
                    </div>
                    <div class="subtitle">
                        <div class="total half">充值时间: <%item.createtime%></div>
                        <div class="total half"></div>
                    </div>
                </div>
            </div>
            <?php if(cv('finance.log.refund')) { ?>
                <%if item.status==1%>
                    <%if item.rechargetype=='alipay' || item.rechargetype=='wechat'%>
                        <div class="fui-list order-list noclick">
                            <div class="fui-list-inner">
                                <div class="subtitle pull-right">
                                    <%if item.apppay==0 && item.rechargetype=='alipay'%>
                                        <span class="text-blue">支付宝退款请至PC端操作</span>
                                    <%else%>
                                        <div class="btn btn-sm btn-danger btn-refund">充值退款</div>
                                    <%/if%>
                                </div>
                            </div>
                        </div>
                    <%/if%>
                <%/if%>
            <?php  } ?>
        </div>
    <%/each%>
</script>

<script type="text/html" id="tpl_log_1">
    <%each list as item%>
        <div class="fui-list-group" data-id="<%item.id%>">
            <div class="fui-list order-list noclick">
                <div class="fui-list-inner">
                    <div class="row">
                        <div class="row-text"><%item.logno%></div>
                        <div class="row-remark">
                            <%if item.status==0%><span class="fui-label fui-label-default label-status round">申请中</span><%/if%>
                            <%if item.status==1%><span class="fui-label fui-label-success round">成功提现</span><%/if%>
                            <%if item.status==-1%><span class="fui-label fui-label-danger round">拒绝提现</span><%/if%>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fui-list log-list noclick">
                <div class="fui-list-inner">
                    <div class="row">
                        <div class="row-text userinfo">
                            <img class="round" src="<%item.avatar%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg';" />
                            <span><%item.nickname||"未更新"%></span>
                        </div>
                        <div class="row-remark"><%if item.applytype==0%><span class="fui-label fui-label-primary round"><%item.typestr%></span><%/if%>
                            <%if item.applytype==2%><span class="fui-label fui-label-blue round"><%item.typestr%></span><%/if%>
                            <%if item.applytype==3%><span class="fui-label fui-label-success round"><%item.typestr%></span><%/if%></div>
                    </div>
                    <div class="row">
                        <div class="row-text loginfo">提现金额: <%item.money%> 应到金额: <%item.realmoney%> 手续费: <%item.deductionmoney%></div>
                    </div>
                </div>
            </div>
            <div class="fui-list log-list noclick">
                <div class="fui-list-inner">
                    <div class="row log-row">
                        <div class="row-text">手机号</div>
                        <div class="row-remark"><%item.mobile||"未设置"%></div>
                    </div>
                    <%if item.applytype==2%>
                        <div class="row log-row">
                            <div class="row-text">姓名</div>
                            <div class="row-remark"><%item.realname%></div>
                        </div>
                        <div class="row log-row">
                            <div class="row-text">支付宝</div>
                            <div class="row-remark"><%item.alipay%></div>
                        </div>
                    <%/if%>
                    <%if item.applytype==3%>
                        <div class="row log-row">
                            <div class="row-text">姓名</div>
                            <div class="row-remark"><%item.applyrealname%></div>
                        </div>
                        <div class="row log-row">
                            <div class="row-text">银行名称</div>
                            <div class="row-remark"><%item.bankname%></div>
                        </div>
                        <div class="row log-row">
                            <div class="row-text">银行卡号</div>
                            <div class="row-remark"><%item.bankcard%></div>
                        </div>
                    <%/if%>
                    <div class="row log-row">
                        <div class="row-text">提现时间</div>
                        <div class="row-remark"><%item.createtime%></div>
                    </div>
                </div>
            </div>
            <%if item.status<1 && item.status!=-1%>
                <div class="fui-list order-list noclick">
                    <div class="fui-list-inner">
                        <span class="subtitle pull-right">
                            <%if item.status==0 || item.status==-1%>
                                <%if item.applytype<2%>
                                    <?php if(cv('finance.log.wechat')) { ?>
                                        <div class="btn btn-sm btn-success btn-apply" data-type="wechat">微信提现</div>
                                    <?php  } ?>
                                <%/if%>
                                <%if item.applytype==2%>
                                    <?php if(cv('finance.log.alipay')) { ?>
                                        <span class="text-blue">支付宝请至PC端操作</span>
                                    <?php  } ?>
                                <%/if%>
                                <?php if(cv('finance.log.manual')) { ?>
                                    <div class="btn btn-sm btn-default btn-apply" data-type="manual">手动提现</div>
                                <?php  } ?>
                            <%/if%>
                            <%if item.status==0%>
                                <?php if(cv('finance.log.refuse')) { ?>
                                    <div class="btn btn-sm btn-danger btn-apply" data-type="refuse">拒绝申请</div>
                                <?php  } ?>
                            <%/if%>
                        </div>
                    </div>
                </div>
            <%/if%>
        </div>
    <%/each%>
</script>
