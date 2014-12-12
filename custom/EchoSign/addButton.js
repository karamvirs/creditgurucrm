<script>	
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
function addEchoSignButton(record_id, parent_module) {
	
	// pre 6.5 buttons
	var tds = document.getElementsByTagName("td");
	var last_button = '';
	for (i=0; i < tds.length; i++) {
		if (tds[i].className == "buttons") {
			last_button = tds[i];
		}
	}
	
	var ul = document.getElementById("detail_header_action_menu");
	if(ul){
		var sugar_action_button = ul.firstChild;
		var child = sugar_action_button.firstChild;
		var subnav;
	
		while(child){
			if(child.className == 'subnav'){
				subnav = child;
			}
			child = child.nextSibling;
		}
	}
	
		
	var input = document.createElement("input");
	input.setAttribute("class", "button");
	input.setAttribute("type", "submit");
	input.setAttribute("name", "button");
	input.setAttribute("value", "Create EchoSign Agreement");
	input.setAttribute("title", "Create EchoSign Agreement");
	
	if(parent_module == 'Quotes')
	{
		// 6.5
		if(subnav && subnav.className == 'subnav')
			input.setAttribute("onclick", "ajaxStatus.flashStatus(\'Creating EchoSign Agreement\', 2000);var _form = document.getElementById('formDetailView'); _form.module.value='echo_Agreements'; _form.action.value='CreateAgreementFromModule';_form.return_module.value='Quotes';_form.return_action.value=document.getElementById('sugarpdf').value;SUGAR.ajaxUI.submitForm(_form);");
	}
	else{
		if(subnav && subnav.className == 'subnav')
			input.setAttribute("onclick", "ajaxStatus.flashStatus(\'Creating EchoSign Agreement\', 2000);var _form = document.getElementById('formDetailView'); _form.module.value='echo_Agreements'; _form.action.value='CreateAgreementFromModule';_form.return_module.value='"+parent_module+"';SUGAR.ajaxUI.submitForm(_form);");
	
	}
	
	

	var new_td = document.createElement("td");
	new_td.setAttribute("class", "buttons");
	new_td.setAttribute("align", "left");
	new_td.appendChild(input);
	
	
	// 6.5 
	if(subnav && subnav.className == 'subnav'){
		var li = document.createElement("li");
		li.innerHTML=new_td.innerHTML;	
		subnav.appendChild(li);
	}
	// pre 6.5
	else if(last_button.parentNode){ 
		new_td = get_pre_65_button(record_id, parent_module);
		last_button.parentNode.insertBefore(new_td, last_button);
	}
}


function get_pre_65_button(record_id, parent_module)
{
	var form = document.createElement("form");
	form.setAttribute("action", "index.php");
	form.setAttribute("method", "POST");
	form.setAttribute("name", "Send4Signature");
	form.setAttribute("id", "SendForAgreementForm");
	
	var input1 = document.createElement("input");
	input1.setAttribute("type", "hidden");
	input1.setAttribute("name", "module");
	input1.setAttribute("value", "echo_Agreements");
	var input2 = document.createElement("input");
	input2.setAttribute("type", "hidden");
	input2.setAttribute("name", "record");
	input2.setAttribute("value", record_id);
	var input3 = document.createElement("input");
	input3.setAttribute("type", "hidden");
	input3.setAttribute("name", "parent_module");
	input3.setAttribute("value", parent_module);
	var input4 = document.createElement("input");
	input4.setAttribute("type", "hidden");
	input4.setAttribute("name", "action");
	input4.setAttribute("value", "CreateAgreementFromModule");
	var input5 = document.createElement("input");
	input5.setAttribute("class", "button");
	input5.setAttribute("type", "submit");
	input5.setAttribute("name", "button");
	input5.setAttribute("value", "Create EchoSign Agreement");
	input5.setAttribute("title", "Create EchoSign Agreement");
	
	if(parent_module == 'Quotes')
	{
		input5.setAttribute("onclick", "if(document.getElementById('sugarpdf')){ this.form.custom_sugarpdf.value=document.getElementById('sugarpdf').value; }else if(value=document.getElementById('layout')){ this.form.custom_sugarpdf.value=document.getElementById('layout').value;}");
		
		var input6 = document.createElement("input");
		input6.setAttribute("type", "hidden");
		input6.setAttribute("name", "custom_sugarpdf");
		input6.setAttribute("id", "custom_sugarpdf");
		input6.setAttribute("value", "");
	}
	
	form.appendChild(input1);
	form.appendChild(input2);
	form.appendChild(input3);
	form.appendChild(input4);
	
	if(parent_module == 'Quotes')
		form.appendChild(input6);
	 
	form.appendChild(input5);
	
	var new_td = document.createElement("td");
	new_td.setAttribute("class", "buttons");
	new_td.setAttribute("align", "left");
	new_td.appendChild(form);
	
	return new_td;
}

</script>