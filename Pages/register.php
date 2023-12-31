<?php
include('../includes/header.php');
include('../includes/navbar.php');

// Include the User class and database configuration
require_once('../classes/User.php');
require_once('../config/database.php');




if ($_POST && isset($_POST['register'])) {

    // Create a new instance of the User class
    $user = new User($pdo);


    $user = trim($_POST['user']);
    $email = trim($_POST['email']);
    $password = ($_POST['password']);


    // Call the register() method to add the user to the database
    $resuilt = $username->register($user, $email, $password);

    if ($resuilt === true) {
        // If the registration was successful, redirect to the login page
        header('Location: login.php');
        exit;
    } else {
        // If there were errors, display them to the user
        $errors = $resuilt;
    }
}






?>
<section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 300px;
        "></div>
    <!-- Background image -->

    <div class="card mx-4 mx-md-5 shadow-5-strong" style="
        margin-top: -100px;
        background: hsla(0, 0%, 100%, 0.8);
        backdrop-filter: blur(30px);
        ">
        <div class="card-body py-5 px-md-5">

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-5">Sign up now</h2>
                    <?php if (isset($errors)) : ?>
                    <div class=" alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="user">username</label>
                            <input type="text" name="user" id="user" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include('../includes/footer.php')
?>