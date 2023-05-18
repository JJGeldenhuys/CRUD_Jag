<?php
//include('views/header.php');
?>
<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" name="reg">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                </div>
                <input type="text" name="username" class="form-control" placeholder="username">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-key"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="******">
            </div>
            <button type="submit" name="submit" class="float-right btn btn-primary">Register</button>
            <a href="<?php print SITE_URL; ?>login.php">Already registered? Click Here!</a>
        </form>
    </div>
</div>
<?php
//include('templates/footer.php');
?>