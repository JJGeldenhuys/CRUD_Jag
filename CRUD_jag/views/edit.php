<?php
//include the database config file
require_once "dbConfig.php";

//Define the variables and initialize them with empty values
$gameName = $gameCategory = $gamePrice = "";
$gameName_err = $gameCategory_err = $gamePrice_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    //Get the hidden input value which will be gameID
    $id = $_POST["id"];

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

    //Check input errors before inserting into the database
    if (empty($gameName_err) && empty($gameCategory_err) && empty($gamePrice_err)) {
        // prepare the update statement
        $sqlstatement = "UPDATE games SET gameName=? , gameCategory=?,gamePrice=? WHERE id=?";

        if ($stmt = $mysqli->prepare($sqlstatement)) {
            // Bind the variables to the prepared statement as parameters
            $stmt->bind_param("sssi", $param_gameName, $param_gameCategory, $param_gamePrice, $param_gameID);

            // Set parameters
            $param_gameName = $gameName;
            $param_gameCategory = $gameCategory;
            $param_gamePrice = $gamePrice;
            $param_gameID = $id;

            if ($stmt->execute()) {
                header("location:index.php");
                exit();
            } else {
                echo "Woops! Something went wrong.Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    //close connection
    $mysqli->close();
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sqlstatement = "SELECT * FROM games WHERE id = ?";
        if ($stmt = $mysqli->prepare($sqlstatement)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $gameID = $row["id"];
                    $gameCategory = $row["gameCategory"];
                    $gamePrice = $row["gamePrice"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Woops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();

        // Close connection
        $mysqli->close();
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
                    <h2 class="mt-5">Edit Game</h2>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label> Game Name</label>
                            <input type="text" name="gameName"
                                class="form-control <?php echo (!empty($gameName_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $gameName; ?>">
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
                            <label>Game Price</label>
                            <input type="text" name="gamePrice"
                                class="form-control <?php echo (!empty($gamePrice_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $gamePrice; ?>">
                            <span class="invalid-feedback">
                                <?php echo $gamePrice_err; ?>
                            </span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>