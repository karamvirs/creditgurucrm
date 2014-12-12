<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Professional Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-professional-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
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
require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/echo_Recipients/echo_Recipients.php');

class echo_RecipientsDashlet extends DashletGeneric { 
    function echo_RecipientsDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/echo_Recipients/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'echo_Recipients');

        $this->searchFields = $dashletData['echo_RecipientsDashlet']['searchFields'];
        $this->columns = $dashletData['echo_RecipientsDashlet']['columns'];

        $this->seedBean = new echo_Recipients();        
    }

    function process($lvsParams = array()) {
        global $timedate, $current_user;

$sql = "SELECT  l.id
FROM
echo_recipients as er
join leads as l
on er.parent_id = l.id
and er.assigned_user_id = '$current_user->id'
and er.parent_type = 'Leads'
and l.status = 'converted'";
$result = $GLOBALS['db']->query($sql);
  if($result->num_rows != 0){
    $arID = array();
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
      $arID[] = $row['id'];
    }
    
    $a=implode("','", $arID);
    //echo "aa".$a;
    $lvsParams['custom_where'] = ' AND parent_type NOT IN (\'Contacts\') AND parent_id NOT IN (\''.$a.'\')  ';
  } 
// MYSQL database
        parent::process($lvsParams);
    } 
}
