<?php

/**
 * 入口文件
 *
 * @author $Author: 5590548@qq.com $
 *
 */
// 设置错误报告级别
error_reporting(E_ALL ^ E_NOTICE);

// 当前时间
define('TIMENOW', $_SERVER['REQUEST_TIME']);
// 目录分隔符
define('DS', DIRECTORY_SEPARATOR);

// 项目路径
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH);
define('PUB_PATH', APP_PATH . DS . 'public');

$app = new Yaf\Application(APP_PATH . DS . 'conf' . DS . 'application.ini');
$app->bootstrap()->run();

