<?php
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
// created: 2011-05-19 17:34:58
$dictionary["echo_Recipients"]["fields"]["echo_agreements_echo_recipients"] = array (
  'name' => 'echo_agreements_echo_recipients',
  'type' => 'link',
  'relationship' => 'echo_agreements_echo_recipients',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_AGREEMENTS_TITLE',
);
$dictionary["echo_Recipients"]["fields"]["echo_agreements_echo_recipients_name"] = array (
  'name' => 'echo_agreements_echo_recipients_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_AGREEMENTS_TITLE',
  'save' => true,
  'id_name' => 'echo_agree6a54eements_ida',
  'link' => 'echo_agreements_echo_recipients',
  'table' => 'echo_agreements',
  'module' => 'echo_Agreements',
  'rname' => 'document_name',
);
$dictionary["echo_Recipients"]["fields"]["echo_agree6a54eements_ida"] = array (
  'name' => 'echo_agree6a54eements_ida',
  'type' => 'link',
  'relationship' => 'echo_agreements_echo_recipients',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_RECIPIENTS_TITLE',
);
