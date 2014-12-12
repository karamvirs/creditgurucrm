/*************************************************************************
*
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2012 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/

YAHOO.util.Event.onDOMReady(echo_init);
function echo_init(){
	
	// Add event listeners to the password fields to make sure they are the same.
	YAHOO.util.Event.addListener('security_password', 'change', check_passwords_match);
	YAHOO.util.Event.addListener('security_password_confirm', 'change', check_passwords_match);
	YAHOO.util.Event.addListener('i_need_to_sign', 'change', update_sig_flow);
	
	YAHOO.util.Event.addListener('security_protect_open', 'change', show_password_fields);
	YAHOO.util.Event.addListener('security_protect_signature', 'change', show_password_fields);
	
	update_sig_flow();
	show_password_fields();
	
	
	var disabledModules=[];
	if(typeof sqs_objects == 'undefined'){ var sqs_objects = new Array; }
	sqs_objects['form_SubpanelQuickCreate_echo_Recipients_parent_name']={"form":"form_SubpanelQuickCreate_echo_Recipients","method":"query","modules":["echo_Agreements"],"group":"or","field_list":["name","id"],"populate_list":["parent_name","parent_id"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};
	
	var buttons = document.getElementsByTagName("input");
	for(var i=0; i < buttons.length; i++){
		if(buttons[i].className == 'button' && buttons[i].id == 'echo_Recipients_subpanel_full_form_button') 
			buttons[i].style.display = "none"
	}

}



function parent_namechangeQS() 
{
	new_module = document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_type"].value;
	if(typeof(disabledModules[new_module]) != 'undefined') {
		sqs_objects["form_SubpanelQuickCreate_echo_Recipients_parent_name"]["disable"] = true;
		if(document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_name"])
			document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_name"].readOnly = true;
	} else {
		sqs_objects["form_SubpanelQuickCreate_echo_Recipients_parent_name"]["disable"] = false;
		if(document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_name"])
			document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_name"].readOnly = false;
	}
	sqs_objects["form_SubpanelQuickCreate_echo_Recipients_parent_name"]["modules"] = new Array(new_module);
	if(typeof QSProcessedFieldsArray != 'undefined'){
	   QSProcessedFieldsArray["form_SubpanelQuickCreate_echo_Recipients_parent_name"] = false;
	}	  
    enableQS(false);
}



/***********************************************************************************************************************
	Recipients Subpanel - When adding a recipient, trigger this method when the parent_type changes. If
	we are adding just an email address or fax number, remove the select lookup buttons and the auto complete stuff.
***********************************************************************************************************************/
function echosign_update_recipient_field()
{
	var parent_type = document.getElementById("parent_type");
	var parent_name = document.getElementById("parent_name");
	var recipient = document.getElementById("echosign_recipient");
	var button1 = document.getElementById("btn_parent_name");
	var button2 = document.getElementById("btn_clr_parent_name");

	if(!recipient){		
		var span = document.createElement("span");
		span.setAttribute("style", "display:inline;");
		span.setAttribute("id", "echosign_recipient");
		parent_name.parentNode.appendChild(span);	
		recipient = document.getElementById("echosign_recipient");
	}
	
	if(parent_type && parent_name && recipient){
		var recipient_field = '';
		
		if(parent_type.value == 'Email'){
			parent_name.style.display = "none";
			var recipient_field = '<input type="text" tabindex="3" title="" value="" maxlength="255" size="30" id="email_address" name="email_address" />';
			button1.style.display = "none";
			button2.style.display = "none";
		}
		else if(parent_type.value == 'Fax'){
			parent_name.style.display = "none";
			var recipient_field = '<input type="text" tabindex="2" title="Fax Number" value="" maxlength="" size="" id="" name="fax_number" />';
			button1.style.display = "none";
			button2.style.display = "none";
		}
		else if(parent_type.value == '' || parent_type.value == '-blank-'){
			parent_name.style.display = "none";
			button1.style.display = "none";
			button2.style.display = "none";
		}
		else{
			parent_name.style.display = "";
			button1.style.display = "";
			button2.style.display = "";
		}
		
		recipient.innerHTML = recipient_field;
	}
}

