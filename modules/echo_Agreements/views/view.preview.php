<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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
class echo_AgreementsViewPreview extends ViewDetail{
    
    public function __construct(){
    	parent::ViewDetail();
    }
    
    public function display()
    {
    	if(!empty($_REQUEST['iframe_url'])){
    		$this->bean->iframe_url = urldecode($_REQUEST['iframe_url']);
    	}
    
		if($this->bean->send_document_interactively && !empty($this->bean->iframe_url))
		{
			echo '<div>	
					<div class="moduleTitle">
						<h2>Preview and Position Fields For EchoSign Agreement: <a href="index.php?module=echo_Agreements&action=DetailView&record='.$this->bean->id.'">'.$this->bean->name.'</a></h2>
					</div>
				  </div>';
			
			
			echo '<div style="clear:both;">';
		
			if($this->bean->host_signing_for_first_signer)		
				echo '<p>After sending the document, host signing for first signer here: <a href="index.php?module=echo_Agreements&action=interactive&record='.$this->bean->id.'">Host Signing</a></p>';
			
			echo '<div style="clear:both;">';
		
			$iframe_url = str_replace('embed/', '', $this->bean->iframe_url);
			echo '<iframe src="'.$iframe_url.'" width="940" height="690" frameborder="0" style="border: 0; overflow: auto" scrolling=yes></iframe>';
		
			echo '</div>';
		}
	}
}

?>   