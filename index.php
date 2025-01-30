<?php
    include('vendor/autoload.php');
    use Libs\Database\MySQL;
    use Libs\Database\Table;
    use Helpers\Auth;

    $auth = Auth::user();

    $table = new Table(new MySQL);

    if(isset($_GET['theater_id'])){
        $theater_id = $_GET['theater_id'];
    }else{
        $theater_id = null;
    }

    $movies =   $theater_id ? $table->getMoviesByTheater($theater_id) : $table->allMovies();

    $theaters = $table->allTheaters();
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<style>
    #poster {
        transition: transform 0.5s;
    }

    #poster:hover {
        transform: scale(1.1);
    }


</style>

<body style="background-color: #212121">

    <?php include('navbar.php'); ?>
   
    <div class="container mt-5" >
        <?php if(isset($_GET['auth'])) : ?>
            <div class="alert alert-warning">Login First</div>
        <?php endif ?>

        <?php if(isset($_GET['failed'])) : ?>
            <div class="alert alert-danger">Wrong Candidate</div>
        <?php endif ?>

        <?php if(isset($_GET['register'])) : ?>
            <div class="alert alert-success">Register Success</div>
        <?php endif ?>

        <?php if(isset($_GET['login'])) : ?>
            <div class="alert alert-success">Login Success</div>
        <?php endif ?>

        <?php if(isset($_GET['delete'])) : ?>
            <div class="alert alert-success">Delete Success</div>
        <?php endif ?>
        <?php if(isset($_GET['add'])) : ?>
            <div class="alert alert-success">Add Success</div>
        <?php endif ?>
        <!-- Add Movie Form -->
        <?php if(isset($_SESSION['user']) && $auth->role === 'admin') :?>
        <div class="card my-4 p-5  shadow rounded">
            <div class="">
                Add Movie
            </div>
            <div class="card-body">
                <form action="_actions/add_movie.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Movie Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" class="form-control" id="genre" name="genre" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                    <div class="form-group my-4">
                        <label for="poster">Poster</label>
                        <input type="file" class="form-control"  name="poster" >
                    </div>
                    <div class="form-group">
                        <label for="trailer">Trailer url</label>
                        <input type="url" class="form-control" id="trailer" name="trailer"  placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="form-group mt-3">
                        <select name="theater_id" class="form-select">
                        <?php foreach($theaters as $theater) : ?>
                            <option value="<?= $theater->id ?>"><?= $theater->name ?></option>
                        <?php endforeach ?>
                        </select>
                    </div>

                    <button class="btn btn-primary my-3">Add Movie</button>
                </form>
            </div>
        </div>
        <?php endif ?>

        <!-- Fliter by theater -->
        <form method="get" action="index.php">
            <div class="form-group">
            <select name="theater_id" id="" class="form-select d-inline-block py-2" style="width: 150px">
                <option value="">All Theaters</option>
                <?php foreach($theaters as $theater) : ?>
                    <option value="<?= $theater->id ?>"><?= $theater->name ?></option>
                <?php endforeach ?>
            </select>

            <button class="btn btn-secondary">Fliter</button>
            </div>
        </form>

        <!-- Available Movies List -->
        <div class="row ">
            <?php foreach($movies as $movie) : ?>
            <div class="col-12 col-md-6 col-lg-4 text-center my-5 text-white">
                <img src="_actions/posters/<?= $movie->poster ?>" alt="<?= $movie->title ?>" class="img-fluid shadow rounded" id="poster" style="border-radius: 10px; object-fit: cover; height: 550px">

                <div class="pt-4">
                    <h3 style="font-size: 1.2rem"><?= $movie->title ?></h2>
                    <p style="opacity: 0.7; ">Genre: <?= $movie->genre ?></p>
                    <p style="opacity: 0.7; ">Duration: <?= $movie->duration ?></p>
                    <a href="showtime.php?movie_id=<?= $movie->id ?>" class="text-white">View ShowTime</a>
                    <?php if(isset($_SESSION['user']) && $auth->role === "admin") : ?>
                        <a href="_actions/delete.php?movie_id=<?= $movie->id ?>" class="btn btn-danger ms-2">Delete</a>
                    <?php endif ?>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>