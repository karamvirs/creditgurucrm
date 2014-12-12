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
$dictionary["echo_Events"]["fields"]["echo_agreements_echo_events"] = array (
  'name' => 'echo_agreements_echo_events',
  'type' => 'link',
  'relationship' => 'echo_agreements_echo_events',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_AGREEMENTS_TITLE',
);
$dictionary["echo_Events"]["fields"]["echo_agreements_echo_events_name"] = array (
  'name' => 'echo_agreements_echo_events_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_AGREEMENTS_TITLE',
  'save' => true,
  'id_name' => 'echo_agreec711eements_ida',
  'link' => 'echo_agreements_echo_events',
  'table' => 'echo_agreements',
  'module' => 'echo_Agreements',
  'rname' => 'document_name',
);
$dictionary["echo_Events"]["fields"]["echo_agreec711eements_ida"] = array (
  'name' => 'echo_agreec711eements_ida',
  'type' => 'link',
  'relationship' => 'echo_agreements_echo_events',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_EVENTS_TITLE',
);
