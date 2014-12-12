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
// created: 2011-05-19 17:34:57
$dictionary["echo_agreements_echo_events"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'echo_agreements_echo_events' => 
    array (
      'lhs_module' => 'echo_Agreements',
      'lhs_table' => 'echo_agreements',
      'lhs_key' => 'id',
      'rhs_module' => 'echo_Events',
      'rhs_table' => 'echo_events',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'echo_agreem_echo_events_c',
      'join_key_lhs' => 'echo_agreec711eements_ida',
      'join_key_rhs' => 'echo_agree2502_events_idb',
    ),
  ),
  'table' => 'echo_agreem_echo_events_c',
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
      'name' => 'echo_agreec711eements_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'echo_agree2502_events_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'echo_agreemts_echo_eventsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'echo_agreemts_echo_events_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'echo_agreec711eements_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'echo_agreemts_echo_events_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'echo_agree2502_events_idb',
      ),
    ),
  ),
);
?>
