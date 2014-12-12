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
 
require_once('include/generic/SugarWidgets/SugarWidgetSubPanelDetailViewLink.php');
class SugarWidgetSubPanelRecipientParentLink extends SugarWidgetSubPanelDetailViewLink
{
	
	function displayList(&$layout_def)
	{
		$recipient_id = $layout_def['fields']['ID'];
		include_once('modules/echo_Recipients/echo_Recipients.php');		
		$r = new echo_Recipients();
		$r->retrieve($recipient_id);
		if($r && $r->id)
		{
			if(in_array($r->parent_type, array('Email', 'Fax'))){
				return $layout_def['fields']['NAME'];
			}
			else{
				return '<a href="index.php?module='.$r->parent_type.'&action=DetailView&record='.$r->parent_id.'" title="'.addslashes($r->parent_name).'">'.$r->parent_name.'</a>';
			}
		}
		else return parent::displayList($layout_def);
	}
	
}
