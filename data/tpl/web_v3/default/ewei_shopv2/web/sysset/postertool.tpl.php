<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">  当前位置：<span class="text-primary">海报缓存清空工具</span></div>
<div class="page-content">
    <form class="form-horizontal form-search">
        <div class="form-group" >
            <label class="col-lg control-label must">清空海报缓存</label>
            <div class="col-sm-9">
                <input id="btn_submit" type="button"  value="立即清空" class="btn btn-primary "  onclick="clear_poster()"/>
                <div class="help-block">如果您上传字体后或修改海报数据不生效，用此工具清空海报缓存再次生成海报</div>
            </div>
        </div>
        <div class="form-group" >
            <label class="col-lg control-label"></label>
            <div class="col-sm-9">
                <div id="message"> </div>
            </div>
        </div>
    </form>
</div>



<script type="text/javascript">
    function clear_poster() {

        $("#btn_submit").val("正在处理...").removeClass("btn-primary").attr("disabled", "true");
        $.post("<?php  echo webUrl('sysset/postertool/clear')?>", {}, function (data) {
            $("#btn_submit").val("立即修复").addClass("btn-primary").removeAttr("disabled");
            tip.msgbox.suc("操作成功!");
            $("#btn_submit").val("立即清空").addClass("btn-primary").removeAttr("disabled");
        }, "json");

    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
