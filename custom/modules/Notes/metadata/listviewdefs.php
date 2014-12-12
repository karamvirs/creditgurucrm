<?php
$listViewDefs ['Notes'] = 
array (
  'TODO_TYPE_NOTES_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TODO_TYPE_NOTES',
    'width' => '5%',
  ),
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_SUBJECT',
    'link' => true,
    'default' => true,
  ),
  'FILENAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_FILENAME',
    'default' => true,
    'type' => 'file',
    'related_fields' => 
    array (
      0 => 'file_url',
      1 => 'id',
    ),
    'displayParams' => 
    array (
      'module' => 'Notes',
    ),
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '30%',
    'default' => true,
  ),
  'CONTACT_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CONTACT',
    'link' => true,
    'id' => 'CONTACT_ID',
    'module' => 'Contacts',
    'default' => true,
    'ACLTag' => 'CONTACT',
    'related_fields' => 
    array (
      0 => 'contact_id',
    ),
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_BY',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'width' => '20%',
    'label' => 'LBL_DATE_MODIFIED',
    'link' => false,
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'label' => 'LBL_CREATED_BY',
    'width' => '10%',
    'default' => false,
    'related_fields' => 
    array (
      0 => 'created_by',
    ),
  ),
);
?>
