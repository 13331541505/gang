<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back btn-back"></a>
        </div>
        <div class="title">会员详情</div>
        <div class="fui-header-right"></div>
    </div>

    <!-- 顶部tab -->
    <div id="tab" class="fui-tab fui-tab-success fixed">
        <a data-tab="basic" class="active">基本信息</a>
        <a data-tab="trade">交易信息</a>
        <?php  if($hascommission) { ?>
            <a data-tab="commission">分销商信息</a>
        <?php  } ?>
    </div>
    <div class='fui-content navbar'>

        <?php if(cv('member.list.edit')) { ?>
            <input type="hidden" id="mid" value="<?php  echo $member['id'];?>" />
            <input type="hidden" id="level" value="<?php  echo $member['level'];?>" />
            <input type="hidden" id="group" value="<?php  echo $member['groupid'];?>" />
            <input type="hidden" id="agentlevel" value="<?php  echo $member['agentlevel'];?>" />
            <input type="hidden" id="agentselectgoods" value="<?php  echo $member['agentselectgoods'];?>" />
        <?php  } ?>

        <div class="tab-content " id="tab_basic" style="display: block">
            <div class="fui-list-group">
                <div class="fui-list">
                    <div class="fui-list-media external">
                        <img src="<?php  echo $member['avatar'];?>" class="round">
                    </div>
                    <div class="fui-list-inner">
                        <div class="title"><?php echo empty($member['nickname'])?"未更新":$member['nickname']?></div>
                        <div class="subtitle">
                            <?php  if(!$followed) { ?>
                                <?php  if(empty($member['uid'])) { ?>
                                    <label class='fui-label fui-label-default'>未关注</label>
                                <?php  } else { ?>
                                    <label class='fui-label fui-label-warning'>取消关注</label>
                                <?php  } ?>
                            <?php  } else { ?>
                                <label class='fui-label fui-label-success'>已关注</label>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fui-cell-group fui-cell-click">
                <div class="fui-cell <?php if(cv('member.list.edit')) { ?>check-param<?php  } ?>" data-action="level">
                    <div class="fui-cell-label">会员等级</div>
                    <div class="fui-cell-info"><?php  echo $level_title;?></div>
                    <?php if(cv('member.list.edit')) { ?>
                        <div class="fui-cell-remark"></div>
                    <?php  } ?>
                </div>
                <div class="fui-cell <?php if(cv('member.list.edit')) { ?>check-param<?php  } ?>" data-action="group">
                    <div class="fui-cell-label">会员分组</div>
                    <div class="fui-cell-info"><?php  echo $group_title;?></div>
                    <?php if(cv('member.list.edit')) { ?>
                        <div class="fui-cell-remark"></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="fui-cell-group fui-cell-click">
                <a class="fui-cell external" href="<?php if(cv('finance.recharge.credit2')) { ?><?php  echo mobileUrl('mmanage/finance/recharge', array('type'=>0, 'id'=>$member['id']))?><?php  } else { ?>javascript:;<?php  } ?>">
                    <div class="fui-cell-label">余额</div>
                    <div class="fui-cell-info"><?php  echo $member['credit2'];?></div>
                    <?php if(cv('finance.recharge.credit2')) { ?>
                        <div class="fui-cell-remark">充值</div>
                    <?php  } ?>
                </a>
                <a class="fui-cell external" href="<?php if(cv('finance.recharge.credit1')) { ?><?php  echo mobileUrl('mmanage/finance/recharge', array('type'=>1, 'id'=>$member['id']))?><?php  } else { ?>javascript:;<?php  } ?>">
                    <div class="fui-cell-label">积分</div>
                    <div class="fui-cell-info"><?php  echo $member['credit1'];?></div>
                    <?php if(cv('finance.recharge.credit1')) { ?>
                        <div class="fui-cell-remark">充值</div>
                    <?php  } ?>
                </a>
            </div>

            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">真实姓名</div>
                    <div class="fui-cell-info">
                        <?php if(cv('member.list.edit')) { ?>
                            <input type="text" placeholder="请输入真实姓名" class="fui-input" value="<?php  echo $member['realname'];?>" id="realname" />
                        <?php  } else { ?>
                            <?php  echo $member['realname'];?>
                        <?php  } ?>
                    </div>
                </div>
                <?php  if(empty($openbind)) { ?>
                    <div class="fui-cell">
                        <div class="fui-cell-label">手机号</div>
                        <div class="fui-cell-info">
                            <?php if(cv('member.list.edit')) { ?>
                                <input type="tel" placeholder="请输入手机号" class="fui-input" value="<?php  echo $member['mobile'];?>" maxlength="11" id="mobile" />
                            <?php  } else { ?>
                                <?php  echo $member['mobile'];?>
                            <?php  } ?>
                        </div>
                    </div>
                <?php  } ?>
                <div class="fui-cell">
                    <div class="fui-cell-label">微信号</div>
                    <div class="fui-cell-info">
                        <?php if(cv('member.list.edit')) { ?>
                            <input type="text" placeholder="请输入微信号" class="fui-input" value="<?php  echo $member['weixin'];?>" id="weixin" />
                        <?php  } else { ?>
                            <?php  echo $member['weixin'];?>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <?php  if(!empty($openbind)) { ?>
                <div class="fui-title">绑定手机</div>
                <div class="fui-cell-group">
                    <div class="fui-cell">
                        <div class="fui-cell-label">手机号</div>
                        <div class="fui-cell-info">
                            <?php if(cv('member.list.edit')) { ?>
                                <input type="tel" placeholder="请输入手机号" class="fui-input" value="<?php  echo $member['mobile'];?>" maxlength="11" id="mobile" <?php  if(!empty($member['mobile']) && !empty($member['mobileverify'])) { ?>disabled="disabled"<?php  } ?> />
                            <?php  } else { ?>
                                <?php  echo $member['mobile'];?>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="fui-cell ">
                        <div class="fui-cell-label ">绑定状态</div>
                        <div class="fui-cell-info">
                            <?php if(cv('member.list.edit')) { ?>
                                <?php  if(empty($member['mobileverify']) || empty($member['mobile'])) { ?>
                                    <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="mobileverify">
                                <?php  } else { ?>
                                    已绑定
                                <?php  } ?>
                            <?php  } else { ?>
                                <?php  if(empty($member['mobileverify']) || empty($member['mobile'])) { ?>未绑定<?php  } else { ?>已绑定<?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>

                    <?php if(cv('member.list.edit')) { ?>
                        <div class="fui-cell">
                            <div class="fui-cell-label">登录密码</div>
                            <div class="fui-cell-info">
                                <input type="text" placeholder="请输入登录密码(不填则不修改)" class="fui-input" value="" maxlength="11" id="password" />
                            </div>
                        </div>
                    <?php  } ?>
                </div>
            <?php  } ?>

            <div class="fui-cell-group">
                <div class="fui-cell ">
                    <div class="fui-cell-label ">黑名单</div>
                    <div class="fui-cell-info">
                        <?php if(cv('member.list.edit')) { ?>
                            <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="isblack" <?php  if(!empty($member['isblack'])) { ?>checked="checked"<?php  } ?>>
                        <?php  } else { ?>
                            <?php  if(!empty($member['isblack'])) { ?>黑名单<?php  } else { ?>未加入黑名单<?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
            </div>

            <div class="fui-cell-group">
                <div class="fui-cell fui-cell-textarea">
                    <div class="fui-cell-label " style="margin-top: 0;">备注</div>
                    <div class="fui-cell-info">
                        <textarea rows="3" placeholder="请输入商品备注" <?php if(cv('member.list.edit')) { ?>id="content"<?php  } else { ?> disabled<?php  } ?>><?php  echo $member['content'];?></textarea>
                    </div>
                </div>
            </div>

            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">注册时间</div>
                    <div class="fui-cell-info"><?php  echo date("Y-m-d H:i:s",$member['createtime'])?></div>
                </div>
            </div>
        </div>

        <div class="tab-content " id="tab_trade">
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">成交订单数</div>
                    <div class="fui-cell-info"><?php  echo $member['self_ordercount'];?> 单</div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">成交总金额</div>
                    <div class="fui-cell-info"><?php  echo round($member['self_ordermoney'],2)?> 元</div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">最后下单</div>
                    <div class="fui-cell-info"><?php  echo $member['last_ordertime'];?></div>
                </div>
            </div>
        </div>

        <?php  if($hascommission) { ?>
            <div class="tab-content " id="tab_commission">
                <?php  if(!empty($parentagent)) { ?>
                    <div class="fui-title">上级分销商(PC可编辑)</div>
                    <div class="fui-list-group">
                        <a class="fui-list" href="<?php  echo mobileUrl('mmanage/member/detail', array('id'=>$parentagent['id']))?>" data-nocache="true">
                            <div class="fui-list-media">
                                <img src="<?php  echo $parentagent['avatar'];?>" class="round">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title"><?php  echo $parentagent['nickname'];?><?php  if(!empty($parentagent['realname'])) { ?>(<?php  echo $parentagent['realname'];?>)<?php  } ?></div>
                                <div class="subtitle">
                                    <div class="total half">手机号: <?php echo empty($parentagent['mobile'])?"未填写":$parentagent['mobile']?></div>
                                    <div class="total half">微信号: <?php echo empty($parentagent['weixin'])?"未填写":$parentagent['weixin']?></div>
                                </div>
                            </div>
                            <div class="angle"></div>
                        </a>
                    </div>
                <?php  } ?>

                <div class="fui-title">分销商信息</div>
                <div class="fui-cell-group fui-cell-click">
                    <div class="fui-cell noactive">
                        <div class="fui-cell-label ">固定上级</div>
                        <div class="fui-cell-info">
                            <?php if(cv('commission.agent.changeagent&commission.agent.check')) { ?>
                                <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="fixagentid" <?php  if(!empty($member['fixagentid'])) { ?>checked="checked"<?php  } ?>>
                            <?php  } else { ?>
                                <?php  if(!empty($member['fixagentid'])) { ?>固定<?php  } else { ?>不固定<?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="fui-cell noactive">
                        <div class="fui-cell-label ">分销商权限</div>
                        <div class="fui-cell-info">
                            <?php if(cv('commission.agent.check')) { ?>
                                <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="isagent" <?php  if(!empty($member['isagent'])) { ?>checked="checked"<?php  } ?>>
                            <?php  } else { ?>
                                <?php  if(!empty($member['isagent'])) { ?>通过<?php  } else { ?>未通过<?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="fui-cell noactive">
                        <div class="fui-cell-label ">审核通过</div>
                        <div class="fui-cell-info">
                            <?php if(cv('commission.agent.check')) { ?>
                                <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="status" <?php  if(!empty($member['status'])) { ?>checked="checked"<?php  } ?>>
                            <?php  } else { ?>
                                <?php  if(!empty($member['status'])) { ?>通过<?php  } else { ?>未通过<?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="fui-cell noactive">
                        <div class="fui-cell-label ">自动升级</div>
                        <div class="fui-cell-info">
                            <?php if(cv('commission.agent.check')) { ?>
                                <input type="checkbox" class="fui-switch fui-switch-small fui-switch-success pull-right" id="agentnotupgrade" <?php  if(empty($member['agentnotupgrade'])) { ?>checked="checked"<?php  } ?>>
                            <?php  } else { ?>
                                <?php  if(empty($member['agentnotupgrade'])) { ?>是<?php  } else { ?>否<?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="fui-cell <?php if(cv('commission.agent.check')) { ?>check-param<?php  } ?>" data-action="agentlevel">
                        <div class="fui-cell-label">分销商等级</div>
                        <div class="fui-cell-info"><?php  echo $comlevel_title;?></div>
                        <?php if(cv('commission.agent.check')) { ?>
                            <div class="fui-cell-remark"></div>
                        <?php  } ?>
                    </div>
                    <div class="fui-cell <?php if(cv('commission.agent.check')) { ?>check-param<?php  } ?>" data-action="goods">
                        <div class="fui-cell-label">自选商品</div>
                        <div class="fui-cell-info"></div>
                        <?php if(cv('commission.agent.check')) { ?>
                            <div class="fui-cell-remark"><?php  echo $goods_title;?></div>
                        <?php  } else { ?>
                            <div class="fui-cell-remark noremark"><?php  echo $goods_title;?></div>
                        <?php  } ?>
                    </div>
                </div>
                <?php  if($hascommission && $member['status']==1 && $member['isagent']==1) { ?>
                <div class="fui-cell-group">
                    <div class="fui-cell">
                        <div class="fui-cell-label">累计佣金</div>
                        <div class="fui-cell-info"><?php  echo $member['commission_total'];?></div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">已打款佣金</div>
                        <div class="fui-cell-info"><?php  echo $member['commission_pay'];?></div>
                    </div>
                    <?php  if($member['agenttime']) { ?>
                        <div class="fui-cell">
                            <div class="fui-cell-label">成为分销商</div>
                            <div class="fui-cell-info"><?php  echo $member['agenttime'];?></div>
                        </div>
                    <?php  } ?>
                </div>
                <?php  } ?>
            </div>
        <?php  } ?>

        <?php if(cv('member.list.edit')) { ?>
            <div class="btn btn-success block" id="btn-submit">保存</div>
        <?php  } ?>
        <div class="fui-title center">更多设置请至PC端后台</div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/_tpl/member_params', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/_tpl/member_params', TEMPLATE_INCLUDEPATH));?>

    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/mmanage/static/js/member-detail.js'],function(modal){
            modal.initDetail(<?php  echo $json;?>);
        });
    </script>

</div>
<?php  $this->footerMenus(null, $texts)?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
