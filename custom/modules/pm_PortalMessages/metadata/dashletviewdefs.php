<?php
$dashletData['pm_PortalMessagesDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'default' => 'Administrator',
  ),
);
$dashletData['pm_PortalMessagesDashlet']['columns'] = array (
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
    'name' => 'description',
  ),
  'pm_portalmessages_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_PM_PORTALMESSAGES_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'PM_PORTALMESSAGES_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'reply_by_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_REPLY_BY',
    'width' => '10%',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
    'name' => 'created_by_name',
  ),
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'width' => '40%',
    'label' => 'LBL_NAME',
    'default' => false,
    'name' => 'name',
  ),
);
