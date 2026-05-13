<?php

// 应用行为扩展定义文件
return array(
    // 模块初始化
    'module_init'  => array(
        'weapp\\pojie\\behavior\\admin\\pojieBehavior',
        'weapp\\pojie\\behavior\\admin\\pojieMeal'
    ),
    // 操作开始执行
    'action_begin' => array(

    ),
    // 视图内容过滤
    'view_filter'  => array(

    ),
    // 日志写入
    'log_write'    => array(

    ),
    // 应用结束
    'app_end'      => array(

    ),
);