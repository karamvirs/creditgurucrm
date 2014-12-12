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
$dictionary["echo_agreements_documents"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'echo_agreements_documents' => 
    array (
      'lhs_module' => 'echo_Agreements',
      'lhs_table' => 'echo_agreements',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'echo_agreemts_documents_c',
      'join_key_lhs' => 'echo_agree3ec7eements_ida',
      'join_key_rhs' => 'echo_agree1b23cuments_idb',
    ),
  ),
  'table' => 'echo_agreemts_documents_c',
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
      'name' => 'echo_agree3ec7eements_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'echo_agree1b23cuments_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
    5 => 
    array (
      'name' => 'document_revision_id',
      'type' => 'varchar',
      'len' => '36',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'echo_agreements_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'echo_agreements_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'echo_agree3ec7eements_ida',
        1 => 'echo_agree1b23cuments_idb',
      ),
    ),
  ),
);
?>
