<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script src="https://cdn.bootcss.com/angular.js/1.6.9/angular.min.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/base.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/index.js"></script>
<div class="page-header">
    当前位置：<span class="text-primary">用户统计</span>
</div>
<div class="page-content" ng-app="index_module" ng-controller="index_controller">
    <div class="alert alert-primary">
        <p>说明:</p>
        <p>1. 用户小鸡信息统计 </p>
    </div>
    <div class="box-body">
        <div class="page-toolbar row m-b-sm m-t-sm">
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" ng-model="data.where.search"  name='keyword' value="" placeholder="请输入关键词">
                    <span class="input-group-btn">
                    <button class="btn btn-sm btn-primary" ng-click="function.get_list()"> 搜索</button>
                </span>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body" ng-show="data.table_show">
        <table class="table">
            <thead>
                <tr>
                    <th>用户名</th>
                    <th>头像</th>
                    <th>等级</th>
                    <th>经验</th>
                    <th>进食加速</th>
                    <th>鸡蛋库存</th>
                    <th>饲料库存</th>
                    <th>累计兑换积分</th>
                    <th>创建时间</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="(k, v) in data.chicken_list.data">
                    <td ng-bind="v.name"></td>
                    <td>
                        <img ng-src="{{v.show_portrait}}" class="img-50"/>
                    </td>
                    <td ng-bind="v.level"></td>
                    <td ng-bind="v.experience"></td>
                    <td ng-bind="v.accelerate+'%'"></td>
                    <td ng-bind="v.egg_stock"></td>
                    <td ng-bind="v.feed_stock"></td>
                    <td ng-bind="v.integral"></td>
                    <td ng-bind="v.create_time"></td>
                </tr>
            </tbody>
        </table>
        <div class="list_pages"></div>
    </div>
    <div class="box-body" ng-show="data.empty_show">
        <div class="panel panel-default">
            <div class="panel-body" style="text-align: center;padding:30px;">
                暂时没有任何数据!
            </div>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>