<?php

include ('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

if(isset($_GET['auth'])){
    echo '<script>alert("Login First")</script>';
}

$table = new Table(new MySQL);

$table->bookMovie([
    'seat' => $_GET['seat'],
    'seat_type' => $_GET['seat_type'],
    'price' => $_GET['price'],
    'movie_id' => $_GET['movie_id'],
    'theater_id' => $_GET['theater_id'],
    'user_id' => $_GET['user_id'],
    'showtime_id' => $_GET['showtime_id'],
]);

HTTP::redirect('../index.php', 'seat=booked');