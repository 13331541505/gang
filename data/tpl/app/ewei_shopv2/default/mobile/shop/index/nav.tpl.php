<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($navs)) { ?>
	<div class="fui-icon-group noborder">
		<?php  if(is_array($navs)) { foreach($navs as $item) { ?>
			<div class="fui-icon-col" <?php  if(!empty($item['url'])) { ?> onclick="location.href='<?php  echo $item['url'];?>'"<?php  } ?> style="width:20%;">
				<div class="icon"><img src="<?php  echo tomedia($item['icon'])?>" style="width:2rem;height:2rem;" /></div>
				<div class="text" style="padding-top:.4rem;"><?php  echo $item['navname'];?></div>
		    </div>
		<?php  } } ?>
	</div>
 <?php  } ?>

