<?php

include ('../vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\HTTP;

$table = new Table(new MySQL);

// $data = [ 
//     'seat' => 'A1',
//     'seat_type' => 'VIP',
//     'price' => 15.00,
//     'movie_id' => $_POST['movie_id'],
//     'is_booked' => 0
// ]

$seat = $table->addSeat([
    'seat' => $_POST['seat'],
    'seat_type' => $_POST['seat_type'],
    'price' => $_POST['price'],
    'movie_id' => $_POST['movie_id'],
    'is_booked' => 0,
]);

if($seat){
    HTTP::redirect('/showtime.php', 'seat=booked');
}else{
    HTTP::redirect('/index.php', 'seat=error');
}