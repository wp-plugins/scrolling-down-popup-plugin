function _sdp_submit()
{
	if((document.sdp_form.sdp_width.value=="") || isNaN(document.sdp_form.sdp_width.value))
	{
		alert("Please enter the width, only number.")
		document.sdp_form.sdp_width.focus();
		return false;
	}
	else if((document.sdp_form.sdp_left_space.value=="") || isNaN(document.sdp_form.sdp_left_space.value))
	{
		alert("Please enter the position (left space), only number.")
		document.sdp_form.sdp_left_space.focus();
		return false;
	}
	else if((document.sdp_form.sdp_top_space.value=="") || isNaN(document.sdp_form.sdp_top_space.value))
	{
		alert("Please enter the position (top space), only number.")
		document.sdp_form.sdp_top_space.focus();
		return false;
	}
	else if((document.sdp_form.sdp_speed.value=="") || isNaN(document.sdp_form.sdp_speed.value))
	{
		alert("Please enter the scrolling speed, only number.")
		document.sdp_form.sdp_speed.focus();
		return false;
	}
	else if(document.sdp_form.sdp_text.value=="")
	{
		alert("Please enter the message.")
		document.sdp_form.sdp_text.focus();
		return false;
	}

}

function _sdp_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.sdp_display.action="options-general.php?page=scrolling-down-popup-plugin/content-management.php&AC=DEL&DID="+id;
		document.sdp_display.submit();
	}
}	

function _sdp_redirect()
{
	window.location = "options-general.php?page=scrolling-down-popup-plugin/content-management.php";
}