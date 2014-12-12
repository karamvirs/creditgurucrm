<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*************************************************************************
*
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2012 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/


require_once('include/MVC/View/views/view.detail.php');

class echo_AgreementsViewDetail extends ViewDetail
{

	public function echo_AgreementsViewDetail(){
		parent::ViewDetail();
	}
	
	
	public function display()
	{
		global $sugar_config, $app_list_strings;
		
		$show_signed_agreement_inline = false;
		$echo_sign_settings = null;
		
		if(isset($sugar_config['echosign'])){
	 		$echo_sign_settings = $sugar_config['echosign'];
	 		if(!empty($echo_sign_settings['show_agreements_inline']) && $echo_sign_settings['show_agreements_inline'] == 1){ 
	 			$show_signed_agreement_inline = true;
	 			$this->options['show_subpanels'] = false;
	 		}
	 	}
	 	
	 	$checked_host_sigining = $this->bean->host_signing_for_first_signer ? 'checked="checked"' : '';
		$host_signing_link = '<input type="checkbox" '.$checked_host_sigining.' disabled="true" value="'.$this->bean->host_signing_for_first_signer.'" id="host_signing_for_first_signer" name="host_signing_for_first_signer" class="checkbox">';
		if(!empty($this->bean->document_key) && $this->bean->status_id == 'OUT_FOR_SIGNATURE' && $this->bean->host_signing_for_first_signer){	
			
			require_once('custom/EchoSign/Browser.php');
			$browser = new Browser();
			$isMobile = $browser->isMobile();
			
			if($isMobile)
				$host_signing_link .= ' <a href="'.$this->bean->getSigningUrl($this->bean->document_key).'" name="Host Signing for the Current Signer" target="_blank">Host Signing for the Current Signer</a>';
			else
				$host_signing_link .= ' <a href="#" onclick="open_interactive(\''.$this->bean->id.'\');return false;" name="Host Signing for the Current Signer" >Host Signing for the Current Signer</a>';
		}
			
	 	
		$this->ss->assign("CANCEL_BUTTON", $this->get_cancel_button());
		$this->ss->assign("REMINDER_BUTTON", $this->get_reminder_button());
		$this->ss->assign("SEND_DOCUMENT", $this->get_send_document_button());
		$this->ss->assign("CHECK_STATUS", $this->get_check_status_button());
		$this->ss->assign("SIGNATURE_TYPE", $app_list_strings['echosign_signature_type_list'][$this->bean->signature_type]);
		$this->ss->assign("STATUS", '<span id="status_id">'.$app_list_strings['echosign_status_id_list'][$this->bean->status_id].'</span>');
		$this->ss->assign('HOST_SIGNING_LINK', $host_signing_link);
				
		
		parent::display();
		
		
		if($show_signed_agreement_inline)
			$this->show_signed_agreement_inline();
	}
	
	
	private function show_signed_agreement_inline()
	{
		$GLOBALS['focus'] = $this->bean;
       
       	$layout_defs [ $this->bean->module_dir ] = array ( ) ;
		
		
		if(function_exists('get_custom_file_if_exists')){
			if(get_custom_file_if_exists('modules/echo_Agreements/Ext/Layoutdefs/layoutdefs.ext.php') != 'modules/echo_Agreements/Ext/Layoutdefs/layoutdefs.ext.php'){
				require ('custom/modules/echo_Agreements/Ext/Layoutdefs/layoutdefs.ext.php') ;
			}
		}
		else{
			if (file_exists ( 'custom/modules/echo_Agreements/Ext/Layoutdefs/layoutdefs.ext.php' ))
				require ('custom/modules/echo_Agreements/Ext/Layoutdefs/layoutdefs.ext.php') ;
		}
		
		
		
		$layout_defs = $layout_defs['echo_Agreements'] ;
		require_once ('include/SubPanel/SubPanelTiles.php');
		$subpanel = new SubPanelTiles($this->bean, $this->module, $layout_defs);
       	echo $subpanel->display();
       	
       	if(in_array(strtolower($this->bean->status_id), array('signed', 'approved')))
		{
			$images = $this->bean->get_latest_images();
			if(count($images) > 0)
			{
				echo '<div id="subpanel_title_echo_agreements_signed_agreements">
				  <table cellspacing="0" cellpadding="0" border="0" width="100%" class="formHeader h3Row">
					 <tbody>
						 <tr>
							 <td nowrap=""><h3><span>&nbsp;'.translate("LBL_SIGNED_AGREEMENT", 'echo_Agreements').'</span></h3></td>
						 </tr>
					 </tbody>
				 </table>
				 </div>
				 
				 <table class="list view" width="100%">';

			
				foreach($images as $index => $arr){
					echo '<tr height="20" class="oddListRowS1"><td><a href="'.$arr[1].'" target="_blank"><img src="'.$arr[0].'" /></a></td></tr>';
				}
			}
			
		}
		echo '</table>';
	}	



	


