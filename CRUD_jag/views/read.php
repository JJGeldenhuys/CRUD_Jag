<?php
//Check if game id exists
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include the database config file
    require_once "dbConfig.php";

    // Prepare the Select statement
    $sqlstatement = "SELECT * FROM games WHERE id=?";

    if ($stmt = $mysqli->prepare($sqlstatement)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $gameName = $row["gameName"];
                $gameCategory = $row["gameCategory"];
                $gamePrice = $row["gamePrice"];
            } else {
                header("location:error.php");
                exit();
            }
        } else {
            echo "Woops! Something went wrong.Please try again later.";
        }
        //Close statement
        $stmt->close();

        //Close connection
        $mysqli->close();
    } else {
        header("location:error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Games</h1>
                    <div class="form-group">
                        <label>Game Name</label>
                        <p><b>
                                <?php echo $row["gameName"]; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Game Category</label>
                        <p><b>
                                <?php echo $row["gameCategory"]; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Game Price</label>
                        <p><b>
                                <?php echo $row["gamePrice"]; ?>
                            </b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>