<?php

include('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\HTTP;

$table = new Table(new MySQL);
$table->register([
    "username" => $_POST['username'],
    "email" => $_POST['email'],
    "password" => $_POST['password'],
    "phone" => $_POST['phone'], 
]);

HTTP::redirect('../index.php', 'register=success');