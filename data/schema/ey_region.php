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
  'name' => 
  array (
    'name' => 'name',
    'type' => 'varchar(32)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'level' => 
  array (
    'name' => 'level',
    'type' => 'tinyint',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'initial' => 
  array (
    'name' => 'initial',
    'type' => 'varchar(5)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
);