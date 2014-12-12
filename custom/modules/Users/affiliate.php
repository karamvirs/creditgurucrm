<?php
   if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
   class affiliate_modifier {
      function hide_affiliate_only_fields($event, $arguments) {
      	global $current_user;
      	$roles = ACLRole::getUserRoleNames($_REQUEST['record']);
      	$logged_in_roles = ACLRole::getUserRoleNames($current_user->id);
      	$is_affiliate = in_array("affiliate role", $roles);
      	$is_admin_logged_in = in_array("admin",$logged_in_roles );

      	$hide = false;
      	// echo "<pre>";var_dump($is_affiliate);var_dump($is_admin_logged_in);die;

      	if($is_admin_logged_in ===true && $is_affiliate  === false){
      		$hide = true;
      	}
      	if($is_admin_logged_in === false)
      		$hide = true;

      	if($hide){

      	$v = $_REQUEST['action'];
      	switch ($v) {
      		case 'DetailView':
      			echo '
      			<script>
      			$(function() {
      				 $(".panelContainer:eq(0) tr:last").remove();
      			});
      			
      			</script>';
      			break;
      		
      		case 'EditView':
      		
      			echo '
      			<script>
      			$(function() {
      				 $("#affiliate_program_c_label").next("td").remove();
      				 $("#affiliate_program_c_label").remove();

      				 $("#referred_by_c_label").next("td").remove();
      				 $("#referred_by_c_label").remove();
      			});
      			
      			</script>';
      			break;
      	}
      }
      	
      }

      function create_unique_id($bean, $event, $arguments){

            global $db;
            $query = "SELECT count(*) as counter FROM affiliate_id WHERE user_id='$bean->id'"; 
            $res = $db->query($query);
            $result = $db->fetchByAssoc($res);
    
            $count = $result['counter'];
   
            if($count==0){
                   
                  $sql = "INSERT INTO `affiliate_id`(`user_id`) VALUES ('$bean->id')";
                  $db->query($sql);
            }
  
            if(!empty($bean->is_affilate_c)){
                  $id_guid = create_guid();
                  $affiliate_id = '24505155-5513-3db9-68b4-53f2e885c9f1';
                  $user_id = $bean->id;
                  $sql = "INSERT INTO acl_roles_users VALUES ('$id_guid','$affiliate_id','$user_id',NOW(),0)";
                  $db->query($sql);

            }
         }

   }
?>      