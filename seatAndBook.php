<?php
include ('vendor/autoload.php');
use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\Auth;

session_start();
$auth = Auth::user();
$selectSeat = $_POST['seat_type'];
$id = $_POST['id'];
$table = new Table(new MySQL);

$seats = $table->getavaliableSeats($selectSeat, $id);

$all = $table->getAll($_POST['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="margin: 0; padding: 0">
    <?php include('navbar.php') ?>
    <?php if(!empty($seats)) :?>
    <?php foreach($seats as $seat) : ?>
        
        <div class="container my-5">
            <div class="table-responsive">
            <form action="_actions/movie_book.php" method="get">
                <table class="table table-bordered" >
                    <tr>
                        <th>Seat</th>
                        <th>Seat Type</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><?= $seat->seat ?></td>
                        <td><?= $seat->seat_type ?></td>
                        <td><?= $seat->price ?></td>
                        <td hidden><input type="hidden" name="movie_id" value="<?= $seat->movie_id ?>"></td>
                        <td>
                            <input type="hidden" name="seat" value="<?= $seat->seat ?>">
                            <input type="hidden" name="seat_type" value="<?= $seat->seat_type ?>">
                            <input type="hidden" name="price" value="<?= $seat->price ?>">
                            <input type="hidden" name="movie_id" value="<?= $seat->movie_id ?>">
                            <input type="hidden" name="theater_id" value="<?= $all->theater_id ?? "" ?>">
                            <input type="hidden" name="showtime_id" value="<?= $all->showtime_id ?? "" ?>">
                            <input type="hidden" name="user_id" value="<?= $auth->id ?? 'guest' ?>" >
                            <button type="submit" class="btn btn-primary">Book</button>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <div class="container my-5">
            <div class="alert alert-danger">No seats available</div>
        </div>
    <?php endif; ?>

</body>
</html>