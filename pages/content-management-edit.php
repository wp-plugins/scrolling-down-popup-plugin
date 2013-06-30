<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_Scrolling_Down_Popup_TABLE."
	WHERE `sdp_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$sdp_errors = array();
	$sdp_success = '';
	$sdp_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_Scrolling_Down_Popup_TABLE."`
		WHERE `sdp_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'sdp_id' => $data['sdp_id'],
		'sdp_text' => $data['sdp_text'],
		'sdp_width' => $data['sdp_width'],
		'sdp_left_space' => $data['sdp_left_space'],
		'sdp_top_space' => $data['sdp_top_space'],
		'sdp_speed' => $data['sdp_speed'],
		'sdp_border' => $data['sdp_border'],
		'sdp_background' => $data['sdp_background'],
		'sdp_closebutton' => $data['sdp_closebutton'],
		'sdp_font' => $data['sdp_font'],
		'sdp_font_size' => $data['sdp_font_size'],
		'sdp_date' => $data['sdp_date']
	);
}
// Form submitted, check the data
if (isset($_POST['sdp_form_submit']) && $_POST['sdp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('sdp_form_edit');
	
	$form['sdp_text'] = isset($_POST['sdp_text']) ? $_POST['sdp_text'] : '';
	if ($form['sdp_text'] == '')
	{
		$sdp_errors[] = __('Please enter popup text.', WP_sdp_UNIQUE_NAME);
		$sdp_error_found = TRUE;
	}
	$form['sdp_width'] = isset($_POST['sdp_width']) ? $_POST['sdp_width'] : '';
	if ($form['sdp_width'] == '')
	{
		$sdp_errors[] = __('Please enter popup width.', WP_sdp_UNIQUE_NAME);
		$sdp_error_found = TRUE;
	}
	$form['sdp_left_space'] = isset($_POST['sdp_left_space']) ? $_POST['sdp_left_space'] : '';
	if ($form['sdp_left_space'] == '')
	{
		$sdp_errors[] = __('Please enter popup left space.', WP_sdp_UNIQUE_NAME);
		$sdp_error_found = TRUE;
	}
	$form['sdp_top_space'] = isset($_POST['sdp_top_space']) ? $_POST['sdp_top_space'] : '';
	if ($form['sdp_top_space'] == '')
	{
		$sdp_errors[] = __('Please enter popup top space.', WP_sdp_UNIQUE_NAME);
		$sdp_error_found = TRUE;
	}
	
	$form['sdp_speed'] = isset($_POST['sdp_speed']) ? $_POST['sdp_speed'] : '';
	$form['sdp_border'] = isset($_POST['sdp_border']) ? $_POST['sdp_border'] : '';
	$form['sdp_background'] = isset($_POST['sdp_background']) ? $_POST['sdp_background'] : '';
	$form['sdp_closebutton'] = isset($_POST['sdp_closebutton']) ? $_POST['sdp_closebutton'] : '';
	$form['sdp_font'] = isset($_POST['sdp_font']) ? $_POST['sdp_font'] : '';
	$form['sdp_font_size'] = isset($_POST['sdp_font_size']) ? $_POST['sdp_font_size'] : '';

	//	No errors found, we can add this Group to the table
	if ($sdp_error_found == FALSE)
	{	
		$cur_date = date('Y-m-d G:i:s'); 
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_Scrolling_Down_Popup_TABLE."`
				SET `sdp_text` = %s,
				`sdp_width` = %s,
				`sdp_left_space` = %s,
				`sdp_top_space` = %s,
				`sdp_speed` = %s,
				`sdp_border` = %s,
				`sdp_background` = %s,
				`sdp_closebutton` = %s,
				`sdp_font` = %s,
				`sdp_font_size` = %s,
				`sdp_date` = %s
				WHERE sdp_id = %d
				LIMIT 1",
				array($form['sdp_text'], $form['sdp_width'], $form['sdp_left_space'], $form['sdp_top_space'], $form['sdp_speed'], $form['sdp_border'], $form['sdp_background'],  $form['sdp_closebutton'], $form['sdp_font'], $form['sdp_font_size'], $cur_date, $did)
			);
		$wpdb->query($sSql);
		
		$sdp_success = 'Details was successfully updated.';
	}
}

