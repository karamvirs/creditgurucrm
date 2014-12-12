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
// created: 2012-04-17 16:23:59
$dictionary["echo_Agreements"]["fields"]["echo_agreements_opportunities"] = array (
  'name' => 'echo_agreements_opportunities',
  'type' => 'link',
  'relationship' => 'echo_agreements_opportunities',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'echo_agreements_opportunitiesopportunities_ida',
);
$dictionary["echo_Agreements"]["fields"]["echo_agreements_opportunities_name"] = array (
  'name' => 'echo_agreements_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'echo_agreements_opportunitiesopportunities_ida',
  'link' => 'echo_agreements_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["echo_Agreements"]["fields"]["echo_agreements_opportunitiesopportunities_ida"] = array (
  'name' => 'echo_agreements_opportunitiesopportunities_ida',
  'type' => 'link',
  'relationship' => 'echo_agreements_opportunities',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ECHO_AGREEMENTS_OPPORTUNITIES_FROM_ECHO_AGREEMENTS_TITLE',
);
