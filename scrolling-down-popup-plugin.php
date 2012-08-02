<?php

/*
Plugin Name: Scrolling down popup plugin
Plugin URI: http://www.gopiplus.com/work/2011/07/23/scrolling-down-popup-wordpress-plugin/
Description: Scrolling down popup plugin create the popup window with drop in scrolling effect. With this plugin we can confirm that particular content on your page gets attention to user. 
Author: Gopi.R
Version: 5.0
Author URI: http://www.gopiplus.com/work/2011/07/23/scrolling-down-popup-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2011/07/23/scrolling-down-popup-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_Scrolling_Down_Popup_TABLE", $wpdb->prefix . "scrolling_down_popup");

function Scrolling_Down_Popup()
{
	if(is_home() && get_option('sdp_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('sdp_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('sdp_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('sdp_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('sdp_On_Search') == 'YES') {	$display = "show";	}
	
	if($display == "show")
	{
		Scrolling_Down_Popup_Show();
	}
}

function Scrolling_Down_Popup_Show()
{
	global $wpdb;
	
	$sdp_cookies = get_option('sdp_cookies');
	$sdp_widget = get_option('sdp_widget');
	
	if($sdp_cookies == "showalways")
	{
		$sdp_cookies = "showalways";
	}
	else
	{
		$sdp_cookies = "oncepersession";
	}
	
	$sSql = "select * from ".WP_Scrolling_Down_Popup_TABLE." where 1=1";
	
	if($sdp_widget == "RANDOM")
	{
		$sSql = $sSql . " Order by rand()";
	}
	else
	{
		list($caption, $value) = split('[/.:]', $sdp_widget);
		$value = substr($value,0,(strlen($value)-1));
		if(is_numeric(@$value)) 
		{
			$sSql = $sSql . " and sdp_id=$value";
		}
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$data = $data[0];
		$sdp_text = stripslashes($data->sdp_text);
		$sdp_width = $data->sdp_width;
		$sdp_left_space = $data->sdp_left_space;
		$sdp_top_space = $data->sdp_top_space;
		$sdp_speed = $data->sdp_speed;
		$sdp_border = $data->sdp_border;
		$sdp_background = $data->sdp_background;
		$sdp_closebutton = $data->sdp_closebutton;
		$sdp_font = $data->sdp_font;
		$sdp_font_size = $data->sdp_font_size;
	}
	else
	{
		$sdp_text = "Check your filter condtion($value)";
	}
	
	if($sdp_font <> "") { $sdp_font = "font-family: ".$sdp_font.";"; }
	if($sdp_border <> "") { $sdp_border = "border: ".$sdp_border.";"; }
	if($sdp_background <> "") { $sdp_background = "background-color: ".$sdp_background.";"; }
	//left-top/right-top/left-bottom/right-bottom
	if($sdp_closebutton == "left-top")
	{
		$sdp_closebutton = "left: 5px;top:5px;";
	}
	else if($sdp_closebutton == "right-top")
	{
		$sdp_closebutton = "right: 5px;top:5px;";
	}
	else if($sdp_closebutton == "left-bottom")
	{
		$sdp_closebutton = "left: 5px;bottom:5px;";
	}
	else if($sdp_closebutton == "right-bottom")
	{
		$sdp_closebutton = "right: 5px;bottom:5px;";
	}
	else
	{
		$sdp_closebutton = "right: 5px;bottom:5px;";
	}
	
	if(!is_numeric(@$sdp_width)) { @$sdp_width = 300 ;}
	if(!is_numeric(@$sdp_left_space)) { @$sdp_left_space = 500 ;}
	if(!is_numeric(@$sdp_top_space)) { @$sdp_top_space = 200 ;}
	if(!is_numeric(@$sdp_speed)) { @$sdp_speed = 15 ;}
	if(!is_numeric(@$sdp_font_size)) { @$sdp_font_size = 11 ;}
	
	$sdp_width_new = $sdp_width - 20;
	?>
    <style type="text/css">
	#scrolling-down-popup-plugin-top{
	width: <?php echo $sdp_width; ?>px;
	position:absolute;
	z-index: 100;
	overflow:hidden;
	visibility: hidden;
	}
	
	#scrolling-down-popup-plugin{
	width: <?php echo $sdp_width_new; ?>px; 
	<?php echo $sdp_border; ?>
	margin: 0 auto;
	<?php echo $sdp_background; ?>
	<?php echo $sdp_font; ?>
	font-size: <?php echo sdp_font_size; ?>px;
	padding: 4px;
	position:absolute;
	left: 0;
	top: 0;
	}
	</style>
    <script type="text/javascript">
		var scrolling_down_popup_plugin_left_space = <?php echo $sdp_left_space; ?>;
		var scrolling_down_popup_plugin_top_space = <?php echo $sdp_top_space; ?>;
		var scrolling_down_popup_plugin_speed = <?php echo $sdp_speed; ?>;
		var scrolling_down_popup_plugin_cookies = "<?php echo $sdp_cookies; ?>";
	</script>
    <div id="scrolling-down-popup-plugin-top">
        <div id="scrolling-down-popup-plugin"> 
            <div style="position: absolute;<?php echo $sdp_closebutton; ?>"><a href="#" onClick="dismissboxv2();return false"><img src="<?php echo get_option('siteurl') ; ?>/wp-content/plugins/scrolling-down-popup-plugin/close.jpg" /></a></div>
			<?php echo $sdp_text; ?>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo get_option('siteurl') ; ?>/wp-content/plugins/scrolling-down-popup-plugin/scrolling-down-popup-plugin.js"></script>
    <?php
}

function Scrolling_Down_Popup_activation()
{
	include_once("Scrolling_Down_Popup_activation.php");
}

function Scrolling_Down_Popup_deactivate()
{
	
}

function Scrolling_Down_Popup_add_to_menu()
{
	if (is_admin()) 
	{
		add_options_page('Scrolling down popup','Scrolling down popup','manage_options',__FILE__,'Scrolling_Down_Popup_admin_options');  
		add_options_page('Scrolling down popup', '', 'manage_options', "scrolling-down-popup-plugin/content-management.php",'' );
	}
}

function Scrolling_Down_Popup_admin_options()
{
	
	echo '<div class="wrap">';
	echo '<h2>Scrolling down popup</h2>';
    
	$sdp_On_Homepage = get_option('sdp_On_Homepage');
	$sdp_On_Posts = get_option('sdp_On_Posts');
	$sdp_On_Pages = get_option('sdp_On_Pages');
	$sdp_On_Archives = get_option('sdp_On_Archives');
	$sdp_On_Search = get_option('sdp_On_Search');
	$sdp_cookies = get_option('sdp_cookies');
	$sdp_widget = get_option('sdp_widget');
	$sdp_close = get_option('sdp_close');
	
	if (@$_POST['sdp_submit']) 
	{
		$sdp_On_Homepage = stripslashes(trim($_POST['sdp_On_Homepage']));
		$sdp_On_Posts = stripslashes(trim($_POST['sdp_On_Posts']));
		$sdp_On_Pages = stripslashes(trim($_POST['sdp_On_Pages']));
		$sdp_On_Archives = stripslashes(trim($_POST['sdp_On_Archives']));
		$sdp_On_Search = stripslashes(trim($_POST['sdp_On_Search']));
		$sdp_cookies = stripslashes(trim($_POST['sdp_cookies']));
		$sdp_widget = stripslashes(trim($_POST['sdp_widget']));
		$sdp_close = stripslashes(trim($_POST['sdp_close']));
		
		update_option('sdp_On_Homepage', $sdp_On_Homepage );
		update_option('sdp_On_Posts', $sdp_On_Posts );
		update_option('sdp_On_Pages', $sdp_On_Pages );
		update_option('sdp_On_Archives', $sdp_On_Archives );
		update_option('sdp_On_Search', $sdp_On_Search );
		update_option('sdp_cookies', $sdp_cookies );
		update_option('sdp_widget', $sdp_widget );
		update_option('sdp_close', $sdp_close );
	}
	
	echo '<form name="sdp_form" method="post" action="">';
	echo '<br>';
	
	echo 'Display mode (Global setting) :';
	echo '<p><input  style="width: 200px;" maxlength="100" type="text" value="';
	echo $sdp_cookies . '" name="sdp_cookies" id="sdp_cookies" /> (showalways/oncepersession)</p>';
	echo '<br>';
	echo 'Popup display setting :';
	echo '<p>On Homepage:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sdp_On_Homepage . '" name="sdp_On_Homepage" id="sdp_On_Homepage" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Posts:&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sdp_On_Posts . '" name="sdp_On_Posts" id="sdp_On_Posts" /> (YES/NO) </p>';
	echo '<p>On Pages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sdp_On_Pages . '" name="sdp_On_Pages" id="sdp_On_Pages" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Search:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sdp_On_Archives . '" name="sdp_On_Archives" id="sdp_On_Archives" /> (YES/NO) </p>';
	echo '<p>On Archives:&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $sdp_On_Search . '" name="sdp_On_Search" id="sdp_On_Search" /> (YES/NO) </p>';
	echo '<br>';	
	echo 'Display popup content :';
	echo '<p><input  style="width: 200px;" maxlength="100" type="text" value="';
	echo $sdp_widget . '" name="sdp_widget" id="sdp_widget" /> (Enter the content short code (or) Type RANDOM)</p>';
	echo '<br>';
	echo '<input type="submit" id="sdp_submit" name="sdp_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />';
	include_once("button.php");
	
	echo '</form>';
	
	include_once("help.php");
    
	echo '</div>';  
}

add_shortcode( 'scroll-down-popup', 'Scrolling_Down_Popup_shortcode' );

function Scrolling_Down_Popup_shortcode($atts) 
{
	global $wpdb;
	
	//$scode = $matches[1];
	$sdp = "";
	
	//[scroll-down-popup id="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$scode = $atts['id'];
	
	$sdp_cookies = get_option('sdp_cookies');
	
	if($sdp_cookies == "showalways")
	{
		$sdp_cookies = "showalways";
	}
	else
	{
		$sdp_cookies = "oncepersession";
	}
	
	$sSql = "select * from ".WP_Scrolling_Down_Popup_TABLE." where 1=1";
	
	if(is_numeric(@$scode)) 
	{
		$sSql = $sSql . " and sdp_id=$scode";
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$data = $data[0];
		$sdp_text = stripslashes($data->sdp_text);
		$sdp_width = $data->sdp_width;
		$sdp_left_space = $data->sdp_left_space;
		$sdp_top_space = $data->sdp_top_space;
		$sdp_speed = $data->sdp_speed;
		$sdp_border = $data->sdp_border;
		$sdp_background = $data->sdp_background;
		$sdp_closebutton = $data->sdp_closebutton;
		$sdp_font = $data->sdp_font;
		$sdp_font_size = $data->sdp_font_size;
	}
	else
	{
		$sdp_text = "Check your filter short code($value)";
	}
	
	if($sdp_font <> "") { $sdp_font = "font-family: ".$sdp_font.";"; }
	if($sdp_border <> "") { $sdp_border = "border: ".$sdp_border.";"; }
	if($sdp_background <> "") { $sdp_background = "background-color: ".$sdp_background.";"; }
	//left-top/right-top/left-bottom/right-bottom
	if($sdp_closebutton == "left-top")
	{
		$sdp_closebutton = "left: 5px;top:5px;";
	}
	else if($sdp_closebutton == "right-top")
	{
		$sdp_closebutton = "right: 5px;top:5px;";
	}
	else if($sdp_closebutton == "left-bottom")
	{
		$sdp_closebutton = "left: 5px;bottom:5px;";
	}
	else if($sdp_closebutton == "right-bottom")
	{
		$sdp_closebutton = "right: 5px;bottom:5px;";
	}
	else
	{
		$sdp_closebutton = "right: 5px;bottom:5px;";
	}
	
	if(!is_numeric(@$sdp_width)) { @$sdp_width = 300 ;}
	if(!is_numeric(@$sdp_left_space)) { @$sdp_left_space = 500 ;}
	if(!is_numeric(@$sdp_top_space)) { @$sdp_top_space = 200 ;}
	if(!is_numeric(@$sdp_speed)) { @$sdp_speed = 15 ;}
	if(!is_numeric(@$sdp_font_size)) { @$sdp_font_size = 11 ;}
	
	$sdp_width_new = $sdp_width - 20;

    $sdp = $sdp . '<style type="text/css">';
	$sdp = $sdp . '#scrolling-down-popup-plugin-top{';
	$sdp = $sdp . 'width: '.$sdp_width.'px;';
	$sdp = $sdp . 'position:absolute;';
	$sdp = $sdp . 'z-index: 100;';
	$sdp = $sdp . 'overflow:hidden;';
	$sdp = $sdp . 'visibility: hidden;';
	$sdp = $sdp . '}';
	
	$sdp = $sdp . '#scrolling-down-popup-plugin{';
	$sdp = $sdp . 'width: '.$sdp_width_new.'px; ';
	$sdp = $sdp . $sdp_border;
	$sdp = $sdp . 'margin: 0 auto;';
	$sdp = $sdp . $sdp_background;
	$sdp = $sdp . $sdp_font;
	$sdp = $sdp . 'padding: 4px;';
	$sdp = $sdp . 'font-size: '.$sdp_font_size.'px; ';
	$sdp = $sdp . 'position:absolute;';
	$sdp = $sdp . 'left: 0;';
	$sdp = $sdp . 'top: 0;';
	$sdp = $sdp . '}';
	$sdp = $sdp . '</style>';
	
    $sdp = $sdp . '<script type="text/javascript">';
		$sdp = $sdp . 'var scrolling_down_popup_plugin_left_space = '.$sdp_left_space.';';
		$sdp = $sdp . 'var scrolling_down_popup_plugin_top_space = '.$sdp_top_space.';';
		$sdp = $sdp . 'var scrolling_down_popup_plugin_speed = '.$sdp_speed.';';
		$sdp = $sdp . 'var scrolling_down_popup_plugin_cookies = "'.$sdp_cookies.'";';
	$sdp = $sdp . '</script>';
	
    $sdp = $sdp . '<div id="scrolling-down-popup-plugin-top">';
        $sdp = $sdp . '<div id="scrolling-down-popup-plugin">';
            $sdp = $sdp . '<div style="position: absolute;'.$sdp_closebutton.'"><a href="#" onClick="dismissboxv2();return false"><img src="'.get_option('siteurl').'/wp-content/plugins/scrolling-down-popup-plugin/close.jpg" /></a></div>';
			$sdp = $sdp . $sdp_text;
        $sdp = $sdp . '</div>';
    $sdp = $sdp . '</div>';
	
    $sdp = $sdp . '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/scrolling-down-popup-plugin/scrolling-down-popup-plugin.js"></script>';
	return $sdp;
}

register_activation_hook(__FILE__, 'Scrolling_Down_Popup_activation');
add_action('admin_menu', 'Scrolling_Down_Popup_add_to_menu');
register_deactivation_hook( __FILE__, 'Scrolling_Down_Popup_deactivate');
?>