<?php
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

class EchoSignButtons
{
	public function display($event, $args)
	{	
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'DetailView' && isset($GLOBALS['sugar_config']) && isset($GLOBALS['sugar_config']['echosign']))
		{
			if(isset($_REQUEST['module']) && 
					!empty($GLOBALS['sugar_config']['echosign']) && 
					!empty($GLOBALS['sugar_config']['echosign']['button_enabled_modules']) && 
					in_array($_REQUEST['module'], $GLOBALS['sugar_config']['echosign']['button_enabled_modules'])
			){
				include_once('custom/EchoSign/addButton.js');
				echo '<script>
					var btn = document.getElementById("SendForAgreementForm");
					if(!btn) addEchoSignButton("'.addslashes($_REQUEST['record']).'", "'.addslashes($_REQUEST['module']).'");
				</script>';
			}
		}
	}
}