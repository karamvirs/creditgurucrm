<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_login'] = Array(); 
$hook_array['after_login'][] = Array(5, '', 'custom/include/EnhancedManager/EnhancedManager.php','EnhancedManager', 'loginCheck'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1, 'Display Send For Signature Button', 'custom/EchoSign/echosign_buttons.php','EchoSignButtons', 'display'); 
$hook_array['after_ui_frame'][] = Array(67, 'Add Tab to User Editor', 'custom/modules/Users/homepage_manager.php','defaultHomepage', 'addTab'); 
$hook_array['after_retrieve'] = Array(); 
$hook_array['after_retrieve'][] = Array(68, 'Lock Individual Homepages', 'custom/modules/Users/homepage_manager.php','defaultHomepage', 'resetConfig'); 



?>