<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// สำหรับส่งอีเมลผ่านบริการของ Gmail
$config = array(
	'protocol'  => 'smtp',
	'smtp_host' => 'xxx.xxxx.com',
	'smtp_port' => 25,
	'smtp_user' => 'xxxx',
	'smtp_pass' => 'xxxx',
	'mailtype'  => 'html',
	'charset'   => 'utf-8',
	'from_mail' => 'ceosofts@gmail.com',
	'from_name' => 'CEO Softs'
);
