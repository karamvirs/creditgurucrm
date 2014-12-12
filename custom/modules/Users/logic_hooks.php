<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_login'] = Array(); 
$hook_array['after_login'][] = Array(1, 'SugarFeed old feed entry remover', 'modules/SugarFeed/SugarFeedFlush.php','SugarFeedFlush', 'flushStaleEntries'); 
$hook_array['after_login'][] = Array(67, 'Check users Homepage', 'custom/modules/Users/homepage_manager.php','defaultHomepage', 'afterLogin'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'EchoSign - Check if email changed', 'custom/modules/Users/echoUserHooks.php','echoUserHooks', 'before_save'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1, 'For Custom fields of affiliate users', 'custom/modules/Users/affiliate.php','affiliate_modifier', 'hide_affiliate_only_fields'); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/Users/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesUsersHook_class', 'after_ui_frame_method'); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'create unique id for all users', 'custom/modules/Users/affiliate.php','affiliate_modifier', 'create_unique_id'); 



?>