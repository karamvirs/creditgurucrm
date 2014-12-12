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

class SugarWidgetSubPanelTopButtonEchoSignNewAgreement extends SugarWidgetSubPanelTopSelectButton
{
	public function __construct(){
		parent::__construct();
	}

	function display($defines, $additionalFormFields = null)
	{
		$form = '<form method="post" action="index.php">';
		
		$form .= '<input type="hidden" name="module" value="echo_Agreements" />';
		$form .= '<input type="hidden" name="action" value="NewAgreement" />';
		$form .= '<input type="hidden" name="parent_id" value="'.$defines['focus']->id.'" />';
		$form .= '<input type="hidden" name="parent_type" value="'.$defines['focus']->module_dir.'" />';
		
		$form .= '<input type="submit" value="  New Agreement  " name="NewAgreement" class="button" accesskey="A" title="Create [Alt+A]">';
		$form .= '</form>';
		
		return $form;
	}
	
	

}
?>