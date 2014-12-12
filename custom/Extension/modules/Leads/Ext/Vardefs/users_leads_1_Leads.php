<?php
// created: 2014-08-22 11:19:04
$dictionary["Lead"]["fields"]["users_leads_1"] = array (
  'name' => 'users_leads_1',
  'type' => 'link',
  'relationship' => 'users_leads_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_LEADS_1_FROM_USERS_TITLE',
  'id_name' => 'users_leads_1users_ida',
);
$dictionary["Lead"]["fields"]["users_leads_1_name"] = array (
  'name' => 'users_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_LEADS_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_leads_1users_ida',
  'link' => 'users_leads_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Lead"]["fields"]["users_leads_1users_ida"] = array (
  'name' => 'users_leads_1users_ida',
  'type' => 'link',
  'relationship' => 'users_leads_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_LEADS_1_FROM_LEADS_TITLE',
);
