<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header">

    当前位置：<span class="text-primary">系统授权</span>

</div>



<div class="page-content">



    <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >

        <div class="form-group">

            <label class="col-lg control-label">域名</label>

            <div class="col-sm-9 col-xs-12">

                <input type="text" name="domain" class="form-control" value="<?php  echo $domain;?>" readonly/>

                <span class="help-block">服务器域名</span>

            </div>

        </div>

        <div class="form-group">

            <label class="col-lg control-label">站点IP</label>

            <div class="col-sm-9 col-xs-12">

                <input type="text" name="ip" class="form-control" value="<?php  echo $ip;?>" readonly/>

                <span class="help-block">站点IP</span>

            </div>

        </div>

        <div class="form-group">

            <label class="col-lg control-label">授权状态</label>

            <div class="col-sm-9 col-xs-12">

                <div class='form-control-static'>

                

                    <span class='label label-primary'>已授权</span>

                 

                </div>

            </div>

        </div>

      
       


     


      

    </form>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>



        