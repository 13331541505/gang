<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('merch/manage/_header_base', TEMPLATE_INCLUDEPATH)) : (include template('merch/manage/_header_base', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    body {
        background: #fff;
    }
    .page-header {
        height: 90px;
        margin: 0;
        padding: 0;
        border-bottom: 1px solid #e5e5e5;
    }
    .page-header:before {
        display: none;
    }
    .page-header .inner {
        height: 90px;
        width: 1080px;
        margin: auto;
    }
    .page-header .inner .logo {
        height: 90px;
        width: auto;
        vertical-align: middle;
    }
    .page-header .inner .logo img {
        max-height: 68px;
        height:68px;
        width: 200px;
        margin-top: 11px;
        vertical-align: middle;
    }

    .page-content {
        display: block;
        float: none;
        width: 1080px;
        margin: auto;
        padding: 72px 0;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        border-bottom: 1px solid #e5e5e5;
    }

    .signup-adv {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        padding-right: 40px;
    }
    .signup-adv img {
        max-height: 100%;
        max-width: 100%;
    }
    .signup-main{
        width: 360px;
        height: 390px;
        padding: 40px;
        border: 1px solid #e5e5e5;
    }
    .signup-main .title {
        color: #333;
        font-size: 16px;
    }
    .signup-main .title span {
        font-size: 12px;
        color: #666;
        padding-left: 4px;
    }
    .signup-main .input {
        height: 38px;
        width: 100%;
        margin-top: 20px;
    }
    .signup-main .input input {
        height: 38px;
        width: 100%;
        border: 1px solid #e5e5e5;
        outline: none;
        border-radius: 3px;
        padding: 0 10px;
        font-size: 14px;
    }
    .signup-main .input input:focus {
        border: 1px solid #44abf7;
    }
    .signup-main .button {
        height: 38px;
        width: 100%;
        margin-top: 14px;
    }
    .signup-main .button input {
        height: 38px;
        width: 100%;
        background: #44abf7;
        border: 0;
        border-radius: 3px;
        color: #fff;
        font-size: 16px;
        outline: none;
    }
    .signup-main .button input:active {
        background: #33a4f7;
    }
    .signup-main .option {
        height: 40px;
        line-height: 40px;
        text-align: right;
        margin-bottom: 5px;
    }
    .signup-main .option span {
        cursor: pointer;
    }
    .signup-main .option span:hover {
        border-bottom: 1px solid #666;
    }
    .signup-main .text {
        border-top: 1px solid #e5e5e5;
        width: 100%;
        padding: 10px 0;
    }
    .signup-main .text p.title {
        font-size: 14px;
        color: #444;
    }
    .signup-main .text p {
        font-size: 12px;
        margin-bottom: 8px;
        color: #999;
    }
</style>
<body>

<div class="page-header">
    <div class="inner">
        <div class="logo">
            <?php  if(!empty($set['reglogo'])) { ?>
                <img src="<?php  echo tomedia($set['reglogo'])?>"/>
            <?php  } ?>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="signup-adv">
        <img src="<?php  if(empty($set['regpic'])) { ?>../addons/ewei_shopv2/plugin/merch/template/mobile/default/static/images/regbg.png<?php  } else { ?><?php  echo tomedia($set['regpic'])?><?php  } ?>" />
    </div>
    <div class="signup-main">
        <div class="title">???????????? <span>???????????????????????????</span></div>
        <div class="input"><input type="text" name="username" placeholder="?????????????????????" /></div>
        <div class="input"><input type="password" name="pwd" placeholder="?????????????????????" /></div>
        <div class="button"><input type="submit" value="??????" id="btn-login" /></div>
        <div class="option"><span class="foget">????????????</span> </div>
        <div class="text">
            <p class="title">????????????</p>
            <p>??????????????????????????????????????????????????????????????????????????????~????????????????????????????????????</p>
        </div>
    </div>
</div>


<script language='javascript'>
    $(".foget").click(function () {
        tip.alert("????????????????????????????????????");
    });
    $(".signup-main .input input").keydown(function (e) {
        if(e.keyCode==13){
            var name = $(this).attr('name');
            var value = $.trim($(this).val());
            if(name=='username' && value!=''){
                $("input[name='pwd']").focus();
            }
            if(name=='pwd' && value!=''){
                $('#btn-login').click();
            }
        }
    });
    $('#btn-login').click(function () {
        if ($(":input[name=username]").isEmpty()) {
            tip.msgbox.err('?????????????????????');
            $(":input[name=username]").focus();
            return;
        }
        if ($(":input[name=pwd]").isEmpty()) {
            tip.msgbox.err('?????????????????????');
            $(":input[name=pwd]").focus();
            return;
        }
        if ($(this).attr('stop')) {
            return;
        }
        $('#btn-login').attr('stop', 1).val('????????????...');
        $.ajax({
            url: "<?php  echo $submitUrl;?>",
            type: 'post',
            data: {username: $(":input[name=username]").val(), pwd: $(":input[name=pwd]").val()},
            dataType: 'json',
            cache: false,
            success: function (ret) {
                if (ret.status == 1) {
                    tip.msgbox.suc("????????????");
                    $('#btn-login').attr('stop', 1).val('?????????...');
                    setTimeout(function () {
                        location.href = ret.result.url;
                    }, 500);
                    return;
                }
                $('#btn-login').removeAttr('stop').val('??????');
                $(":input[name=pwd]").select();
                tip.msgbox.err(ret.result.message);
            }
        })
    })
</script>
<script language="javascript">myrequire(['web/init'],function(){});</script>
<?php  if(!empty($_W['setting']['copyright']['statcode'])) { ?><?php  echo $_W['setting']['copyright']['statcode'];?><?php  } ?>
<?php  if(!empty($copyright) && !empty($copyright['copyright'])) { ?>
<div class="signup-footer" style='width:750px;margin:auto;margin-top:10px;'>
    <div><?php  echo $copyright['copyright'];?></div>
</div>
<?php  } ?>
</body>
</html>