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
class echo_AgreementsViewInteractive extends ViewDetail{
    
    public function __construct(){
    	parent::ViewDetail();
    }
    
    public function display()
    {
    	if($this->bean->host_signing_for_first_signer)
		{
			echo '<div>	
					<div class="moduleTitle">
						<h2>Host Signing for the First Signer:  <a href="index.php?module=echo_Agreements&action=DetailView&record='.$this->bean->id.'">'.$this->bean->name.'</a></h2>
					</div>
				</div>';
			echo '<div style="clear:both;">';
			echo '<iframe src="index.php?module=echo_Agreements&action=EchoSignNow&to_pdf=1&record='.$this->bean->id.'" width="940" height="690" frameborder="0" style="border: 0; overflow: auto" scrolling=yes></iframe>';
			echo '</div>';
		}
	}
}

?>   