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

$job_strings[] = 'echosign_status_updater';
function echosign_status_updater()
{
	require_once('modules/echo_Agreements/echo_Agreements.php');

	$agreement = new echo_Agreements();
	$agreements = $agreement->get_full_list('date_entered', "status_id = 'OUT_FOR_SIGNATURE'");
	
	foreach($agreements as $a)
	{
		$a->checkStatus(); 
	}

	return true;
}


?>