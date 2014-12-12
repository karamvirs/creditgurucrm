<?PHP

/*******************************************************************************
 * This file is integral part of the project "Installer for Dispage Extension
 * Manager" for SugarCRM.
 * 
 * "Installer for Dispage Extension Manager" is a project created by: 
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2012 DISPAGE.
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

$app_strings['LBL_DISPAGE_MANAGER'] = array_merge((array)@$app_strings['LBL_DISPAGE_MANAGER'], array(
	'LBL_INSTALLED_WITH_ERROR_OBJECT' => '#0414: Error installing Extension',
	'LBL_INSTALLED_SUCCESSFULLY_OBJECT' => 'Extension installed',
	'LBL_DOWNLOADED_SUCCESSFULLY_OBJECT' => 'Extension downloaded',
	'LBL_VALIDATED_WITH_ERROR_OBJECT' => '#0415: Error validating installation',
	'LBL_VALIDATED_SUCCESSFULLY_OBJECT' => 'Installation validated successfully',
	'LBL_VALIDATED_ERROR_MANIFEST' => '#04151: Manifest not found or unreadable',
	'LBL_VALIDATED_ERROR_FILE_NOT_FOUND' => '#04152: File not found: ',
	'LBL_VALIDATED_ERROR_FILE_NOT_ACCESSIBLE' => '#04152: File not accessible: ',
	'LBL_INSTALLED_PACKAGE' => 'Extension "%s" has been installed successfully.',
	'LBL_DOWNLOADED_PACKAGE' => 'Extension "%s" has been downloaded.',
	'LBL_UPGRADE_WARNING' => "<span class='error'><b>WARNING! One or more dispage extensions have not been uninstalled: this may lead to malfunctions after the SugarCRM upgrade.</b></span>
<br><br>
Once verified that the installed dispage extensions are compatible with the SugarCRM version to which it is upgrading, the procedure below must be followed:
<ol>
	<li>Uninstall all the dispage extensions from the <a style='font-size:11px;' href='index.php?module=DispageExtMan&action=index'>Dispage Admin Panel</a>.</li>
	<li>Uninstall the Dispage Extension Manager Installer from the SugarCRM Module Loader.</li>
	<li>Upgrade SugarCRM.</li>
	<li>Re-install the Dispage Extension Manager Installer.</li>
	<li>Re-install the dispage extensions.</li>
</ol>",

));

$app_strings['LBL_DISPAGE_MANAGER_WELCOME'] = array_merge((array)@$app_strings['LBL_DISPAGE_MANAGER_WELCOME'], array(
	'WarnMsgNotConnected' => "Extension Manager Disconnected. ",
	'WarnMsgReconnect' => "<a href=\"javascript:document.location.href = EMAddURIParameter('disable_em', '0'),\">Click here</a> to reconnect.",

	'warnTextEmpty' => "Please enter a value",
	'connectingHeader' => "Dispage Extension Manager - Powered by <a href='http://www.dispage.com' target='_blank'>Dispage</a>",
	'connectingMsg' => "Connecting to Dispage",
	'synhronizingMsg' => "Synchronizing Extensions",
	'downloadingMsg' => "Downloading ",
	'enterSerialTooltip' => "The <b>activation serial code</b> is a unique 16-character code which a dispage registered user can obtain to activate <b>DEMO</b> and <b>FULL (PAID)</b> extensions.<br/><a class='em-external-link' id='em-purchase-link-tooltip' href='javascript:instConsole.submitBuyFull();'>Click here</a> to purchase the <b>FULL</b> version of the extension.<br/>Serial keys can be managed from <a class='em-external-link' href='javascript:instConsole.submitManageLic();'>this page</a>.",
	'enterSerialMsg' => "Enter the activation serial code",
	'retrievingSerialMsg' => "Retrieving demo activation serial code",
	'newSerialMsg' => "Serial code retrieved:",
	'currentSerialMsg' => "Serial code registered:",
	'forToken' => " for",
	'checkingSerialMsg' => "Checking the activation serial code",
	'checkedSerialMsg' => "The activation serial code is valid for the extension.",
	'selectExtVersion1' => "Extension version <b>",
	'selectExtVersion2' => "</b> is no longer available.<br/>Select a new version to install:",
	'selectExtVersionTooltip1' => "If an extension version is no longer supported in its new releases, a new version must be selected from the ones available.<br/><a href='",
	'selectExtVersionTooltip2' => "' target='_blank'>Click here</a> to check the different features of all the available versions.",
	'selectEnvironment' => "Select the environment for this SugarCRM installation",
	'currentEnvironment' => "Current environment",
	'environmentTooltip' => "It is essential to assign an <a href='http://www.dispage.com/wiki/Environment_selection' target='_blank'>environment</a> to each SugarCRM installation running a <b>FULL</b> or a <b>DEMO</b> extension.",
	'environmentProduction' => "Production",
	'environmentDevelopment' => "Development",
	'upgradeButtonDEMO' => "Try DEMO Version",
	'upgradeButtonPAID' => "Buy FULL Version",
	'serialButton' => "Change Serial Code",
	'installingMsg' => "Installing Extension ",
	'validatingMsg' => "Validating Installation",
	'updateCompleteMsg' => "Update Complete",
	'sendInstallRequestMsg' => "Sending Installation Request",
	'uninstallingMsg' => "Uninstalling ",
	'installQuestion' => "The following extension will be installed / upgraded:",
	'confirmInstallation' => "Do you want to proceed?",

	'noPackageFound' => "All the Extensions are updated",
	'noAdminConnectionComplete' => "Extensions activated",

	'doneMsg' => "Done",
	'ErrorMsg' => "Error",

	'ErrorMsgTable' => array(
		'Invalid_password' => "#0405: Invalid Password.",
		'User_does_not_exist' => "#0406: Unknown User ID.",
		'Session_error' => "#0407: Remote session has expired.<br/><a href=\"javascript:document.location.href = EMAddURIParameter('disable_em', '0');\">Click here</a> to reconnect.",
		'Not_connected' => "#0408: Extension Manager disconnected.",
		'Invalid_action' => "#0409: Connection Refused.",
		'Unable_authenticate' => "#0410: Unable to authenticate to Dispage.<br/>Extension Manager disconnected. ",
		'Connection_unsaved' => "#0411: Unable to authenticate to Dispage.<br/>Extension Manager disconnected. ",
		'Extension_not_found' => "#0412: Extension not available for this Sugar version/edition",
		'Post_return_error' => "#0413: Error in server response",
		'License_link_error' => "#0422: Error retreiving the License Link",
		'Error_retrieving_serial' => "#0440: Error retreiving a valid serial. ",
	),

	'WarningLoginOptionEmpty' => "Please fill both the username and password fields.",
	'WarningCheckLicenseAgreement' => "The extension cannot be installed without giving the explicit consent to the License Agreement.",
	'WarningValidationFile1' => "Warning: browser cannot open following resources",
	'WarningValidationFile2' => "The extension may not work until all the resources are correctly accessed to.",

	'welcomeMsg' => "
<table>
	<tr>
		<td width=\"20%\"'>Username:</td>
		<td class=\"em-input-row\" width=\"80%\">
			<input class=\"em-login-field\" type=\"text\" name=\"emuser\" size=\"15\" />
		<td/>
	</tr>
	<tr>
		<td>Password:</td>
		<td>
			<input class=\"em-login-field\" type=\"password\" name=\"empwd\" size=\"15\" />
		<td/>
	</tr>
	<tr>
		<td colspan=\"2\" style=\"padding-top:10px\">
			<input type=\"checkbox\" name=\"emautologin\" value=\"1\"/>&nbsp;Log in automatically next time.
		</td>
	</tr>
	<tr>
		<td colspan=\"2\">
			<div class='em-panel2-container'>
				<div class='em-helper-container'>
					<div class='em-question-point em-login-point'></div>
					<div class='em-register-point'>
						Sign on at the <a target=\"_blank\" href=\"http://www.dispage.com/index.php?option=com_comprofiler&task=registers\">Dispage Extension Service</a>.
						<div class='em-helpers' maxheight='54px'>
							New to the Extension Manager Services ?<br/>
							<b>The first step is to free register at the <a target=\"_blank\" href=\"http://www.dispage.com/index.php?option=com_comprofiler&task=registers\">Dispage Extension Service</a>.
							Then you have to log in and will be guided through the following steps.</b>
						</div>
					</div>
				</div>
				<div class='em-helper-container'>
					<div class='em-question-point em-login-point'></div>
					<div class='em-register-point'>
						Ask for a password reset at <a target=\"_blank\" href=\"http://www.dispage.com/index.php?option=com_comprofiler&task=lostPassword\">this link</a>.
						<div class='em-helpers' maxheight='25px'>
							Have an account, but you don't remember the password?<br/>
							<b>You can ask for a password reset at <a target=\"_blank\" href=\"http://www.dispage.com/index.php?option=com_user&view=reset\">this link</a></b>
						</div>
					</div>
				</div>
				<div class='em-helper-container'>
					<div class='em-question-point em-login-point'></div>
					<div class='em-register-point'>
						<a target=\"_blank\" href=\"http://www.sugarforge.org/frs/download.php/6306/privacy.txt\">Privacy Policy</a>.
						<div class='em-helpers' maxheight='25px'>
							To find out which data will be transmitted to Dispage from your SugarCRM installation, follow <a target=\"_blank\" href=\"http://www.sugarforge.org/frs/download.php/6306/privacy.txt\">this link</a>
						</div>
					</div>
				</div>
			</div>
		</td>
	</tr>
</table>",
));


?> // End of _dom files
