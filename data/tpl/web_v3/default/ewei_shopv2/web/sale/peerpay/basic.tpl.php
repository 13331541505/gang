<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-lg control-label">求助语句</label>
	<div class="col-sm-9">
		<div class='recharge-items'>
			<?php  if(is_array($enough1)) { foreach($enough1 as $it) { ?>
			<div class="input-group recharge-item" style="margin-top:5px">
				<input type="text" class="form-control" name='enough1[]' value='<?php  echo $it;?>' />
				<div class='input-group-btn'>
					<button class='btn btn-danger' type='button' onclick="$(this).parents('.recharge-item').remove()"><i class='fa fa-remove'></i></button>
				</div>
			</div>
			<?php  } } ?>
		</div>
		<div style="margin-top:5px">
			<button type='button' class="btn btn-default" onclick='addConsumeItem(this,"enough1")' style="margin-bottom:5px"><i class='fa fa-plus'></i> 增加求助语句</button>
		</div>
		<span class="help-block">随机出现以上一条求助语句 例如 : 万水千山总是情,这单帮我一定行</span>
	</div>
</div>
