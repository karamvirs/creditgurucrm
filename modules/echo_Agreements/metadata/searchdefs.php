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
$module_name = 'echo_Agreements';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'document_name' => 
      array (
        'name' => 'document_name',
        'default' => true,
        'width' => '10%',
      ),
      'status_id' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DOC_STATUS',
        'sortable' => false,
        'width' => '10%',
        'name' => 'status_id',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'document_name' => 
      array (
        'name' => 'document_name',
        'default' => true,
        'width' => '10%',
      ),
      'status_id' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DOC_STATUS',
        'sortable' => false,
        'width' => '10%',
        'name' => 'status_id',
      ),
      'signature_type' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'default' => true,
        'label' => 'LBL_SIGNATURE_TYPE',
        'sortable' => false,
        'width' => '10%',
        'name' => 'signature_type',
      ),
      'signature_flow' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SIGNATURE_FLOW',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'signature_flow',
      ),
      'date_sent' => 
      array (
        'type' => 'date',
        'label' => 'LBL_DATE_SENT',
        'width' => '10%',
        'default' => true,
        'name' => 'date_sent',
      ),
      'date_signed' => 
      array (
        'type' => 'date',
        'label' => 'LBL_DATE_SIGNED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_signed',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
