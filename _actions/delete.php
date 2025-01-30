<?php

include('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\HTTP;

$table = new Table(new MySQL);

$id = $_GET['movie_id'];
$table->delete($id);

HTTP::redirect('/index.php', "delete=success");