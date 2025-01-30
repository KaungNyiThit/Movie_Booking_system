

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<!-- <style>
    #login,#register {
        position: fixed;
        top: -100%;
        left: 0;
        right: 0;
        transition: 0.2s ease-in-out;
        z-index: 1;
    }

    #login.show,#register.show {
        top: 0;
    }   
</style> -->
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark position-sticky justify-content-center" style="top: 0; z-index: 1">
        <div class="container">
            <a class="navbar-brand" href="index.php">Movie Booking System</a>
            <?php if($auth): ?>
                <div>
                    <a class="text-decoration-none me-2 text-white" style="opacity: 0.5" href="profile.php">Welcome, <?= $auth->username ?></a>
                    <a class="text-decoration-none me-2 text-danger" href="_actions/logout.php">Logout</a>
                </div>
            <?php else: ?>
                <div>
                    <a class="text-decoration-none me-2" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    <a class="text-decoration-none" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="_actions/login.php" method="post">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="loginEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="_actions/register.php" method="post">
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">UserName</label>
                            <input type="text" name="username" class="form-control" id="registerUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="registerEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="registerPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPhone" class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control" id="registerPhone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>