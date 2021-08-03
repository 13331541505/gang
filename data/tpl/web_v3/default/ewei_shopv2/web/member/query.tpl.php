<?php defined('IN_IA') or exit('Access Denied');?><div style='max-height:500px;overflow:auto;min-width:850px;'>
<table class="table table-hover" style="min-width:850px;">
    <tbody>   
        <?php  if(is_array($ds)) { foreach($ds as $row) { ?>
        <tr>
            <td>
                <img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
                <?php  if(strexists($row['openid'],'sns_wa')) { ?><i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="" data-original-title="来源: 小程序"></i><?php  } ?>
                <?php  if(strexists($row['openid'],'sns_qq')||strexists($row['openid'],'sns_wx')||strexists($row['openid'],'wap_user')) { ?><i class="icow icow-app" style="color: #44abf7;vertical-align: top;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 全网通(<?php  if(strexists($row['openid'],'wap_user')) { ?>手机号注册<?php  } else { ?>APP<?php  } ?>)"></i><?php  } ?>
                <?php  echo $row['nickname'];?>
            </td>
            <td><?php  echo $row['realname'];?></td>
            <td><?php  echo $row['mobile'];?></td>
            <td style="width:80px;"><a href="javascript:;" onclick='biz.selector.set(this,<?php  echo json_encode(str_replace( "&quot;", "\"", $row ));?>)'>选择</a></td>
        </tr>
        <?php  } } ?>
        <?php  if(count($ds)<=0) { ?>
        <tr> 
            <td colspan='4' align='center'>未找到会员</td>
        </tr>
        <?php  } ?>
    </tbody>
</table>
    </div>