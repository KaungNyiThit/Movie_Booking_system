<?php

include('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\HTTP;

$photoName = $_FILES['poster']['name'];
$tmp = $_FILES['poster']['tmp_name'];
$type = $_FILES['poster']['type'];

$posterPath = basename($photoName); 

if($type === "image/jpeg" || $type === "image/png"){
    move_uploaded_file($tmp, "posters/$posterPath");

    $table = new Table(new MySQL);

    $table->addMovie([
        "title" => $_POST['title'],
        "genre" => $_POST['genre'],
        "duration" => $_POST['duration'],
        "poster" => $posterPath,
        "theater_id" => $_POST['theater_id'],
        "trailer" => $_POST['trailer'],
    ]);
    HTTP::redirect('../index.php', 'add=movie');
}else{
    HTTP::redirect('../index.php', 'error=insert_error');
}

