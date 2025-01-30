<?php
    include('vendor/autoload.php');
    use Libs\Database\MySQL;
    use Libs\Database\Table;

    $table = new Table(new MySQL);
    if(!isset($_GET['id']) || empty($_GET['id'])){
        header('Location: showtime.php');
    }
    $id = $_GET['id'];

    $movie = $table->getAllMoviesWithTheater($id);

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
    <div class="container mt-5 text-white">
        <h2>Add Seat</h2>
        <form action="_actions/process_seat.php" method="post">
            <div class="form-group">
                <label for="seat">Seat</label>
                <input type="text" class="form-control" id="seat" name="seat" required>
            </div>
            <div class="form-group">
                <input type="hidden" value="<?= $movie->id  ?>" name="movie_id">
                <label for="seat_type">Seat Type</label>
                <select class="form-control" id="seat_type" name="seat_type" required>
                    <option value="7000mmk">7000 MMK</option>
                    <option value="8000mmk">8000 MMK</option>
                    <option value="couple">Couple</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</body>
</html>