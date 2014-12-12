<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Contacts push feed', 'modules/Contacts/SugarFeeds/ContactFeed.php','ContactFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(2, 'Portal password', 'custom/modules/Contacts/logic_hooks_class.php','ContactsLogic', 'welcome'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1, 'Contacts InsideView frame', 'modules/Connectors/connectors/sources/ext/rest/insideview/InsideViewLogicHook.php','InsideViewLogicHook', 'showFrame'); 
$hook_array['after_ui_frame'][] = Array(33, 'Builds Stripe Payment Button', 'custom/modules/Contacts/sc_contacts_logic.php','SugarLogic', 'add_action_button'); 
$hook_array['after_ui_frame'][] = Array(1002, 'Document Templates after_ui_frame Hook', 'custom/modules/Contacts/DHA_DocumentTemplatesHooks.php','DHA_DocumentTemplatesContactsHook_class', 'after_ui_frame_method'); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Associate client to affiilate', 'custom/modules/Contacts/sc_contacts_logic.php','SugarLogic', 'assignToAffiliate'); 
$hook_array['after_ui_frame'][] = Array(12543, 'Builds Custom Templates Button', 'custom/modules/Contacts/sc_contacts_logic.php','SugarLogic', 'add_template_button'); 



?>