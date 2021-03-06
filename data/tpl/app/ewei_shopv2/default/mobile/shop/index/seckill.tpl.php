<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($seckillinfo)) { ?>
<div class="seckill-group seckill-group-1 noborder"
	 data-element=".seckill-group-1"
	 data-view="4"
	 data-free="true"
	 data-space="10"
	 onclick="location.href = core.getUrl('seckill')"
>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shop/index/seckill_tpl', TEMPLATE_INCLUDEPATH)) : (include template('shop/index/seckill_tpl', TEMPLATE_INCLUDEPATH));?>
</div>

<script>

	<?php  if(count($seckillinfo['goods'])>=4) { ?>
	if($(".seckill-group").length>0){

		require(['swiper','../addons/ewei_shopv2/plugin/seckill/static/js/timer.js'], function(modal ,timerutil){
			timerutil.initTimers();

			$(".seckill-group").each(function () {

				var ele = $(this).data('element');
				var container = ele+" .swiper-container";
				var view = $(this).data('view');
				var btn = $(this).data('btn');
				var free = $(this).data('free');
				var space = $(this).data('space');

				var options = {
					pagination: container+' .swiper-pagination',
					slidesPerView: 'auto',
					paginationClickable: true,
					autoHeight: true,
					spaceBetween: space>0 ? space :0,
					onSlideChangeEnd: function (swiper) {
						if(swiper.isEnd){
							location.href = core.getUrl('seckill');
						}
					},

				};
				if(!btn){
					delete options.nextButton;
					delete options.prevButton;
					$(container).find(".swiper-button-next").remove();
					$(container).find(".swiper-button-prev").remove();
				}
				if(free){
					options.freeMode = true;
				}

				var swiper = new Swiper(container, options);
			})
		});
	}
	<?php  } else { ?>
		if($(".seckill-group").length>0) {
			require(['../addons/ewei_shopv2/plugin/seckill/static/js/timer.js'], function (modal) {
				modal.initTimers();
			});
		}
	<?php  } ?>

</script>
<?php  } ?>
