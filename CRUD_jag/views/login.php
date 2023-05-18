<?php
/* perform auth
 * if successful redirect to dashboard
 * else stay on login
 * set up links to register
 */

require "admin/modules/userModules.php";

$msg = '';
$user = new User();
if (isset($_POST['submit'])) {
    extract($_POST);
    $user->setUsername($username, $dbConnection);
    $user->setPassword($password, $dbConnection);
    $login = $user->login();
    if ($login) {
        header("location:index.php");
    } else {
        $msg = 'Wrong username or password';
        session_destroy();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="row">
        <div class="col-lg-12">
            <h2>Login</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php if (!empty($msg)) {
                echo '<div class="alert alert-danger">Wrong username or password</div>';
            } ?>
        </div>
    </div>
    <title>Login Form</title>
</head>

<body>
    <header>
        <h1>Login Page</h1>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post" name="login">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-key"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="******">
                </div>

                <button type="submit" name="submit" class="float-right btn btn-primary">Login</button>
                <a href="<?php print SITE_URL; ?>./views/registration.php">Register</a>
            </form>
        </div>
    </div>
</body>

</html>

<?php
//include('templates/footer.php');
?>