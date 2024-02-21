<?php
const _MODULE = 'home';
const _ACTION = 'dashboard';

const _CODE = true;
define('_WEB_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/WebBanHang/admin');
define('_WEB_HOST_TEMPLATE', _WEB_HOST . '/template');

//Thiết lập path
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH . '/template');

//Thông tin kết nối
const _HOST = 'localhost';
const _DB = 'fashionweb';
const _USER = 'root';
const _PASS = 'mysql';