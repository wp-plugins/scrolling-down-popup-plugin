<?php
global $wpdb;
if($wpdb->get_var("show tables like '". WP_Scrolling_Down_Popup_TABLE . "'") != WP_Scrolling_Down_Popup_TABLE) 
{
	$wpdb->query("
		CREATE TABLE IF NOT EXISTS `". WP_Scrolling_Down_Popup_TABLE . "` (
		  `sdp_id` int(11) NOT NULL auto_increment,
		  `sdp_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
		  `sdp_width` int(11) NOT NULL,
		  `sdp_left_space` int(11) NOT NULL,
		  `sdp_top_space` int(11) NOT NULL,
		  `sdp_speed` int(11) NOT NULL,
		  `sdp_border` VARCHAR(30) NOT NULL,
		  `sdp_background` VARCHAR(10) NOT NULL,
		  `sdp_closebutton` VARCHAR(20) NOT NULL,
		  `sdp_font` VARCHAR(100) NOT NULL,
		  `sdp_font_size` VARCHAR(10) NOT NULL,
		  `sdp_date` datetime NOT NULL default '0000-00-00 00:00:00',
		  PRIMARY KEY  (`sdp_id`) )
		");
	
	$c1 = $c1.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="http://www.gopiplus.com/work/wp-content/uploads/2011/01/gopiplus.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	
	$c2 = $c2.'<p align="left"><img style="margin: 5px;text-align:left;float:right;" title="Gopi" src="http://www.gopiplus.com/work/wp-content/uploads/2011/01/gopiplus.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	
	$iIns = "INSERT INTO `". WP_Scrolling_Down_Popup_TABLE . "` (`sdp_text`, `sdp_width`, `sdp_left_space`, `sdp_top_space`, `sdp_speed`, `sdp_border`, `sdp_background`, `sdp_closebutton`, `sdp_font`, `sdp_font_size`)"; 
	$sSql = $iIns . " VALUES ('$c1', 320, 500, 200, 15, '2px solid #666', '#FFFFFF' , 'right-bottom', 'Verdana, Geneva, sans-serif', '11');";
	$wpdb->query($sSql);
	$sSql = $iIns . " VALUES ('$c2', 420, 0, 0, 15, '2px solid #000000', '#DFDFFF' , 'right-bottom', 'Comic Sans MS, cursive', '11');";
	$wpdb->query($sSql);
	$sSql = $iIns . " VALUES ('$c1', 520, 500, 200, 15, '2px solid #oeoeoe', '#FFFFFF' , 'right-bottom', 'Verdana, Geneva, sans-serif', '11');";
	$wpdb->query($sSql);
}
add_option('sdp_cookies', "showalways");
add_option('sdp_widget', "RANDOM");
add_option('sdp_On_Homepage', "YES");
add_option('sdp_On_Posts', "YES");
add_option('sdp_On_Pages', "YES");
add_option('sdp_On_Archives', "NO");
add_option('sdp_On_Search', "NO");
?>