function show_password_fields()
{
	var password_open = document.getElementById("security_protect_open");
	var password_sign = document.getElementById("security_protect_signature");
	
	var password1 = document.getElementById("security_password");
	var password2 = document.getElementById("security_password_confirm");
	
	if( ((password_open && password_open.checked) || (password_sign && password_sign.checked))){
		if(password1){
			password1.disabled = false;
			password1.style.backgroundColor = '#FFFFFF';
		}
		if(password2){
			password2.disabled = false;
			password2.style.backgroundColor = '#FFFFFF';
		}
	
		addToValidate('EditView', 'security_password', 'encrypt', true, 'Password');
		addToValidate('EditView', 'security_password_confirm', 'encrypt', true, 'Confirm Password');
	
	
		var label = document.getElementById("security_password_label");
		if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SECURITY_PASSWORD') + ' <span class="required">*</span>';
	
		var label = document.getElementById("security_password_confirm_label");
		if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SECURITY_PASSWORD_CONFIRM') + ' <span class="required">*</span>';
	}
	else{
		if(password1){
			password1.disabled = true;
			password1.value = '';
			password1.style.backgroundColor = '#EEEEEE';
		}
		if(password2){
			password2.disabled = true;
			password2.value = '';
			password2.style.backgroundColor = '#EEEEEE';
		}
		
		removeFromValidate('EditView', 'security_password');
		removeFromValidate('EditView', 'security_password_confirm');
		removeFromValidate('EditView', 'security_password');
		removeFromValidate('EditView', 'security_password_confirm');
		
		var label = document.getElementById("security_password_label");
		if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SECURITY_PASSWORD');
		
		var label = document.getElementById("security_password_confirm_label");
		if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SECURITY_PASSWORD_CONFIRM');
		
		var icon = document.getElementById("passwords_match_icon");
		if(icon){ icon.className = ""; }
	}
}


function check_passwords_match()
{
	show_password_fields();
	
	var security_protect_signature = document.getElementById("security_protect_signature");
	var security_protect_open = document.getElementById("security_protect_open");

	var password1 = document.getElementById("security_password");
	var password2 = document.getElementById("security_password_confirm");
	
	// only show an icon if one of the checkboxes is checked
	if(password1 && password2 && security_protect_signature && security_protect_open && 
			(security_protect_signature.checked || security_protect_open.checked)){
		
		var icon = document.getElementById("passwords_match_icon");
		if(icon){
			if(password1.value != password2.value){ 
				icon.className = 'bad'; 
			}
			else{ 
				icon.className = 'good'; 
			}
		}
	}
}



function update_sig_flow(){
	var i_need_to_sign = document.getElementById("i_need_to_sign");
	var signature_flow = document.getElementById("signature_flow");
	if(i_need_to_sign && signature_flow){
		if(i_need_to_sign.checked){
	
			addToValidate('EditView', 'signature_flow', 'enum', true, SUGAR.language.get('echo_Agreements','LBL_SIGNATURE_FLOW'));
			signature_flow.disabled = false;
			signature_flow.style.backgroundColor = '#FFFFFF';
			
			var label = document.getElementById("signature_flow_label");
			if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SIGNATURE_FLOW') + ' <span class="required">*</span>';
		}
		else{
			var label = document.getElementById("signature_flow_label");
			if(label) label.innerHTML = SUGAR.language.get('echo_Agreements','LBL_SIGNATURE_FLOW');
	
			removeFromValidate('EditView', 'signature_flow');
			signature_flow.disabled = true;
			signature_flow.value = '';
			signature_flow.style.backgroundColor = '#eeeeee';
		}
	}
}



function send_document(record_id)
{
	SUGAR.ui.sendingPanel = new YAHOO.widget.Panel("ajaxloading",{width:"240px",fixedcenter:true,close:false,draggable:false,constraintoviewport:false,modal:true,visible:false});
	SUGAR.ui.sendingPanel.setBody('<div id="sendingPage" align="center" style="vertical-align:middle;"><img src="'+SUGAR.themes.loading_image+'" align="absmiddle" /> <b>Sending Agreement... Please Wait...</b></div>');
	SUGAR.ui.sendingPanel.render(document.body);
	SUGAR.ui.sendingPanel.show();	
	
	YAHOO.util.Connect.asyncRequest('POST', 'index.php?module=echo_Agreements' , {success:evaluate_send_agreement, failure:evaluate_send_agreement}, 'to_pdf=1&action=SendDocumentAjax&record='+escape(record_id));
}

