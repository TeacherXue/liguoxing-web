<?php 
return array (
  'sharp_goods_id' => 
  array (
    'name' => 'sharp_goods_id',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => NULL,
    'primary' => true,
    'autoinc' => true,
  ),
  'aid' => 
  array (
    'name' => 'aid',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'limit' => 
  array (
    'name' => 'limit',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'seckill_stock' => 
  array (
    'name' => 'seckill_stock',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'seckill_price' => 
  array (
    'name' => 'seckill_price',
    'type' => 'decimal(10,2)',
    'notnull' => false,
    'default' => '0.00',
    'primary' => false,
    'autoinc' => false,
  ),
  'sales' => 
  array (
    'name' => 'sales',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'virtual_sales' => 
  array (
    'name' => 'virtual_sales',
    'type' => 'int',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'sort_order' => 
  array (
    'name' => 'sort_order',
    'type' => 'int unsigned',
    'notnull' => false,
    'default' => '100',
    'primary' => false,
    'autoinc' => false,
  ),
  'status' => 
  array (
    'name' => 'status',
    'type' => 'tinyint unsigned',
    'notnull' => false,
    'default' => '1',
    'primary' => false,
    'autoinc' => false,
  ),
  'is_del' => 
  array (
    'name' => 'is_del',
    'type' => 'tinyint unsigned',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'is_sku' => 
  array (
    'name' => 'is_sku',
    'type' => 'tinyint(1)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'lang' => 
  array (
    'name' => 'lang',
    'type' => 'varchar(50)',
    'notnull' => false,
    'default' => 'cn',
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