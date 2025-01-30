<?php

include('../vendor/autoload.php');

use Libs\Database\MySQL;   
use Libs\Database\Table;
use Helpers\HTTP;

$table = new Table(new MySQL);
$table->addShowTime([
    'movie_id' => $_POST['movie_id'],
    'theater_id' => $_POST['theater_id'],
    'show_time' => $_POST['show_time'],
]);

HTTP::redirect('../index.php', "success=Showtime added successfully");