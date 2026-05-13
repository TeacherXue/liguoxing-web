<?php 
return array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'int',
    'notnull' => false,
    'default' => NULL,
    'primary' => true,
    'autoinc' => true,
  ),
  'upload_type' => 
  array (
    'name' => 'upload_type',
    'type' => 'varchar(50)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'add_time' => 
  array (
    'name' => 'add_time',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'update_time' => 
  array (
    'name' => 'update_time',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
);