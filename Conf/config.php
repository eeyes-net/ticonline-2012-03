<?php
//全局数据库配置文件
return array(
    'URL_MODEL' => 1, // 如果你的环境不支持PATHINFO 请设置为3
    'DB_TYPE' => 'mysqli',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'ticonline',
    'DB_USER' => 'ticonline',
    'DB_PWD' => '', // 数据库密码
    'DB_PORT' => '3306',
    'DB_PREFIX' => null,
    'APP_AUTOLOAD_PATH' => '@.TagLib',
    // 'SHOW_PAGE_TRACE' => true,
    // 'SHOW_RUN_TIME' => true, // 运行旪间显示
    // 'SHOW_ADV_TIME' => true, // 显示详细的运行旪间
    // 'SHOW_DB_TIMES' => true, // 显示数据库查询和写入次数
    // 'SHOW_CACHE_TIMES'=>true, // 显示缓存操作次数
    'LOAD_EXT_FILE' => 'extend',
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => '/Public',
        '__APP__' => '/index.php',
    ),
);
?>
