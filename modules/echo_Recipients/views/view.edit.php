<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('include/MVC/View/views/view.edit.php');

class echo_RecipientsViewEdit extends ViewEdit
{
	public function __construct(){
		$this->useForSubpanel = true;
		parent::__construct();
	}

	public function display()
	{
		
		parent::display();
		
		
		// add an event listener on the recipient type field
		echo '<script>
				echosign_update_recipient_field(); 
				YAHOO.util.Event.addListener(document.forms["form_SubpanelQuickCreate_echo_Recipients"].elements["parent_type"], \'change\', echosign_update_recipient_field); 
			</script>';
		
	}
}