<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script src="https://cdn.bootcss.com/angular.js/1.6.9/angular.min.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/base.js"></script>
<script src="<?php echo MODULE_URL;?>/plugin/open_farm/static/web/js/seting.js"></script>
<div class="page-header">
    当前位置：<span class="text-primary">农场设置</span>
</div>
<div class="page-content" ng-app="seting_app" ng-controller="seting_controller">
    <div class="alert alert-primary">
        <p>说明:</p>
        <p>1. 下蛋所需饲料尽量大于食盆里的数量,不然会喂一次饲料下多次蛋 </p>
        <p>2. 修改下蛋所需饲料或食盆数量时,当前正在喂食的用户可能会有下蛋数量的变化,当前一次喂食是使用上一次,下蛋之后使用的是本次修改的设置</p>
        <p>3. 请认真配置下面的参数 ! ! ! </p>
    </div>
    <div class="box box-info">
        <form class="form-horizontal">
            <div class="box-body">
                <div class='form-group-title'>小鸡相关</div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="eat_time">吃一克的时间 (秒) :</label>
                    <div class="col-sm-10 input-group input-group">
                        <input type="text" ng-model="data.seting_info.eat_time" class="form-control" id="eat_time" placeholder="吃一克的时间（秒）">
                        <span class="input-group-addon">秒</span>
                    </div>
                </div>
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="time_steal">食盆中无饲料多久开始偷 (秒) :</label>-->
                    <!--<div class="col-sm-10 input-group input-group">-->
                        <!--<input type="text" class="form-control" id="time_steal" ng-model="data.seting_info.time_steal" placeholder="食盆中无饲料多少秒后开始偷（秒）">-->
                        <!--<span class="input-group-addon">秒</span>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="steal_eat_time">偷吃一克的时间 (秒) :</label>-->
                    <!--<div class="col-sm-10 input-group">-->
                        <!--<input type="text" class="form-control" id="steal_eat_time" ng-model="data.seting_info.steal_eat_time" placeholder="偷吃一克的时间（秒）">-->
                        <!--<span class="input-group-addon">秒</span>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="eat_tips">吃完放置饲料之后的提示:</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="eat_tips" ng-model="data.seting_info.eat_tips" placeholder="吃完放置饲料之后的提示">
                    </div>
                </div>
                <!--<div class='form-group-title'>饲料相关</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="warehouse">仓库储存的饲料总数限制 (克) :</label>-->
                    <!--<div class="col-sm-10 input-group">-->
                        <!--<input type="text" class="form-control" id="warehouse" ng-model="data.seting_info.warehouse" placeholder="仓库储存的饲料总数限制（克）">-->
                        <!--<span class="input-group-addon">克</span>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="bowl">食盆里面的数量限制 (克) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="bowl" ng-model="data.seting_info.bowl" placeholder="食盆里面的数量限制（克）">
                        <span class="input-group-addon">克</span>
                    </div>
                </div>
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="obtain_feed_max">每天获取饲料最多数 (克) :</label>-->
                    <!--<div class="col-sm-10 input-group">-->
                        <!--<input type="text" class="form-control" id="obtain_feed_max" ng-model="data.seting_info.obtain_feed_max" placeholder="获取饲料最多克数（克）,设置数值为限制，不设置为不限制">-->
                        <!--<span class="input-group-addon">克</span>-->

                    <!--</div>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="feed_invalid_time">饲料失效时间 (小时) :</label>-->
                    <!--<div class="col-sm-10 input-group">-->
                        <!--<input type="text" class="form-control" id="feed_invalid_time" ng-model="data.seting_info.feed_invalid_time" placeholder="饲料失效时间（小时）">-->
                        <!--<span class="input-group-addon">小时</span>-->
                    <!--</div>-->
                <!--</div>-->
                <div class='form-group-title'>下蛋相关</div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="lay_eggs_eat">下蛋需要吃多少饲料 (克) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="lay_eggs_eat" ng-model="data.seting_info.lay_eggs_eat" placeholder="下蛋需要吃多少（克）">
                        <span class="input-group-addon">克</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="lay_eggs_tips">下蛋之后的提示消息:</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="lay_eggs_tips" ng-model="data.seting_info.lay_eggs_tips" placeholder="下蛋之后的提示消息">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="lay_eggs_number_min">下蛋最少数 (个) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="lay_eggs_number_min" ng-model="data.seting_info.lay_eggs_number_min" placeholder="下蛋最少个数（个）">
                        <span class="input-group-addon">个</span>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="lay_eggs_number_max">下蛋最多数 (个) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="lay_eggs_number_max" ng-model="data.seting_info.lay_eggs_number_max" placeholder="下蛋最多个数（个）">
                        <span class="input-group-addon">个</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="egg_invalid_time">鸡蛋失效时间 (小时) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="egg_invalid_time" ng-model="data.seting_info.egg_invalid_time" placeholder="鸡蛋失效时间（小时）">
                        <span class="input-group-addon">小时</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="surprised_invalid_time">彩蛋失效时间 (小时) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="surprised_invalid_time" ng-model="data.seting_info.surprised_invalid_time" placeholder="鸡蛋失效时间（小时）">
                        <span class="input-group-addon">小时</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="surprised_probability">生出彩蛋概率 (%) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="surprised_probability" ng-model="data.seting_info.surprised_probability" placeholder="生出彩蛋概率">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class='form-group-title'>其它相关</div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="exchange_integral_max">一天内最多兑换积分:</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="exchange_integral_max" ng-model="data.seting_info.exchange_integral_max" placeholder="一天内最多兑换积分,,设置数值为限制，不设置为不限制">
                        <span class="input-group-addon">积分</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="eat_experience">吃一克的经验:</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="eat_experience" ng-model="data.seting_info.eat_experience" placeholder="吃一克的经验">
                        <span class="input-group-addon">经验</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="rate">鸡蛋与积分的汇率 (个/分) :</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="rate" ng-model="data.seting_info.rate" placeholder="鸡蛋与积分的汇率（/个）">
                        <span class="help-block">框里填写的是一颗蛋能够换取的积分数</span>
                    </div>
                </div>
                <!--<div class="form-group">-->
                    <!--<label class="col-sm-2 control-label" for="advertisement_max">广告个数:</label>-->
                    <!--<div class="col-sm-10 input-group">-->
                        <!--<input type="text" class="form-control" id="advertisement_max" ng-model="data.seting_info.advertisement_max" placeholder="广告个数">-->
                        <!--<span class="input-group-addon">个</span>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="shop">首页商城链接:</label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" id="shop" ng-model="data.seting_info.shop" placeholder="首页商城链接">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" ng-click="function.edit_info();">提交修改</button>
            </div>
        </form>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>