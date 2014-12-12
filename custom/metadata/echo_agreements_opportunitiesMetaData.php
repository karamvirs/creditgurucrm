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
$dictionary["echo_agreements_opportunities"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'echo_agreements_opportunities' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'echo_Agreements',
      'rhs_table' => 'echo_agreements',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'echo_agreements_opportunities_c',
      'join_key_lhs' => 'echo_agreements_opportunitiesopportunities_ida',
      'join_key_rhs' => 'echo_agreements_opportunitiesecho_agreements_idb',
    ),
  ),
  'table' => 'echo_agreements_opportunities_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'echo_agreements_opportunitiesopportunities_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'echo_agreements_opportunitiesecho_agreements_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'echo_agreements_opportunitiesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'echo_agreements_opportunities_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'echo_agreements_opportunitiesopportunities_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'echo_agreements_opportunities_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'echo_agreements_opportunitiesecho_agreements_idb',
      ),
    ),
  ),
);