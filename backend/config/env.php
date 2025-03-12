<?php
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'innovators_hub');
define('DB_USER', getenv('DB_USER') ?: 'your_postgres_user');
define('DB_PASS', getenv('DB_PASS') ?: 'your_postgres_password');

define('MAIL_HOST', getenv('MAIL_HOST') ?: 'smtp.gmail.com');
define('MAIL_USER', getenv('MAIL_USER') ?: 'your-email@gmail.com');
define('MAIL_PASS', getenv('MAIL_PASS') ?: 'your-email-password');
?>
