<?php

$dbconf = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=exelcalib',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

if(file_exists(__DIR__ . '/db.overwrite.php')) 
	include(__DIR__ . '/db.overwrite.php');
	
return $dbconf;