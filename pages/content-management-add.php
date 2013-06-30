<div class="wrap">
<?php
$sdp_errors = array();
$sdp_success = '';
$sdp_error_found = FALSE;

// Preset the form fields
$form = array(
	'sdp_id' => '',
	'sdp_text' => '',
	'sdp_width' => '',
	'sdp_left_space' => '',
	'sdp_top_space' => '',
	'sdp_speed' => '',
	'sdp_border' => '',
	'sdp_background' => '',
	'sdp_closebutton' => '',
	'sdp_font' => '',
	'sdp_font_size' => '',
	'sdp_date' => ''
);

// Form submitted, check the data
if (isset($_POST['sdp_form_submit']) && $_POST['sdp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('sdp_form_add');
	
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
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_Scrolling_Down_Popup_TABLE."`
			(`sdp_text`, `sdp_width`, `sdp_left_space`, `sdp_top_space`, `sdp_speed`, `sdp_border`, `sdp_background`, `sdp_closebutton`, `sdp_font`, `sdp_font_size`, `sdp_date`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			array($form['sdp_text'], $form['sdp_width'], $form['sdp_left_space'], $form['sdp_top_space'], $form['sdp_speed'], $form['sdp_border'], $form['sdp_background'], $form['sdp_closebutton'], $form['sdp_font'], $form['sdp_font_size'], $cur_date)
		);
		$wpdb->query($sql);
		
		$sdp_success = __('Details was successfully added.', WP_sdp_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'sdp_id' => '',
			'sdp_text' => '',
			'sdp_width' => '',
			'sdp_left_space' => '',
			'sdp_top_space' => '',
			'sdp_speed' => '',
			'sdp_border' => '',
			'sdp_background' => '',
			'sdp_closebutton' => '',
			'sdp_font' => '',
			'sdp_font_size' => '',
			'sdp_date' => ''
		);
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
      <h3>Add popop</h3>
      <label for="tag-image">Popup text</label>
	  <textarea name="sdp_text" id="sdp_text" cols="130" rows="6"><?php echo @$sdp_text_x; ?></textarea>
      <p>Add popup text in the box, we can add HTML content</p>
	  
      <label for="tag-link">Popup window width</label>
      <input name="sdp_width" type="text" id="sdp_width" value="" maxlength="4" />
      <p>Enter width of the popup window, this is mandatory field. (Ex: 300)</p>
	  
	  <label for="tag-link">Position (left space)</label>
      <input name="sdp_left_space" type="text" id="sdp_left_space" value="" maxlength="4" />
      <p>Enter window left position, this is mandatory field. (Ex: 500).</p>
	  
	  <label for="tag-link">Position (top space)</label>
      <input name="sdp_top_space" type="text" id="sdp_top_space" value="" maxlength="4" />
      <p>Enter window top position, this is mandatory field. (Ex: 200).</p>
	  
	  <label for="tag-link">Scrolling speed</label>
      <input name="sdp_speed" type="text" id="sdp_speed" value="" maxlength="4" />
      <p>Enter scrolling speed, this is mandatory field. (Ex: 15).</p>
	  
	  <label for="tag-link">Popup window border</label>
      <input name="sdp_border" type="text" id="sdp_border" value="" maxlength="75" />
      <p>Enter popup window border as per example. (Ex: 2px solid #666).</p>
	  
	  <label for="tag-link">Close button position</label>
      <select name="sdp_closebutton" id="sdp_closebutton">
        <option value='left-top'>Left Top</option>
        <option value='right-top'>Right Top</option>
        <option value='left-bottom'>Left Bottom</option>
        <option value='right-bottom'>Right Bottom</option>
      </select>
      <p>Select popup window close button position.</p>
	  
	  <label for="tag-link">Background color</label>
      <input name="sdp_background" type="text" id="sdp_background" value="" maxlength="10" />
      <p>Enter background color of the popup window as per example. (Ex: #FFFFFF)</p>
	  
	  <label for="tag-link">Font name</label>
      <input name="sdp_font" type="text" id="sdp_font" value="" maxlength="75" />
      <p>Enter popup window font as per example. (Ex: Verdana, Geneva, sans-serif)</p>
	  
	  <label for="tag-link">Font size</label>
      <input name="sdp_font_size" type="text" id="sdp_font_size" value="" maxlength="3" />
      <p>Enter the popup window font style as per example. (Ex: 11)</p>
      
      <input name="sdp_id" id="sdp_id" type="hidden" value="">
      <input type="hidden" name="sdp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Insert Details" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_sdp_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_sdp_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('sdp_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_sdp_LINK; ?></p>
</div>