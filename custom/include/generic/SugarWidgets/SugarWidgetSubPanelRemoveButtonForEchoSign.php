<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
require_once('include/generic/SugarWidgets/SugarWidgetSubPanelRemoveButton.php');

class SugarWidgetSubPanelRemoveButtonForEchoSign extends SugarWidgetSubPanelRemoveButton
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		if(isset($_REQUEST['record']) && isset($_REQUEST['module']) && $_REQUEST['module'] == 'echo_Agreements')
		{
			$agreement_id = $_REQUEST['record'];
			$agreement = new echo_Agreements();
			$agreement->retrieve($agreement_id);
			if($agreement->id){
				if($agreement->status_id != 'DRAFT')
					return '';
			}	
		}
		
		return parent::displayList($layout_def);
	}
}
?>