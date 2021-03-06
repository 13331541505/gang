<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script src="https://cdn.bootcss.com/angular.js/1.6.9/angular.min.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/base.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/notice.js"></script>
<div class="page-header">
    当前位置：<span class="text-primary">公告管理</span>
</div>
<div class="page-content" ng-app="notice_app" ng-controller="notice_controller">
    <div class="alert alert-primary">
        <p>说明:</p>
        <p>1. 本功能为发布系统公告 </p>
    </div>
    <div ng-show="data.list_show">
        <div class="page-toolbar row m-b-sm m-t-sm">
            <div class="col-sm-4">
                <a class='btn btn-primary btn-sm' ng-click="function.add_notice_show();"><i class='fa fa-plus'></i> 添加公告</a>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" ng-model="data.where.search"  name='keyword' placeholder="请输入关键词">
                    <span class="input-group-btn">
                    <button class="btn btn-sm btn-primary" ng-click="function.get_list()"> 搜索</button>
                </span>
                </div>
            </div>
        </div>
        <div ng-show="data.table_show">
            <div class="page-table-header">
                <input type="checkbox"/>
                <div class="btn-group">
                    <button class="btn btn-default btn-sm" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中的公告吗?" data-href="<?php  echo webUrl('open_farm/notice/deleteAll')?>" disabled="disabled">
                        <i class='fa fa-trash'></i>删除
                    </button>
                </div>
            </div>
            <table class="table table-responsive table-hover">
                <thead class="navbar-inner">
                    <tr>
                        <th style="width: 5%;"><input type='checkbox' /></th>
                        <th>标题</th>
                        <th>内容</th>
                        <th style="width: 8%;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(k, v) in data.notice_list.data">
                        <td>
                            <input type='checkbox' name="id_arr[]" ng-value="v.id"/>
                        </td>
                        <td ng-bind="v.title"></td>
                        <td ng-bind="v.content"></td>
                        <td style="text-align:left;">
                            <a href="" class="btn btn-default btn-sm"  ng-click="function.edit_notice_show(this);">
                                <i class='fa fa-edit'></i>
                            </a>
                            <a ng-click="function.delete_notice(v.id);"class="btn btn-default btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="we_app_pages"></div>
        </div>
        <div ng-show="data.empty_show">
            <div class='panel panel-default'>
                <div class='panel-body' style='text-align: center;padding:30px;'>
                    暂时没有任何公告!
                </div>
            </div>
        </div>
    </div>
    <div ng-show="data.add_show">
        <div class="page-toolbar row m-b-sm m-t-sm">
            <div class="col-sm-4">
                <a class='btn btn-primary btn-sm' ng-click="function.add_notice_show();"><i class='fa fa-plus'></i> 添加公告</a>
            </div>
        </div>
        <div class="box box-info">
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="title">标题 :</label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" ng-model="data.notice_info.title" class="form-control" id="title" placeholder=""/>
                            <span class="help-block">填写公告标题</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="content">内容 :</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea style="height: 80px;" class="form-control" ng-model="data.notice_info.content" id="content" name="description"></textarea>
                            <span class="help-block">公告内容</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12"  >
                    <input type="button" value="提交" style="text-align: center" class="btn btn-primary" ng-click="function.add_notice();">
                    <span>
                     <input type="button" name="back" ng-click="function.list_notice_show();"  style='margin-left:10px;'value="返回列表" class="btn btn-default" />
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>