function open_interactive(record_id)
{
	SUGAR.ui.loadingPanel2 = new YAHOO.widget.Panel("ajaxloading",{width:"980px",fixedcenter:true,close:false,draggable:true,constraintoviewport:false,modal:true,visible:false});
	SUGAR.ui.loadingPanel2.setBody('<div style="width:100%;border-bottom:1px #000000 solid;margin-bottom:4px;"><b>Host signing for the first signer</b><span style="float:right; text-align;right;"><a onclick="closeHostSigning(\''+record_id +'\');" style="cursor:pointer;">Close [X]</a></span></div><div><iframe src="index.php?module=echo_Agreements&action=EchoSignNow&to_pdf=1&record=' + record_id + '" width="940" height="690" frameborder="0" style="border: 0; overflow: auto" scrolling=yes></iframe></div>');
	SUGAR.ui.loadingPanel2.render(document.body);
	SUGAR.ui.loadingPanel2.show();
}


function evaluate_send_agreement(r)
{
	SUGAR.ui.sendingPanel.destroy();
	
	if(!r) return false;
	
	var return_val = true;
	var data = eval("(" + r.responseText + ")");
	
	if(!data.all_good || data.msg) { 
		alert(data.msg);
		return_val = false;	
	}
	else if(data.sendInteractively)
	{
		var status = document.getElementById("status_id");
		if(status)
		{
			if(data.host_signing_for_first_signer == 1)
				status.innerHTML = '<img src="https://secure.echosign.com/public/logout" width="1" height="1" />Not Yet Sent for Signature';
			else
				status.innerHTML = 'Not Yet Sent for Signature';
		}
		
		
		if(data.mobile){
			open_in_new_tab(data.interactive_url);
		}
		else{
			SUGAR.ui.loadingPanel = new YAHOO.widget.Panel("ajaxloading",{width:"980px",fixedcenter:true,close:false,draggable:true,constraintoviewport:false,modal:true,visible:false});
			SUGAR.ui.loadingPanel.setBody('<div style="width:100%;border-bottom:1px #000000 solid;margin-bottom:4px;"><b>Preview, position signatures or add form fields</b><span style="float:right; text-align;right;"><a onclick="closeInteractive(\''+data.record+'\', \'' + data.host_signing_for_first_signer + '\');" style="cursor:pointer;">Close [X]</a></span></div><div><iframe src="' + data.iframe_url + '" width="940" height="690" frameborder="0" style="border: 0; overflow: auto" scrolling=yes></iframe></div>');
			SUGAR.ui.loadingPanel.render(document.body);
			SUGAR.ui.loadingPanel.show();	
		}
	}
	else{
		
		if(data.host_signing_for_first_signer == 1){
			if(data.mobile){
				if(data.host_signing_url)
					open_in_new_tab(data.host_signing_url);
				else
					open_in_new_tab('index.php?module=echo_Agreements&action=interactive&to_pdf=1&record=' + data.record);
			}
			else{
				open_interactive(data.record);
			}
		}
		else{
			ajaxStatus.flashStatus('Agreement Sent', 2000);
			window.location.reload();
		}
		
	}
	
	return return_val;
}

function open_in_new_tab(url )
{
  var win=window.open(url, '_blank');
  win.focus();
}

function closeInteractive(record_id, host_signing_for_first_signer){
	SUGAR.ui.loadingPanel.destroy();

	if(host_signing_for_first_signer == 1){
		YAHOO.util.Connect.asyncRequest('POST', 'index.php?module=echo_Agreements' , {success:updateStatus, failure:updateStatus}, 'to_pdf=1&action=UpdateStatus&record='+escape(record_id));
		open_interactive(record_id);
	}
	else{
		window.location.reload();
	}
}

function closeHostSigning(record_id){
	SUGAR.ui.loadingPanel2.destroy();
	YAHOO.util.Connect.asyncRequest('POST', 'index.php?module=echo_Agreements' , {success:reloadPage, failure:reloadPage}, 'to_pdf=1&action=UpdateStatus&record='+escape(record_id));
}

function updateStatus(r){
	var data = eval("(" + r.responseText + ")");
	var status = document.getElementById("status_id");
	if(status) status.innerHTML = data.status_id;
}


function reloadPage(r){
	window.location.reload();
}



function nothing(r){}