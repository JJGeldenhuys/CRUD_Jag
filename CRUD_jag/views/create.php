<?php
// include the db config file 1234
require_once "dbConfig.php";

// Define the variables and initialize with empty values
$gameName = $gameCategory = $gamePrice = "";
$gameName_err = $gameCategory_err = $gamePrice_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Validate Game Name
    $input_name = trim($_POST["gameName"]);
    if (empty($input_name)) {
        $gameName_err = "Please enter a name";
    } elseif (
        !filter_var(
            $input_name,
            FILTER_VALIDATE_REGEXP,
            array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))
        )
    ) {
        $gameName_err = "Please enter a valid game name";
    } else {
        $gameName = $input_name;
    }

    //Validate Game Category
    $input_gameCategory = trim($_POST["gameCategory"]);
    if (empty($input_gameCategory)) {
        $gameCategory_err = "Please enter a game category";
    } elseif (
        !filter_var(
            $input_gameCategory,
            FILTER_VALIDATE_REGEXP,
            array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))
        )
    ) {
        $gameCategory_err = "Please enter a valid game category";
    } else {
        $gameCategory = $input_gameCategory;
    }
    //Validate Game Price

    $input_gamePrice = trim($_POST["gamePrice"]);
    if (empty($input_gamePrice)) {
        $gamePrice_err = "Please enter the Price of the game";
    } elseif (!ctype_digit($input_gamePrice)) {
        $gamePrice_err = "Please enter a positive number";
    } else {
        $gamePrice = $input_gamePrice;
    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <h2 class="mt-5">Create New Game Entry</h2>
                    </header>
                    <form action="<?php echo
                        htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Game Name</label>
                            <input type="text" name="gameName" class="form-control <?php echo
                                (!empty($gameName_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $gameName; ?>">
                            <span class="invalid-feedback">
                                <?php echo $gameName_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Game Category</label>
                            <textarea name="gameCategory"
                                class="form-control <?php echo (!empty($gameCategory_err)) ? 'is-invalid' : ''; ?>"><?php echo $gameCategory; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $gameCategory_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="gamePrice"
                                class="form-control <?php echo (!empty($gamePrice_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $gamePrice; ?>">
                            <span class="invalid-feedback">
                                <?php echo $gamePrice_err; ?>
                            </span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>