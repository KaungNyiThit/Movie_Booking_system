<?php
include('vendor/autoload.php');
use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\Auth;

$auth = Auth::user();

$table = new Table(new MySQL);

$bookings = $table->getBookings($auth->id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #212121">
    <?php include('navbar.php') ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded">
                    <div class="card-header">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($auth->username); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($auth->email); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($auth->phone); ?></p>
                    </div>
                </div>
            </div>

            <div class=" table-responsive  mt-5">
                <div class="card shadow rounded" style="width: 1000px;">
                    <div class="card-header">
                        <h3>Your Bookings</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Movie</th>
                                    <th>ShowTime</th>
                                    <th>Seat</th>
                                    <th>SeatType</th>
                                    <th>Theater</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $counter = 1; ?>
                                <?php foreach($bookings as $book) : ?>
                                <tr>
                                    <td><?= $counter++ ?></td>
                                    <td><?= $book->movie_title ?></td>
                                    <td><?=$book->show_time ?></td>
                                    <td><?= $book->seat ?></td>
                                    <td><?=$book->seat_type ?></td>
                                    <td><?=$book->theater_name?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>