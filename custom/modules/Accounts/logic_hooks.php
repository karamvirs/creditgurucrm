<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1, 'Accounts InsideView frame', 'modules/Connectors/connectors/sources/ext/rest/insideview/InsideViewLogicHook.php','InsideViewLogicHook', 'showFrame'); 
$hook_array['after_ui_frame'][] = Array(33, 'Builds Stripe Payment Button', 'custom/modules/Accounts/sc_accounts_logic.php','SugarLogic', 'add_action_button'); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/Accounts/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesAccountsHook_class', 'after_ui_frame_method'); 



?>