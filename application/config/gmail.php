<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// สำหรับส่งอีเมลผ่านบริการของ Gmail
// จะต้องตั้งค่าที่ https://myaccount.google.com/security
// เปิด "การเข้าถึงของแอปที่มีความปลอดภัยน้อย" เพื่อให้สามารถส่งจาก Localhost ได้
$config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
					'mailtype'  => 'html',
                    'charset'   => 'utf-8',
					'smtp_user' => 'xxxxx@gmail.com',			// Your Gmail 
                    'smtp_pass' => 'xxxxxx',					// Your Gmail Password
					'from_mail' => 'ceosofts@gmail.com',			// Contact Email
					'from_name' => 'CEO Softs'			// Contact Name
                );
