<?php
include('vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\Table;
use Helpers\Auth;

$table = new Table(new MySQL);
$auth = Auth::user();

if(!isset($_GET['movie_id']) || empty($_GET['movie_id'])){
    header('Location: index.php');
}
$id = $_GET['movie_id'];


$movie =$table->getAllMoviesWithTheater($id);

if(strpos($movie->trailer, 'youtu.be')){
    $movie->trailer = str_replace('youtu.be', 'youtube.com/embed', $movie->trailer);    
}elseif(strpos($movie->trailer, 'youtube.com')){
    $movie->trailer = str_replace('youtube.com', 'youtube.com/embed', $movie->trailer);
}

$showtime = $table->getShowtimes($id);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>

</head>
<style>
    #movies{
        font-family: 'oswald';
        font-size: 1.3rem;
    }

    #movies h2{
        font-weight: bold;
    }

    /* #seatSelect{
        position: fixed;
        top: -100%;
        left: 0;
        right: 0;
        transition: 0.2s ease-in-out;
        z-index: 1;
    }

    #seatSelect.show{
        top: 0;
    } */

</style>
<body style="background-color: #212121">

    <?php include('navbar.php') ?>
    <!-- add theater -->
    <?php if( isset($_SESSION['user']) && $auth->role === 'admin'): ?>
    <div class="container mt-5 text-white">
        <h2 class="mb-4">Add Theater</h2>
        <form action="_actions/add_theater.php" method="post">
            <div class="form-group">
                <label for="theaterName">Theater Name</label>
                <input type="text" class="form-control" id="theaterName" name="name" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3" >Submit</button>
        </form>
    </div>
    <?php endif; ?>
    <!-- addshowtime  -->
    <?php if(isset($_SESSION['user']) && $auth->role === 'admin'): ?>
    <div class="container mt-5 text-white">
        <h2 class="mb-4">Add show time</h2>
        <form action="_actions/add_showtime.php" method="post">
                <input type="hidden" name="movie_id" value="<?= $movie->id ?>" >
                <input type="hidden" name="theater_id" value="<?= $movie->theater_id ?>" >

                <div class="form-group">
                    <label for="showtime">Show Time</label>
                    <input type="datetime-local" class="form-control" id="showtime" name="show_time" required>
                </div>

            <button type="submit" class="btn btn-primary mt-3" >Submit</button>
        </form>
    </div>
    <?php endif; ?>
    <!-- trailer -->
    <div class="container my-3" id="movies">
        <?php if ($movie->trailer): ?>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" style="width: 100%; height: 400px" src="<?= $movie->trailer ?>" allowfullscreen></iframe>
            </div>
        <?php endif; ?>
        <!-- add seat -->
        <?php if( isset($_SESSION['user']) && $auth->role === 'admin'): ?>
        <a href="add_seat.php?id=<?= $movie->id ?>" class="text-decoration-none text-white">Add Seat+</a>
        <?php endif; ?>

        <!-- movie info -->
        <div class="card my-4 p-5 shadow rounded text-white" style="background-color: #333;">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <img src="_actions/posters/<?= $movie->poster ?>" alt="<?= $movie->title ?>" class="img-fluid" id="poster">
                </div>
                <div class="col-md-8">
                    <h2><?= $movie->title ?></h2>
                    <p>Genre: <?= $movie->genre ?></p>
                    <p>Duration: <?= $movie->duration ?></p>
                    <p>Theater: <?= $movie->theater_name ?></p>
                    <p>Location: <?= $movie->theater_location ?></p>
                    <p>ShowTime: <?= $showtime->show_time ?? "Not Set Yet!"?></p>
                    <a data-bs-target="#seatSelect" data-bs-toggle="modal" class="btn btn-success">Seat Select</a>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="seatSelect" tabindex="-1" aria-labelledby="seatSelectLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="seatSelectLabel">Select Seat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="seatAndBook.php" method="post">
                            <input type="hidden" name="id" value="<?= $movie->id ?>">

                            <div class="form-check mt-4">
                                <input type="radio" class="form-check-input" id="seat_type1" name="seat_type" value="7000MMK">
                                <label class="form-check-label" for="seat_type1">7000MMK</label>
                            </div>
                            <div class="form-check mt-4">
                                <input type="radio" class="form-check-input" id="seat_type2" name="seat_type" value="8000MMK">
                                <label class="form-check-label" for="seat_type2">8000MMK</label>
                            </div>
                            <div class="form-check mt-4">
                                <input type="radio" class="form-check-input" id="seat_type3" name="seat_type" value="Couple">
                                <label class="form-check-label" for="seat_type3">Couple</label>
                            </div>
                            <button type="submit" class="btn btn-success mt-4">Select Seat</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Back</button>
                    </div>
                </div>
            </div>
        </div>

</body>
</html>