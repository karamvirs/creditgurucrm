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

class echo_AgreementsViewEdit extends ViewEdit
{
	public function display()
	{
		if (isset($this->bean->id)) {
			$this->ss->assign("FILE_OR_HIDDEN", "hidden");
			if (empty($_REQUEST['isDuplicate']) || $_REQUEST['isDuplicate'] == 'false') { $this->ss->assign("DISABLED", "disabled"); }
		} 
		else { $this->ss->assign("FILE_OR_HIDDEN", "file"); }
		

		echo '<link rel="stylesheet" type="text/css" href="modules/Users/PasswordRequirementBox.css">';
		
		parent::display();
	}
 }

?>
