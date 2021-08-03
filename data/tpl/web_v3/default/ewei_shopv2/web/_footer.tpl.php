<?php defined('IN_IA') or exit('Access Denied');?>
   <div id="page-loading">
        <div class="page-loading-inner">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>
    </div>

    <?php  if(!empty($_W['setting']['copyright']['statcode'])) { ?><?php  echo $_W['setting']['copyright']['statcode'];?><?php  } ?>
   

    
    <style>
        .copyright-footer {
            background: #fff;
            border-radius: 4px;
            margin: 20px 0 0 0;
            padding: 20px 0;
            line-height: 20px;
            color: #999;
            font-size: 12px;
        }
        .copyright-footer a {
            color: #999;
        }
    </style>

<script language='javascript'>
    require(['bootstrap'], function ($) {
        $('[data-toggle="tooltip"]').tooltip("destroy").tooltip({
            container: $(document.body)
        });
        $('[data-toggle="popover"]').popover("destroy").popover({
            container: $(document.body)
        });
    });


<?php  if($_W['isfounder'] && $_W['routes']!='system.auth.upgrade') { ?>
    function check_ewei_shopv2_upgrade() {
  
        require(['util'], function (util) {  
            if (util.cookie.get('checkeweishopv2upgrade_sys')) {
                return;
            }
            $.post('<?php  echo webUrl("system/auth/upgrade/check")?>', function (ret) {
                if (ret && ret.status == '1') { 
		  
	var result = ret.result;	    
                    if(result.filecount>0 || result.database || result.upgrades){
	 	  $('#headingFive').find('.systips').show();
                        if($('#headingFive').attr('aria-expanded')=='false'){
                            $('#headingFive').click();
                        }
                        $('#collapseFive .nomsg').hide();
                        $('#sysversion').text(result.version);
                        $('#sysrelease').text(result.release);
                        $('#collapseFive .upmsg').show();
                    }
                }
            }, 'json');
        });
    }
      function check_ewei_shopv2_upgrade_hide() {
        require(['util'], function (util) {
            util.cookie.set('checkeweishopv2upgrade_sys', 1, 3600);
            $('#ewei-shopv2-upgrade-tips').fadeOut(150);
        });
    }
    $(function () {
        setTimeout( function() {
            check_ewei_shopv2_upgrade();
        },4000);
    });
<?php  } ?>

    $(function () {
        //$('.page-content').show();
        $('.img-thumbnail').each(function () {
            if ($(this).attr('src').indexOf('nopic.jpg') != -1) {
                $(this).attr('src', "<?php echo EWEI_SHOPV2_LOCAL;?>static/images/nopic.jpg");
            }
        })
        <?php  $task_mode =intval(m('cache')->getString('task_mode', 'global'))?>
        <?php  if($task_mode==0) { ?>
            $.getJSON("<?php  echo webUrl('util/task')?>");
        <?php  } ?>
    });
</script>

<script language="javascript">
    myrequire(['web/init']);
    if( $('form.form-validate').length<=0){
        window.formInited = true;
    }
    window.formInitTimer = setInterval(function () {
        if (typeof(window.formInited ) !== 'undefined') {
            $('#page-loading').remove();
            clearInterval(window.formInitTimer);
        }else{
            //$('#page-loading').show();
        }
    }, 1);
</script>

<?php  if($_W['plugin']=='merch' && $_W['merch_user'] ) { ?>
    <script language="javascript">myrequire(['../../plugin/merch/static/js/manage/init']);</script>
<?php  } ?>

</body>

</html>
