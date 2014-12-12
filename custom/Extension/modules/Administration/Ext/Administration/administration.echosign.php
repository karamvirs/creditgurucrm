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
$admin_option_defs=array();
$image_path = ''; // image store in custom/themes/default/images/echosign-16x16.png
$admin_option_defs['Administration']['EchoSignSettings'] = array($image_path.'echosign-16x16', 'LBL_ECHOSIGN_TITLE', 'LBL_ECHOSIGN_DESC', 'index.php?module=Administration&action=EchoSignAdmin');
$admin_group_header[]= array('LBL_ECHOSIGN_PANEL_NAME', '', false, $admin_option_defs, 'LBL_ECHOSIGN_PANEL_DESC');
