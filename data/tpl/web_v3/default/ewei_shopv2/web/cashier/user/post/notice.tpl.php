<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label must">选择通知人(操作员)</label>
    <div class="col-sm-8">
        <?php if( ce('cashier.user' ,$item) ) { ?>
            <?php  echo tpl_selector('notice_openids',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$operator,'url'=>webUrl('member/query') ))?>
        <?php  } else { ?>
            <div class="input-group multi-img-details" >
                <?php  if(is_array($operator)) { foreach($operator as $item) { ?>
                <div class="multi-item saler-item" openid='<?php  echo $item['openid'];?>'>
                        <input type="hidden" value="<?php  echo $item['openid'];?>" name="notice_openids[]">
                        <img class="img-responsive img-thumbnail" src='<?php  echo $item['avatar'];?>' onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'; this.title='图片未找到.'">
                        <div class='img-nickname'><?php  echo $item['nickname'];?></div>
                </div>
                <?php  } } ?>
            </div>
        <?php  } ?>
        <span class="help-block">可以指定多个人，如果不填写则通知给当前收款操作员</span>
    </div>
</div>
