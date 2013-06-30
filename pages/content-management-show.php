<?php
// Form submitted, check the data
if (isset($_POST['sdp_display']) && $_POST['sdp_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$sdp_success = '';
	$sdp_success_msg = FALSE;
	
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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('sdp_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_Scrolling_Down_Popup_TABLE."`
					WHERE `sdp_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$sdp_success_msg = TRUE;
			$sdp_success = __('Selected record was successfully deleted.', WP_sdp_UNIQUE_NAME);
		}
	}
	
	if ($sdp_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $sdp_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php echo WP_sdp_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scrolling-down-popup-plugin&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_Scrolling_Down_Popup_TABLE."` order by sdp_id";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/scrolling-down-popup-plugin/pages/scrolling-down-popup-plugin-setting.js"></script>
		<form name="sdp_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="sdp_group_item[]" /></th>
			<th scope="col">Popup Content</th>
			<th scope="col" width="160">Short Code</th>
			<th scope="col">Id</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="sdp_group_item[]" /></th>
			<th scope="col">Popup Content</th>
			<th scope="col" width="160">Short Code</th>
			<th scope="col">Id</th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0)
			{
				foreach ($myData as $data)
				{
					$sdp_desc = substr(esc_html(stripslashes($data['sdp_desc'])), 0, 100);
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['sdp_id']; ?>" name="sdp_group_item[]"></th>
						<td>
						<?php echo stripslashes($data['sdp_text']); ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scrolling-down-popup-plugin&amp;ac=edit&amp;did=<?php echo $data['sdp_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:_sdp_delete('<?php echo $data['sdp_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
						</div>
						</td>
						<td>[scroll-down-popup id="<?php echo $data['sdp_id']; ?>"]</td>
						<td><?php echo $data['sdp_id']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 
			}
			else
			{
				?><tr><td colspan="4" align="center">No records available.</td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('sdp_form_show'); ?>
		<input type="hidden" name="sdp_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scrolling-down-popup-plugin&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=scrolling-down-popup-plugin&amp;ac=set">Display setting</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_sdp_FAV; ?>">Help</a>
	  </h2>
	  </div>
	  <div style="height:5px;"></div>
	  <h3>Plugin configuration option</h3>
		<ol>
			<li>Add plugin in the posts or pages using short code.</li>
			<li>Add directly in to the theme using PHP code.</li>
		</ol>
	  <p class="description"><?php echo WP_sdp_LINK; ?></p>
	</div>
</div>