	private function get_send_document_button(){
		$btn = '';
		if( (!$this->bean->document_key && $this->bean->status_id == 'DRAFT') ||
			($this->bean->document_key && $this->bean->status_id == 'OTHER'))
		{
			$btn .= '<input title="Create EchoSign Agreement" class="button" type="submit" id="sendDocumentBtn" name="sendDocumentBtn" value="Send For Signature" onclick="send_document(\''.$this->bean->id.'\');return false; "/>';
		}
		
		return $btn;
	}
	
	
	private function get_cancel_button(){
		$btn = '<input type="submit" value="Cancel Agreement" name="Cancel" onclick="var _form = document.getElementById(\'formDetailView\'); if(!_form) _form = this.form;_form.return_module.value=\'echo_Agreements\';_form.return_action.value=\'DetailView\';_form.action.value=\'Cancel\';_form.return_id.value=\''.$this->bean->id.'\';if(confirm(\'Are you sure you want to cancel this agreement?\')){ ajaxStatus.flashStatus(\'Canceling Agreement\', 1000); SUGAR.ajaxUI.submitForm(_form);}" accesskey="C" title="Cancel">';
		return (!empty($this->bean->document_key) && in_array($this->bean->status_id, array('OUT_FOR_SIGNATURE','OUT_FOR_APPROVAL', 'EXPIRED')))  ? $btn : '';
	}
	
	
	private function get_check_status_button(){
		$btn = '<input title="Update Document Status" class="button" type="submit" id="checkDocumentStatus" name="checkDocumentStatus" value="Update Status" onclick="ajaxStatus.flashStatus(\'Updating Status\', 2000);var _form = document.getElementById(\'formDetailView\'); if(!_form) _form = this.form;_form.return_module.value=\'echo_Agreements\';_form.return_action.value=\'DetailView\';_form.action.value=\'CheckStatus\';_form.return_id.value=\''.$this->bean->id.'\';SUGAR.ajaxUI.submitForm(_form);"/>';
		return ($this->bean->document_key && !in_array($this->bean->status_id, array('SIGNED', 'APPROVED', 'ABORTED', 'DRAFT'))) ? $btn : '';
	}
 	
 	
 	private function get_reminder_button(){
		$btn = '<input title="Send Reminder" class="button" type="submit" id="SendReminderBtn" name="SendReminder" value="Send Reminder" onclick="ajaxStatus.flashStatus(\'Sending Reminder\', 2000);var _form = document.getElementById(\'formDetailView\'); if(!_form) _form = this.form;_form.return_module.value=\'echo_Agreements\';_form.return_action.value=\'DetailView\';_form.action.value=\'SendReminder\';_form.return_id.value=\''.$this->bean->id.'\';SUGAR.ajaxUI.submitForm(_form);"/>';
		return (!empty($this->bean->document_key) && in_array($this->bean->status_id, array('OUT_FOR_SIGNATURE', 'OUT_FOR_APPROVAL'))) ? $btn : '';
	}
 	
 }