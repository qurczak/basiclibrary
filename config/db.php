<?php

$db_password = require(__DIR__ . '/db_password.php');
$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'charset' => 'utf8',
];
$db['password'] = $db_password['password'];

return $db;

