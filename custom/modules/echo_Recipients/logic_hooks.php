<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_relationship_delete'] = Array(); 
$hook_array['after_relationship_delete'][] = Array(1, 'Delete Recipient Record', 'modules/echo_Recipients/recipientsLogicHooks.php','recipientsLogicHooks', 'deleteRecipientRecord'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/echo_Recipients/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesecho_RecipientsHook_class', 'after_ui_frame_method'); 



?>