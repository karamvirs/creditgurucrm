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
class echoUserHooks
{
	public function __construct(){
	}
	
	// If they change their email address, reset the echosign user key
	public function before_save(&$bean, $event, $args){
		
		if($bean->fetched_row['email1'] != $bean->email1){
			$bean->echosign_user_key_c = '';
		}
	}
}