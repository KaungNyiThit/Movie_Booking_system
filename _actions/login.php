<?php

include '../vendor/autoload.php';

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\HTTP;
use Helpers\Auth;

$table = new Table(new MySQL);

$email = $_POST['email'];
$password = $_POST['password'];

$user = $table->login($email, $password);

if($user){
    session_start();

    $_SESSION['user'] = $user;

    HTTP::redirect('../index.php', 'login=success');
}

HTTP::redirect('../index.php', 'failed=login');