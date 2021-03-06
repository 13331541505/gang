<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
 
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($account)) { ?>编辑<?php  } else { ?>添加<?php  } ?>公众号权限 <small><?php  if(!empty($account)) { ?>修改【<?php  echo $account['name'];?>】权限<?php  } ?></small></span>
</div>
 
 <div class="page-content">
     <div class="page-sub-toolbar">
         <span class=''>
                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('system/plugin/perm/add')?>">添加新权限</a>
            </span>
     </div>
     <form id="dataform" action="" method="post" class="form-horizontal form-validate" >
         <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />



         <div class="form-group type-wechat">
             <label class="col-lg control-label"><span style='color:red'>*</span>  选择公众号</label>
             <div class="col-sm-9 col-xs-12">

                 <?php  echo tpl_selector('acid',array(
                'preview'=>false,
                 'text'=>'name',
                 'key'=>'acid',
                 'url'=>webUrl('system/plugin/perm/query'),
                 'items'=>$account,
                 'placeholder'=>'公众号名称',
                 'buttontext'=>"选择公众号"))
                 ?>

             </div>
         </div>
         <div class="form-group form-coms">
             <label class="col-lg control-label">开放组件</label>
             <div class="col-sm-9 col-xs-12">
                 <label class='checkbox-inline'>
                     <input type='checkbox' name='coms[]' class='com-all' value=''/> 全选
                 </label>
                 <br/>

                 <?php  if(is_array($coms)) { foreach($coms as $com) { ?>
                 <label class='checkbox-inline' style='margin:0;margin-right:5px;'>
                     <input type='checkbox' name='coms[]' class='com-item' value='<?php  echo $com['identity'];?>' <?php  if(in_array($com['identity'],$item_coms)) { ?> checked<?php  } ?> /> <?php  echo $com['name'];?>
                 </label>
                 <?php  } } ?>
             </div>
         </div>

         <div class="form-group form-plugins">
             <label class="col-lg control-label">开放插件</label>
             <div class="col-sm-9 col-xs-12">
                 <label class='checkbox-inline'>
                     <input type='checkbox' name='plugins[]' class='plugin-all' value=''/> 全选
                 </label>
                 <br/>

                 <?php  if(is_array($plugins)) { foreach($plugins as $plugin) { ?>
                 <label class='checkbox-inline' style='margin:0;margin-right:5px;'>
                     <input type='checkbox' name='plugins[]' class='plugin-item' value='<?php  echo $plugin['identity'];?>' <?php  if(in_array($plugin['identity'],$item_plugins)) { ?> checked<?php  } ?> /> <?php  echo $plugin['name'];?>
                 </label>
                 <?php  } } ?>
             </div>
         </div>

         <div class="form-group">
             <label class="col-lg control-label">允许增加多商户数量</label>
             <div class="col-sm-8">
                 <div class="input-group fixsingle-input-group">
                     <input type="text" name="datas[max_merch]" class="form-control" value="<?php  echo $datas['max_merch'];?>">
                     <span class="input-group-addon">个</span>
                 </div>
                 <span class="help-block">默认为空或者默认0都为不限制</span>
             </div>
         </div>


         <div class="form-group"></div>
         <div class="form-group">
             <label class="col-lg control-label"></label>
             <div class="col-sm-9 col-xs-12">
                 <input type="submit"  value="提交" class="btn btn-primary" />
                 <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />
             </div>
         </div>
     </form>
 </div>

<script language='javascript'>
    function checkAll(obj) {
        var allcheck = true;
        $('.plugin-item').each(function () {
            if (!$(this).get(0).checked) {
                allcheck = false;
                return false;
            }
        });
        $(".plugin-all").get(0).checked = allcheck;
    }
    function checkAllCom(obj) {
        var allcheck = true;
        $('.com-item').each(function () {
            if (!$(this).get(0).checked) {
                allcheck = false;
                return false;
            }
        });
        $(".com-all").get(0).checked = allcheck;
    }
    $(function () {
        $('.plugin-item').click(function () {
            checkAll();
        });
        $('.com-item').click(function () {
            checkAllCom();
        });
        $('.plugin-all').click(function () {
            var check = $(this).get(0).checked;
            $('.plugin-item').each(function () {
                $(this).get(0).checked = check;
            });
        })

        $('.com-all').click(function () {
            var check = $(this).get(0).checked;
            $('.com-item').each(function () {
                $(this).get(0).checked = check;
            });
        })

        $(":radio[name=type]").click(function () {
            if ($(this).val() == '0') {
                $('.type-wechat').hide();
                $('.type-user').show();
            }
            else {
                $('.type-wechat').show();
                $('.type-user').hide();
            }
        })
    });
    $('form').submit(function () {
        var $this = $(this);
        var type = $(":radio[name=type]:checked").val();
        if (type == '0') {
            if ($(':input[name=user]').isEmpty()) {
                tip.msgbox.err('请选择用户!');
                $(':input[name=user]').focus();
                $this.attr('stop', 1);
                return false;
            }
        } else {
            if ($(":input[name='acid']").isEmpty()) {
                tip.msgbox.err('请选择公众号!');
                $(':input[name=acid]').focus();
                $this.attr('stop', 1);
                return false;
            }
        }
        $this.removeAttr('stop');
        return true;
    });

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
