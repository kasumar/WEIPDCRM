<?php
if(!defined('IN_DCRM')) exit('Access Denied');
if($current_version == '1.6.15.3.12'){
	update_final('1.6.15.3.18');
}
if($current_version == '1.6.15.3.18' || $current_version == '1.6.15.3.25' ){
	DB::query('CREATE TABLE IF NOT EXISTS `'.DCRM_CON_PREFIX.'UDID` (
				`ID` int(8) NOT NULL AUTO_INCREMENT,
				`UDID` varchar(128) NOT NULL,
				`Level` int(8) NOT NULL DEFAULT \'0\',
				`Packages` text NOT NULL,
				`Comment` varchar(512) NOT NULL,
				`TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`Downloads` int(8) NOT NULL,
				`IP` bigint NOT NULL,
				`CreateStamp` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
				PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8');
	$exists = DB::fetch_first("Describe `".DCRM_CON_PREFIX."Packages` `Level`");
	if(empty($exists))
		DB::query("ALTER TABLE `".DCRM_CON_PREFIX."Packages` ADD `Level` INT NOT NULL DEFAULT '0' AFTER `UUID` ,
				ADD `Price` CHAR( 8 ) NOT NULL AFTER `Level` ,
				ADD `Purchase_Link` VARCHAR( 512 ) NOT NULL AFTER `Price`");
	DB::query('CREATE TABLE IF NOT EXISTS `'.DCRM_CON_PREFIX.'Options` (
				`option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				`option_name` varchar(64) NOT NULL,
				`option_value` longtext NOT NULL,
				`autoload` varchar(20) NOT NULL DEFAULT \'yes\',
				PRIMARY KEY (`option_id`)
				) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8');
	if(!get_option('udid_level'))
		update_option('udid_level', array( __('Guest'), ''));
	$purchase_link_stat_exists = DB::fetch_first("Describe `".DCRM_CON_PREFIX."Packages` `Purchase_Link_Stat`");
	// 1.6.15.3.26新增
	if(empty($purchase_link_stat_exists))
		DB::query("ALTER TABLE `".DCRM_CON_PREFIX."Packages` ADD `Purchase_Link_Stat` INT NOT NULL DEFAULT '0' AFTER `Purchase_Link`");
	update_option('autofill_depiction', '2');
	update_final('1.6.15.3.26');
}
if($current_version == '1.6.15.3.26'){
	if(file_exists(ROOT.'manage/js/'))
		deldir(ROOT.'manage/js/');
	update_final('1.6.15.3.29');
}