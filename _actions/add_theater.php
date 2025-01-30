<?php

include('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;

$table = new Table(new MySQL);

$table->addTheater([
    'name' => $_POST['name'],
    'location' => $_POST['location']
]);

header('location: ../index.php', );