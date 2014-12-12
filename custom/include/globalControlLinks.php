<?php
//global $current_user;
//include_once('modules/ACLRoles/ACLRole.php');
$isAffiliateRole = in_array("affiliate role", ACLRole::getUserRoleNames($current_user->id));
$isStaffRole = in_array("staff", ACLRole::getUserRoleNames($current_user->id));
$isAdminRole = in_array("admin", ACLRole::getUserRoleNames($current_user->id));

if($isAffiliateRole || $isStaffRole){
    unset($global_control_links['about']);
    unset($global_control_links['employees']);
    unset($global_control_links['training']);
}

if($isAdminRole){
	$global_control_links['affiliate'] = array('linkinfo'=>array('Users'=>'http://192.232.214.244/sugarcrm/index.php?module=Users&action=index'));

}
?>