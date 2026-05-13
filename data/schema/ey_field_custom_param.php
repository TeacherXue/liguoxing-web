<?php 
return array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => NULL,
    'primary' => true,
    'autoinc' => true,
  ),
  'field_id' => 
  array (
    'name' => 'field_id',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'channel_id' => 
  array (
    'name' => 'channel_id',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'dtype' => 
  array (
    'name' => 'dtype',
    'type' => 'varchar(40)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'name' => 
  array (
    'name' => 'name',
    'type' => 'varchar(60)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'dfvalue' => 
  array (
    'name' => 'dfvalue',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'sort_order' => 
  array (
    'name' => 'sort_order',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'add_time' => 
  array (
    'name' => 'add_time',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'update_time' => 
  array (
    'name' => 'update_time',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
);