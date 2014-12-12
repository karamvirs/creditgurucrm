<?PHP

/*******************************************************************************
 * This file is integral part of the project "ModuleSurfer" for SugarCRM.
 * 
 * "ModuleSurfer" is a project created by: 
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2013 DISPAGE.
 * 
 * The contents of this file are released under the GNU General Public License
 * version 3 as published by the Free Software Foundation that can be found on
 * the "LICENSE.txt" file which is integral part of the SUGARCRM(TM) project. If
 * the file is not present, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You may not use the present file except in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Dispage" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Dispage".
 * 
 ******************************************************************************/

$app_strings['LBL_MODULESURFER'] = array(
	'LBL_ERRORS' => array(
		'LBL_ERROR_UNKNOWN' => '#0500: Unknown retrieve error.',
		'LBL_ERROR_MODULE_NOT_FOUND' => '#0501: Module definitions not found.',
		'LBL_ERROR_MODULE_ACCESS_DENIED' => '#0502: Access to the Module denied.<br/><br/><b>NOTE:</b> To protect custom modules from unauthorized accesses, ModuleSurfer requires that you re-login in SugarCRM the first time you create a module to get the correct access permissions.',
		'LBL_ERROR_MODULE_INVALID_LOGIN' => '#0503: Authentication failure.',
	),
	'LBL_JS' => array(
		'UPDATE_CELL_CONFIRM' => 'Confirm cell update?',
		'RECORDS' => 'records',
		'LIST_VIEW' => 'List View',
		'ALL_GROUPS' => 'All Groups',
		'ALL_GROUPS_TITLE' => 'Collapse / Expand All Gropus',
		'NEW' => 'New',
		'NEW_TITLE' => 'Add new Record',
		'REFRESH' => 'Refresh',
		'REFRESH_TITLE' => 'Reload data',
		'VIEW' => 'View',
		'VIEW_TITLE' => 'View selected Records',
		'VIEW_WARNING_0' => 'Select one or more records to view.',
		'VIEW_EDIT_WARNING_MAX' => 'Select a number of records less or equal to 10.',
		'EDIT' => 'Edit',
		'EDIT_TITLE' => 'Edit selected Records',
		'EDIT_WARNING_0' => 'Select one or more records to edit.',
		'DELETE' => 'Delete',
		'DELETE_TITLE' => 'Delete selected Records',
		'DELETE_WARNING_0' => 'Select at least one record to delete.',
		'DELETE_CONFIRM' => 'Confirm record(s) deletion?',
		'CLEAR_FILTER' => 'Clear Filter',
		'CLEAR_FILTER_TITLE' => 'Clear Search Filter Toolbar',
		'DELETE_INLINE_CONFIRM' => 'Confirm deletion of record',
		'DELETE_INLINE_ERROR' => 'Error Deleting Records',
		'RETRIEVE_ERROR' => 'Error retrieving rows',
		'GROUP_UNGROUP_TITLE' => 'Group/Ungroup by this column',
		'SAVE_LAYOUT_ERROR' => 'Error saving Layout',
		'SAVE_LAYOUT_OK' => 'Layout correctly saved',
		'RESTORE_LAYOUT_ERROR' => 'Error Restoring Layout to default',
		'RESTORE_LAYOUT_OK' => 'Layout restored to default',
		'FIRST_NAME' => 'First',
		'LAST_NAME' => 'Last',
		'CURRENCY_FORMAT_ERROR' => 'Please enter a valid currency value.',
		'EDIT_ROW_ERROR' => 'Record may have not been correctly saved.',
		'SELECT_RECORDS_HEADER' => 'Select Records',
		'FORCE_CLEAR_FILTER' => 'Please clear the Filter Bar or do not use the "Select All" selection before to proceed with the selected action.',
		'TOGGLE_ON' => 'On',
		'TOGGLE_OFF' => 'Off',
		'TIP_HEADER' => '<div><a href=\'http://www.dispage.com/wiki/ModuleSurfer_Grid\' target=\'_blank\'>ModuleSurfer Grid</a></div>SugarCRM&trade; ListView is converted into a grid that allows to perform any action without reloading the HTML page.<br/>To disable tooltips, check the &quot;<i>Hide Tooltip icons</i>&quot; option from the <a href=\'http://www.dispage.com/wiki/ModuleSurfer_Configuration\' target=\'_blank\'>ModuleSurfer Options</a> panel',
	),
	'LBL_TPL' => array(
		'TOGGLE_LAYOUT_PANEL_TITLE' => 'Show/Hide Layout Panel',
		'LAYOUT_PANEL_HEADER' => 'Layout Customization',
		'SELECT_GRID_TITLE' => 'Select Columns to display',
		'SELECT_GRID' => 'Select Columns',
		'TOGGLE_FILTER' => 'Toggle Filter',
		'TOGGLE_FILTER_TITLE' => 'Toggle Search Filter Toolbar',
		'TOGGLE_AUTOLOAD_TITLE' => 'Toggle Auto Load on scrolling',
		'TOGGLE_AUTOLOAD' => 'Auto Load',
		'TOGGLE_AUTOWIDTH_TITLE' => 'Toggle automatic Fit to Screen',
		'TOGGLE_AUTOWIDTH' => 'Grid Auto-Width',
		'TOGGLE_AUTOSHRINK_TITLE' => 'Toggle automatic Column Shrink',
		'TOGGLE_AUTOSHRINK' => 'Column Auto-Width',
		'SAVE_LAYOUT_TITLE' => 'Save Current Layout',
		'SAVE_LAYOUT' => 'Save Layout',
		'RESTORE_LAYOUT_TITLE' => 'Restore Layout to Default',
		'RESTORE_LAYOUT' => 'Restore Default Layout',
		'TOGGLE_ON' => 'On',
		'EDIT_TITLE' => 'Edit Record',
		'VIEW_TITLE' => 'View Record',
		'DELETE_TITLE' => 'Delete Record',
		'LBL_DISABLE_MODULESURFER' => 'Disable ModuleSurfer for this module',
		'LBL_ACTIONS' => 'Actions',
		'LBL_DRC_OUT_OF_DATE_ERROR' => 'ModuleSurfer cannot be activated due to the expiration of the cached decryption key.\nPlease connect to DRC to reload the key.',
		'TIP_LAYOUT' => '<div><a href=\'http://www.dispage.com/wiki/ModuleSurfer_Layout_Settings\' target=\'_blank\'>ModuleSurfer Layout Settings</a></div>Each User can customize Layout of each module from this panel.<br/>Settings can be saved with the &quot;<i>Save Layout</i>&quot; button and are automatically loaded each time the User accesses the module.',
	),
	'LBL_OPTIONS' => array(
		'EDIT_BEHAVIOURS' => array(
			'Allow inline and form editing', 
			'Ask before inline saving', 
			'Allow form editing only', 
			'Deny inline and form editing',
		),
		'EDIT_BEHAVIOURS_MIN' => array(
			'default' => 'Default', 
			'0' => 'Allow', 
			'1' => 'Ask', 
			'2' => 'Form', 
			'3' => 'Deny'
		),
		'LBL_GLOBAL' => 'Global',
		'LBL_MODULE_SPECIFIC' => 'Module Specific',
		'LBL_GLOBAL_OPTIONS' => 'Global Options',
		'LBL_MODULE_SPECIFIC_OPTIONS' => 'Module Specific Options',
		'SCROLL_ROWS' => 'Rows retrieved on scrolling',
		'SCROLL_PAGE_ROWS' => 'Rows per page',
		'DISABLE_TIPS' => 'Hide Tooltip icons',
		'DISABLE_CHECKING' => 'Prevent Users from Enabling/Disabling ModuleSurfer',
		'DISABLE_INLINE_DELETE' => 'Disable Delete from &quot;Actions&quot; Column',
		'ASK_SAVING_FORM' => 'Ask before saving form',
		'CORRECT_CURRENCY_BUG' => 'Correct comma decimal separator bug',
		'DISABLE_CURRENCY_REPLACEMENT' => 'Disable currency comma replacement',
		'DEFAULT_EDIT_BEHAVIOUR' => 'Default behaviour on Editing',
		'LBL_MODULE' => 'Module',
		'SET_READONLY_COLUMNS' => 'Set Read-Only property',
		'SET_COLUMN_PROPERTIES' => 'Set Field properties',
		'COLUMN_HEAD_NAME' => 'Field name',
		'COLUMN_HEAD_EDITING' => 'Editing',
		'COLUMN_HEAD_HIDE' => 'Hide',
		'LBL_RESTORE' => 'Restore Original',
		'TIP_GLOBAL' => '<div><a href=\'http://www.dispage.com/wiki/ModuleSurfer_Configuration#Global_Options\' target=\'_blank\'>Global Options</a></div>Options globally used in all modules.',
		'TIP_MODULE' => '<div><a href=\'http://www.dispage.com/wiki/ModuleSurfer_Configuration#Module_Specific_Options\' target=\'_blank\'>Module Specific Options</a></div>Options in this tab are applied in specific modules only.',
	),
);
?> // End of _dom files
