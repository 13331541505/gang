<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/static/css/common.css" />
<div class='fui-page fui-page-current'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<?php  if($category) { ?>
		<div class="title" id="chooseCate">
			<span><?php  if(empty($cate)) { ?>全部商品<?php  } else { ?><?php  echo $cate['name'];?><?php  } ?></span>
			<i class="icon icon-moreunfold" style="vertical-align: middle"></i>
		</div>
		<?php  } else { ?>
		<div class="title">
			<span><?php  if(empty($cate)) { ?>全部商品<?php  } else { ?><?php  echo $cate['name'];?><?php  } ?></span>
		</div>
		<?php  } ?>
		<div class="fui-header-right"></div>
	</div>
	<style>
		.fui-navbar ~ .fui-content, .fui-content.navbar{padding:0;}
		.category {
			height: auto; width: 7rem; background: #fff; position: relative; top: 2rem; left: 0; z-index: 11; margin: auto; border-radius: 0.2rem; border: 1px solid #eee;
			padding: 0.1rem;
			max-height: 10rem;
			display: none;
			box-shadow: 0 0 6px 2px rgba(0,0,0,.04);
		}
		.category .inner {
			padding: 0 0.4rem;
			max-height: 9.6rem;
			overflow-y: auto;
			-webkit-overflow-scrolling: touch;
		}
		.category:before {
			content: '';
			position: absolute;
			top: -0.3rem;
			left: 50%;
			margin-left: -0.25rem;
			height: 0.5rem;
			width: 0.5rem;
			background: #fff;
			border-top: 1px solid #eee;
			border-left: 1px solid #eee;
			transform:rotate(45deg);
			-ms-transform:rotate(45deg);
			-moz-transform:rotate(45deg);
			-webkit-transform:rotate(45deg);
			-o-transform:rotate(45deg);
		}
		.category nav {
			font-size: 0.7rem;
			line-height: 1.6rem;
			position: relative;
			overflow: hidden;
		}
		.category nav:before {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			content: '';
			border-top: 1px solid #eee;
		}
		.category nav:first-child:before {
			border: 0;
		}
	</style>
	<div class="category">
		<div class="inner">
			<?php  if(is_array($category)) { foreach($category as $item) { ?>
			<nav><a href="<?php  echo mobileUrl('creditshop/lists',array('cate'=>$item['id']))?>" class="external"><?php  echo $item['name'];?></a></nav>
			<?php  } } ?>
			<nav><a href="<?php  echo mobileUrl('creditshop/lists')?>" class="external">全部商品</a></nav>
		</div>
	</div>

	<div class='fui-content navbar'>
		<div class="fui-searchbar">
			<div class="searchbar">
				<a class="searchbar-cancel" id="search">搜索</a>
				<div class="search-input">
					<i class="icon icon-search"></i>
					<input type="search" id="keywords" placeholder="输入关键字..." value="<?php  echo $_GPC['keywords'];?>">
				</div>
			</div>
		</div>

		<div class="fui-message fui-message-popup in content-empty" style="display: none; margin: 0; padding: 0; position: relative;">
			<div class="icon ">
				<i class="icon icon-information"></i>
			</div>
			<div class="content">未找到任何产品~</div>
		</div>

		<div class="fui-goods-group block border container"></div>
		<div class='infinite-loading' style="text-align: center; color: #666;">
			<span class='fui-preloader'></span>
			<span class='text'> 正在加载...</span>
		</div>
	</div>
	<script id='tpl_list' type='text/html'>
		<%each list as item%>
		<a href="<?php  echo mobileUrl('creditshop/detail')?>&id=<%item.id%>" data-nocache="false">
			<div class="fui-goods-item">
				<div class="image" style="background-image: url('<%item.thumb%>')"></div>
				<div class="detail">
					<div class="name">
						<span class="fui-subtext">
							<%if item.goodstype == 0%>商品<%/if%>
							<%if item.goodstype == 1%>优惠券<%/if%>
							<%if item.goodstype == 2%>余额<%/if%>
							<%if item.goodstype == 3%>红包<%/if%>
						</span>
						<%if item.subtitle!='' %>
						<span class="fui-label fui-label-danger"><%item.subtitle%></span>
						<%/if%>
						<%item.title%>
					</div>
					<div class="price" style="display: block;">
						<span style="font-size: 0.5rem;float:left;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:78%;">
							<span style="font-size: 0.8rem; padding-right: 0.1rem;font-weight: bold;"><%item.credit%></span>
							<span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
							<%if item.money > 0%>
								 + <span style="font-size: 0.8rem; padding-right: 0.1rem;font-weight: bold;">&yen;<%item.money%></span>
							<%/if%>
						</span>
						<span class="fui-text text-danger2" style="float:right;"><%if item.type==1 %>抽奖<%/if%><%if item.type==0 %>兑换<%/if%></span>
					</div>
				</div>
			</div>
		</a>
		<%/each%>
	</script>

	<script language="javascript">
		require(['../addons/ewei_shopv2/plugin/creditshop/static/js/lists.js'],function(modal){
			modal.init({cate: "<?php  echo $_GPC['cate'];?>", keywords: "<?php  echo $_GPC['keywords'];?>"});
		});
	</script>
</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
