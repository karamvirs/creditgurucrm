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
$dictionary["echo_Agreements"]["fields"]["echo_agreements_accounts"] = array (
  'name' => 'echo_agreements_accounts',
  'type' => 'link',
  'relationship' => 'echo_agreements_accounts',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'id_name' => 'echo_agreements_accountsaccounts_ida',
);
$dictionary["echo_Agreements"]["fields"]["echo_agreements_accounts_name"] = array (
  'name' => 'echo_agreements_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ECHO_AGREEMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'echo_agreements_accountsaccounts_ida',
  'link' => 'echo_agreements_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["echo_Agreements"]["fields"]["echo_agreements_accountsaccounts_ida"] = array (
  'name' => 'echo_agreements_accountsaccounts_ida',
  'type' => 'link',
  'relationship' => 'echo_agreements_accounts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ECHO_AGREEMENTS_ACCOUNTS_FROM_ECHO_AGREEMENTS_TITLE',
);
