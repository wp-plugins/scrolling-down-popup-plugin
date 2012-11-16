<div style="float:right;">
  <input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=scrolling-down-popup-plugin/content-management.php'" value="Go to - Content Management" type="button" />
  <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=scrolling-down-popup-plugin/scrolling-down-popup-plugin.php'" value="Go to - Popup Setting" type="button" />
  <?php if( $_GET['page'] != "scrolling-down-popup-plugin/scrolling-down-popup-plugin.php" ) { ?>
  <input name="Help" lang="publish" class="button-primary" onclick="_sdp_help()" value="Help" type="button" />
  <?php } ?>
</div>