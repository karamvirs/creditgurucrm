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
 
require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopSelectButton.php');

class SugarWidgetSubPanelEchoSignSelectDocumentButton extends SugarWidgetSubPanelTopSelectButton
{
	public function __construct(){
		parent::__construct();
	}

	function display($defines, $additionalFormFields = null)
	{
		return ($defines['focus']->status_id != 'DRAFT') ? '' : parent::display($defines, $additionalFormFields);
	}
	
	
	function &_get_form($defines, $additionalFormFields = null)
	{
		return parent::_get_form($defines, $additionalFormFields);
	}
}
?>