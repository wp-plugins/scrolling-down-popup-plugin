<div class="wrap">
  <?php
 	global $wpdb;
	@$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=scrolling-down-popup-plugin/content-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['sdp_text']) <>"")
    {
			if($_POST['sdp_id'] == "" )
			{
					$sql = "insert into ".WP_Scrolling_Down_Popup_TABLE.""
					. " set `sdp_text` = '" . mysql_real_escape_string(trim($_POST['sdp_text']))
					. "', `sdp_width` = '" . $_POST['sdp_width']
					. "', `sdp_left_space` = '" . $_POST['sdp_left_space']
					. "', `sdp_top_space` = '" . $_POST['sdp_top_space']
					. "', `sdp_speed` = '" . $_POST['sdp_speed']
					. "', `sdp_border` = '" . $_POST['sdp_border']
					. "', `sdp_background` = '" . $_POST['sdp_background']
					. "', `sdp_closebutton` = '" . $_POST['sdp_closebutton']
					. "', `sdp_font` = '" . $_POST['sdp_font']
					. "', `sdp_font_size` = '" . $_POST['sdp_font_size']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_Scrolling_Down_Popup_TABLE.""
					. " set `sdp_text` = '" . mysql_real_escape_string(trim($_POST['sdp_text']))
					. "', `sdp_width` = '" . $_POST['sdp_width']
					. "', `sdp_left_space` = '" . $_POST['sdp_left_space']
					. "', `sdp_top_space` = '" . $_POST['sdp_top_space']
					. "', `sdp_speed` = '" . $_POST['sdp_speed']
					. "', `sdp_border` = '" . $_POST['sdp_border']
					. "', `sdp_background` = '" . $_POST['sdp_background']
					. "', `sdp_closebutton` = '" . $_POST['sdp_closebutton']
					. "', `sdp_font` = '" . $_POST['sdp_font']
					. "', `sdp_font_size` = '" . $_POST['sdp_font_size']
					. "' where `sdp_id` = '" . $_POST['sdp_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_Scrolling_Down_Popup_TABLE." where sdp_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_Scrolling_Down_Popup_TABLE." where sdp_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $sdp_id_x = htmlspecialchars(stripslashes($data->sdp_id)); 
        if ( !empty($data) ) $sdp_text_x = htmlspecialchars(stripslashes($data->sdp_text));
        if ( !empty($data) ) $sdp_width_x = htmlspecialchars(stripslashes($data->sdp_width));
		if ( !empty($data) ) $sdp_left_space_x = htmlspecialchars(stripslashes($data->sdp_left_space));
		if ( !empty($data) ) $sdp_top_space_x = htmlspecialchars(stripslashes($data->sdp_top_space));
		if ( !empty($data) ) $sdp_speed_x = htmlspecialchars(stripslashes($data->sdp_speed));
		if ( !empty($data) ) $sdp_border_x = htmlspecialchars(stripslashes($data->sdp_border));
		if ( !empty($data) ) $sdp_background_x = htmlspecialchars(stripslashes($data->sdp_background));
		if ( !empty($data) ) $sdp_closebutton_x = htmlspecialchars(stripslashes($data->sdp_closebutton));
		if ( !empty($data) ) $sdp_font_x = htmlspecialchars(stripslashes($data->sdp_font));
		if ( !empty($data) ) $sdp_font_size_x = htmlspecialchars(stripslashes($data->sdp_font_size));
        $submittext = "Update Message";
    }
 ?>
  <h2>Scrolling Down Popup</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scrolling-down-popup-plugin/setting.js"></script>
  <form name="sdp_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return _sdp_submit()"  >
    <table width="100%" border="0" cellspacing="4" cellpadding="4">
      <tr>
        <td width="273">Popup Window Width</td>
        <td width="982">:
          <input name="sdp_width" type="text" id="sdp_width" value="<?php echo @$sdp_width_x; ?>" size="20" maxlength="3" />
          (Ex: 300)</td>
      </tr>
      <tr>
        <td>Position (Left Space)</td>
        <td>:
          <input name="sdp_left_space" type="text" id="sdp_left_space" value="<?php echo @$sdp_left_space_x; ?>" size="20" maxlength="3" />
          (Ex: 500)</td>
      </tr>
      <tr>
        <td>Position (Top Space)</td>
        <td>:
          <input name="sdp_top_space" type="text" id="sdp_top_space" value="<?php echo @$sdp_top_space_x; ?>" size="20" maxlength="3" />
          (Ex: 200)</td>
      </tr>
      <tr>
        <td>Scrolling Speed</td>
        <td>:
          <input name="sdp_speed" type="text" id="sdp_speed" value="<?php echo @$sdp_speed_x; ?>" size="20" maxlength="3" />
          (Ex: 15)</td>
      </tr>
      <tr>
        <td>Popup Window Border</td>
        <td>:
          <input name="sdp_border" type="text" id="sdp_border" value="<?php echo @$sdp_border_x; ?>" size="20" maxlength="75" />
          (Ex: 2px solid #666)</td>
      </tr>
      <tr>
        <td>Popup Window Close Button Position</td>
        <td>:
          <input name="sdp_closebutton" type="text" id="sdp_closebutton" value="<?php echo @$sdp_closebutton_x; ?>" size="20" maxlength="75" />
          (Ex: left-top/right-top/left-bottom/right-bottom)</td>
      </tr>
      <tr>
        <td>Popup Window Background Color</td>
        <td>:
          <input name="sdp_background" type="text" id="sdp_background" value="<?php echo @$sdp_background_x; ?>" size="20" maxlength="75" />
          (Ex: #FFFFFF)</td>
      </tr>
      <tr>
        <td>Popup Window Font</td>
        <td>:
          <input name="sdp_font" type="text" id="sdp_font" value="<?php echo @$sdp_font_x; ?>" size="30" maxlength="75" />
          (Ex: Verdana, Geneva, sans-serif)</td>
      </tr>
      <tr>
        <td>Popup Window Font Size</td>
        <td>:
          <input name="sdp_font_size" type="text" id="sdp_font_size" value="<?php echo @$sdp_font_size_x; ?>" size="20" maxlength="75" />
          (Ex: 11)</td>
      </tr>
      <tr>
        <td colspan="2">Add The Popup Text In The Below TextBox (Can add HTML content) :</td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="sdp_text" id="sdp_text" cols="120" rows="10"><?php echo @$sdp_text_x; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="2"><input name="publish" lang="publish" class="button-primary" value="<?php echo $submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onclick="_sdp_redirect()" value="Cancel" type="button" /> <?php include_once("button.php"); ?></td>
      </tr>
    </table>
    <input name="sdp_id" id="sdp_id" type="hidden" value="<?php echo @$sdp_id_x; ?>">
    
  </form>
  
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_Scrolling_Down_Popup_TABLE." order by sdp_id");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="sdp_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="17%" align="left" scope="col">Short Code</th>
            <th align="left" scope="col">Popup Content</th>
            <th width="8%" align="left" scope="col">Action</th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		$displayisthere="True";
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle">[SCROLL-DOWN-POPUP:<?php echo(stripslashes($data->sdp_id)); ?>]</td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->sdp_text)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=scrolling-down-popup-plugin/content-management.php&DID=<?php echo($data->sdp_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_sdp_delete('<?php echo($data->sdp_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available</td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <?php include_once("help.php"); ?>
</div>