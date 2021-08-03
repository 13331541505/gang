<?php
/*WEMECMS  QQ4424986*/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Debug_EweiShopV2Page extends WebPage
{
	public function main()
	{
		phpinfo();
	}
}

?>
