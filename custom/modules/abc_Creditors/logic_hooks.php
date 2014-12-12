<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Creditors Status', 'custom/modules/abc_Creditors/logic_hooks_class.php','CreditorsLogic', 'creditors'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/abc_Creditors/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesabc_CreditorsHook_class', 'after_ui_frame_method'); 



?>