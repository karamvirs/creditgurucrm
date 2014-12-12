<?PHP

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

require_once('modules/echo_Agreements/echo_Agreements_sugar.php');
require_once('custom/EchoSign/echosign.php');

class echo_Agreements extends echo_Agreements_sugar {
	
	public $echoSign;
	public $signing_url; // used for host signs now link
	
	
	function echo_Agreements(){	
		parent::echo_Agreements_sugar();
	}
	
	
	/* 
		If in the admin section they have locked down 
		agreements after they have been sent,
		remove the edit, duplicate and delete buttons
	*/
	function ACLAccess($view,$is_owner='not_set'){
		
		$access = parent::ACLAccess($view, $is_owner);
		
		global $sugar_config;
		if(isset($sugar_config['echosign']) && 
			isset($sugar_config['echosign']['lock_down_agreements']) && 
			$sugar_config['echosign']['lock_down_agreements'])
		{
			if(!in_array($this->status_id, array('DRAFT', '', 'OTHER'))){
				if($view == 'edit' || $view == 'delete'){
					return false;
				}
			}
		}
				
		return $access;
	}
	
	
	
	public function save($notify = false)
	{
		global $app_list_strings;
		$this->status = isset($app_list_strings['echosign_status_id_list'][$this->status_id]) ? $app_list_strings['echosign_status_id_list'][$this->status_id] : $app_list_strings['echosign_status_id_list']['OTHER'];
	
		if(empty($this->i_need_to_sign)){
			$this->signature_flow = '';
		}
		
		parent::save($notify);
	}	
	
	
	
	
	// smallImageUrl, mediumImageUrl, largeImageUrl
	public function get_latest_images()
	{
		$images = array();

		if(empty($this->echoSign)) $this->echoSign = new EchoSign();
		
		$result = $this->echoSign->getLatestImages($this->document_key);
		if($result && $result->documentImageList && $result->documentImageList->pageImages){
			if(is_array($result->documentImageList->pageImages->DocumentPageImages)){
				foreach($result->documentImageList->pageImages->DocumentPageImages as $index => $img_urls){
					$images[] = array($img_urls->largeImageUrl, $img_urls->largeImageUrl);	
				}
			} 
			else if(is_object($result->documentImageList->pageImages->DocumentPageImages)){
				$images[] = array($result->documentImageList->pageImages->DocumentPageImages->largeImageUrl, $result->documentImageList->pageImages->DocumentPageImages->largeImageUrl);
			}
		}
		
		return $images;
	}
	
	
	
	
	
	/**
	 *	Cancel the document in EchoSign and update it's satus
	 *
	 *  You can only cancel agreements that are out for signature or are expired.
	 *
	 **/
	public function cancel()
	{
		if(!empty($this->document_key) && in_array($this->status_id, array('OUT_FOR_SIGNATURE', 'OUT_FOR_APPROVAL', 'EXPIRED')))
		{
			if(empty($this->echoSign)) 
				$this->echoSign = new EchoSign();
	
			$this->echoSign->cancelDocument($this->document_key, $comment = '', $notify_signer = true);
		
			$this->status_id = 'ABORTED';
			$this->save();
		}
	}
	
	
	
	
	
	/**
	 *	Mark Deleted
	 *
	 *
	 *
	 **/
	public function mark_deleted($id)
	{
		/* Delete all of the recipients */
		include_once('modules/echo_Recipients/echo_Recipients.php');
		$signers = $this->get_linked_beans('echo_agreements_echo_recipients', 'echo_Recipients');
		foreach($signers as $s)
		{
			$signer = new echo_Recipients();
			$signer->retrieve($s->id);
			if($signer->id){
				$signer->deleted = 1;
				$signer->save(false);
			}
		}
	
		parent::mark_deleted($id);
		
		/* Cancel the document in EchoSign if it was out for signature or expired */
		if(!empty($this->document_key) && in_array($this->status_id, array('OUT_FOR_SIGNATURE', 'OUT_FOR_APPROVAL', 'EXPIRED')))
		{
			if(empty($this->echoSign)) $this->echoSign = new EchoSign();
	
			// make notify signer a config setting...
			$this->echoSign->cancelDocument($this->document_key, $comment = '', $notify_signer = true);
		}
	}
	
	
	
	
	
	/**
	 *	Send Document
	 *
	 **/
	public function sendDocument()
	{
		require_once('modules/Configurator/Configurator.php');
		$configurator = new Configurator();
		
		if(!isset($configurator->config['echosign'])){
	 		$this->echosign_error_msg = translate('LBL_ERROR_SETTINGS_NOT_SET_UP');
			return false;
		}
	
	
		if(empty($this->echoSign)) 
			$this->echoSign = new EchoSign();
	
	
		$result = $this->echoSign->send_document($this);
	
		if(!$result['document_key']){ 
			$this->echosign_error_msg = $this->echoSign->get_msg();
			return false;
		}
		else{
			
			// if the first signer is an approver, set status to out for approval. 
			// else set it to out for signature
			$firstSigner = 100;
			$firstRole = '';
			foreach($this->signers as $signer){
				if($signer->role != 'CC' && $signer->signing_order < $firstSigner){
					$firstSigner = $signer->signing_order;
					$firstRole = strtolower($signer->role);
				}
			}
			
			
			$this->status_id = ($firstRole == 'approver' && count($this->signers) == 1) ? 'OUT_FOR_APPROVAL' : 'OUT_FOR_SIGNATURE';
			
			$this->document_key = $result['document_key'];
			$this->date_sent = gmdate('Y-m-d');
			$this->save(false);
			
			return $result;
		}	
	}
	
	
	
