{*
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
*}


{if $UPDATED}
	<script>ajaxStatus.flashStatus('{$MOD.LBL_ECHOSIGN_SAVED}', 1000);</script>
	<div style="padding-top:10px; padding-bottom:20px;">
		Settings Saved. Please run a <a href="index.php?module=Administration&action=repair">Quick Repair and Rebuild</a>
	</div>
{/if}

<h1>{$MOD.LBL_ECHOSIGN_ADMIN_TITLE}</h1>

<form name="EchoSignSettings" method="POST" style="padding-top:10px;">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="EchoSignAdmin">
	<input type="hidden" name="update" value="Update" />
	<input type="hidden" name="view_package" value="studio" />
	
	
	<div class="admin_item">
		{$MOD.LBL_ECHOSIGN_API_KEY} 
		<input type="text" name="echosign_api_key" id="echosign_api_key" value="{$API_KEY}" size="16" maxlength="16" />
	</div>
	
	{if $SHOW_API_URL}
	<div class="admin_item" style="padding-top:10px;">
		{$MOD.LBL_ECHOSIGN_WSDL_URL} 
		<input type="text" name="echosign_wsdl_url" id="echosign_wsdl_url" value="{$WSDL_URL}" size="80" maxlength="160" />
	</div>
	{/if}
	
	<div class="admin_item" style="padding-top:10px;">
		<input type="checkbox" name="use_call_back_method" id="use_call_back_method" value="1" {$USE_CALL_BACK_METHOD} />
		{$MOD.LBL_USE_CALL_BACK_METHOD}
	</div>
	
	<div class="admin_item" style="padding-top:10px;">
		<input type="checkbox" name="show_agreements_inline" id="show_agreements_inline" value="1" {$SHOW_INLINE_AGREEMENTS} />
		{$MOD.LBL_SHOW_AGREEMENTS_INLINE}
	</div>
	
	<div class="admin_item" style="padding-top:10px;">
		<input type="checkbox" name="lock_down_agreements" id="lock_down_agreements" value="1" {$LOCK_DOWN_AGREEMENTS_CHECKED} />
		{$MOD.LBL_LOCK_DOWN_AGREEMENTS}
	</div>
	
	<div class="admin_item" style="padding-top:10px;">
		<input type="checkbox" name="allow_approvers" id="allow_approvers" value="1" {$ALLOW_APPROVERS} />
		{$MOD.LBL_ALLOW_APPROVERS}
	</div>
	
	
	
	<div><br /></div>
	<h3>{$MOD.LBL_ECHOSIGN_ENABLE_DISABLE_RECIPIENTS}</h3>
	
	{$RECIPIENTS_TABLE}
	
	<hr />
	<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" id="echosign_save_button" class="button primary" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" onclick="{$CUSTOM_JS}">
	
	<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.EchoSignSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">			
</form>