if ($sdp_error_found == TRUE && isset($sdp_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $sdp_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($sdp_error_found == FALSE && strlen($sdp_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $sdp_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scrolling-down-popup-plugin">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scrolling-down-popup-plugin/pages/scrolling-down-popup-plugin-setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_sdp_TITLE; ?></h2>
	<form name="sdp_form" method="post" action="#" onsubmit="return _sdp_submit()"  >
      <h3>Edit popop</h3>
      <label for="tag-image">Popup text</label>
	  <textarea name="sdp_text" id="sdp_text" cols="130" rows="6"><?php echo stripslashes($form['sdp_text']); ?></textarea>
      <p>Add popup text in the box, we can add HTML content</p>
	  
      <label for="tag-link">Popup window width</label>
      <input name="sdp_width" type="text" id="sdp_width" value="<?php echo $form['sdp_width']; ?>" maxlength="4" />
      <p>Enter width of the popup window, this is mandatory field. (Ex: 300)</p>
	  
	  <label for="tag-link">Position (left space)</label>
      <input name="sdp_left_space" type="text" id="sdp_left_space" value="<?php echo $form['sdp_left_space']; ?>" maxlength="4" />
      <p>Enter window left position, this is mandatory field. (Ex: 500).</p>
	  
	  <label for="tag-link">Position (top space)</label>
      <input name="sdp_top_space" type="text" id="sdp_top_space" value="<?php echo $form['sdp_top_space']; ?>" maxlength="4" />
      <p>Enter window top position, this is mandatory field. (Ex: 200).</p>
	  
	  <label for="tag-link">Scrolling speed</label>
      <input name="sdp_speed" type="text" id="sdp_speed" value="<?php echo $form['sdp_speed']; ?>" maxlength="4" />
      <p>Enter scrolling speed, this is mandatory field. (Ex: 15).</p>
	  
	  <label for="tag-link">Popup window border</label>
      <input name="sdp_border" type="text" id="sdp_border" value="<?php echo $form['sdp_border']; ?>" maxlength="75" />
      <p>Enter popup window border as per example. (Ex: 2px solid #666).</p>
	  
	  <label for="tag-link">Close button position</label>
	  <select name="sdp_closebutton" id="sdp_closebutton">
        <option value='left-top' <?php if($form['sdp_closebutton'] == 'left-top') { echo 'selected' ; } ?>>Left Top</option>
        <option value='right-top' <?php if($form['sdp_closebutton'] == 'right-top') { echo 'selected' ; } ?>>Right Top</option>
        <option value='left-bottom' <?php if($form['sdp_closebutton'] == 'left-bottom') { echo 'selected' ; } ?>>Left Bottom</option>
        <option value='right-bottom' <?php if($form['sdp_closebutton'] == 'right-bottom') { echo 'selected' ; } ?>>Right Bottom</option>
      </select>
      <p>Select popup window close button position.</p>
	  
	  <label for="tag-link">Background color</label>
      <input name="sdp_background" type="text" id="sdp_background" value="<?php echo $form['sdp_background']; ?>" maxlength="10" />
      <p>Enter background color of the popup window as per example. (Ex: #FFFFFF)</p>
	  
	  <label for="tag-link">Font name</label>
      <input name="sdp_font" type="text" id="sdp_font" value="<?php echo $form['sdp_font']; ?>" maxlength="75" />
      <p>Enter popup window font as per example. (Ex: Verdana, Geneva, sans-serif)</p>
	  
	  <label for="tag-link">Font size</label>
      <input name="sdp_font_size" type="text" id="sdp_font_size" value="<?php echo $form['sdp_font_size']; ?>" maxlength="3" />
      <p>Enter the popup window font style as per example. (Ex: 11)</p>
      
      <input name="sdp_id" id="sdp_id" type="hidden" value="">
      <input type="hidden" name="sdp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_sdp_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_sdp_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('sdp_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo WP_sdp_LINK; ?></p>
</div>