	public function getSigningUrl($document_key)
	{
		if(empty($this->echoSign)) $this->echoSign = new EchoSign();
		return $this->echoSign->getSigningUrl($document_key);
	}
	
	
	
	public function SendReminder()
	{
		if(empty($this->echoSign)) 
			$this->echoSign = new EchoSign();
			
		$this->echoSign->sendReminder($this->document_key, 'Please review and sign this document.');
	}
	
	
	
	
	/**
	 *	Check Status
	 *
	 * 	Calls getDocumentInfo and will download the signed document if it's not already downloaded....
	 *
	 **/
	public function checkStatus()
	{
		if(empty($this->echoSign)) 
			$this->echoSign = new EchoSign();
	
		$result = $this->echoSign->getDocumentInfo($this->document_key);
		
		if($result)
		{
			$max_date = 0;
			
			if(is_array($result->events->DocumentHistoryEvent)){
				foreach($result->events->DocumentHistoryEvent as $event){
					$this->create_event($event);
					if(strtotime($event->date) > $max_date) 
						$max_date = strtotime($event->date);
				}
			}
			else{
				$event = $result->events->DocumentHistoryEvent;
				$this->create_event($event);
				$max_date = strtotime($event->date);
			}
			
			
			// bug fix for api v15 returning an array of statuses occassionally.
			if(is_array($result->status) && isset($result->status[0])){
				$GLOBALS['log']->fatal('EchoSign: STATUS ERROR - '.print_r($$result->status, true));
				$result->status = $result->status[0];
				$GLOBALS['log']->fatal('EchoSign: STATUS ERROR - Setting Status to '.$result->status);
			}
		
			if($result->status != $this->status_id)
			{
				// in 6.0.4 and 6.1.8 $this->save() was killing the relationships to accounts and opps
				$ea = new echo_Agreements();
				$ea->retrieve($this->id);
				
				$ea->status_id = $result->status;
				if(strtolower($ea->status_id) == 'signed' || strtolower($ea->status_id) == 'approved'){
					$ea->save_document();
					$ea->date_signed = gmdate('Y-m-d', $max_date);
				}
				$ea->save();
			}
		}
		else
		{
			$this->echosign_error_msg = 'Document Not Found';
		}
		
		$this->delete_duplicate_events();

		return isset($app_list_strings['echosign_status_id_list'][$this->status_id]) ? $app_list_strings['echosign_status_id_list'][$this->status_id] : $app_list_strings['echosign_status_id_list']['OTHER'];

	}
	
	
	
	
	private function create_event($event)
	{
		// weird api bug returns the api_key as the description of an event when the doc expires
		// don't want to expose this to the users
		if(!empty($event->description) && 
			$event->description != $GLOBALS['sugar_config']['echosign']['api_key'] &&
			!$this->check_if_event_exists($event))
		{
			$e = new echo_Events();
			$e->name = $event->description;
			$e->echo_timestamp = $event->date;
			
			// convert the EchoSign timestamp to UTC
			$dt = new DateTime($event->date);
			$dt->setTimezone(new DateTimeZone('UTC'));
			$e->echo_datetime = $dt->format('Y-m-d H:i:s');   
			
			$e->doc_version = $event->documentVersionKey;
			$e->assigned_user_id = $this->assigned_user_id;
			$e->echo_agreec711eements_ida = $this->id;
			$e->save();
			
		}
	}
	
	
	
	/**
	 *	Check If Event Exists 
	 *	- See if a given event for an agreement has already been imported.
	 *
	 ***/
	private function check_if_event_exists($event)
	{
		$key = md5($event->description.$event->date);
	
		// Get all linked events to this agreement
		$this->events = $this->get_linked_beans('echo_agreements_echo_events', 'echo_Events');	
		
		// compare the md5 of the name and timestamp. If the same, return true
		foreach($this->events as $existing_event){
			if(md5($existing_event->name.$existing_event->echo_timestamp) === $key){
				return true;
			}
		}
		
		return false;
	}
	
	

	private function delete_duplicate_events()
	{
		$keys = array();
		$this->events = $this->get_linked_beans('echo_agreements_echo_events', 'echo_Events');	
		foreach($this->events as $e){
			
			$key = md5($e->name.$e->echo_timestamp);
		
			if(isset($keys[$key])){
				$e->deleted = 1;
				$e->save();
			}
			
			$keys[$key] = $key;
		}
	}
	
	
	
	
	
	/**
	 *	Save Document
	 *
	 *  save the acutal signed document.
	 *
	 **/
	private function save_document()
	{
		if(!$this->filename)
		{
			if(empty($this->echoSign)) $this->echoSign = new EchoSign();
			
			$filename = preg_replace("[^A-Za-z0-9 ]", " ", $this->document_name).'.pdf';	
			
			$this->filename = $filename;
			$this->file_ext = 'pdf';
			$this->file_mime_type = 'application/pdf';
			
			// download the pdf and store it on the server
			$pdf = $this->echoSign->getLatestDocument($this->document_key);
			sugar_file_put_contents($GLOBALS['sugar_config']['upload_dir'].$this->id, $pdf->pdf);
		}
	}
}
