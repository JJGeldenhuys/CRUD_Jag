<?php
header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    .wrapper {
        width: 600px;
        margin: 0 auto;
    }

    table tr td:last-child {
        width: 120px;
    }
    </style>
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h1>Dashboard</h1>
                        <h2 class="pull-left">Games List</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New
                            Game</a>
                    </div>
                    <?php

                    $s = "";
                    $user_role;

                    $sql = "SELECT * FROM games";
                    if ($result = $mysqli->query($sql)) {
                        if ($result->num_rows > 0) {
                            $s .= '<table class="table table-bordered table-striped">';
                            $s .= "<thead>";
                            $s .= "<tr>";
                            $s .= "<th>#</th>";
                            $s .= "<th>Game Name</th>";
                            $s .= "<th>Game Category</th>";
                            $s .= "<th>Price</th>";
                            $s .= "<th>Action</th>";
                            $s .= "</tr>";
                            $s .= "</thead>";
                            $s .= "<tbody>";
                            while ($row = $result->fetch_array()) {
                                $s .= "<tr>";
                                $s .= "<td>" . $row['id'] . "</td>";
                                $s .= "<td>" . $row['gameName'] . "</td>";
                                $s .= "<td>" . $row['gameCategory'] . "</td>";
                                $s .= "<td>" . "R:" . $row['gamePrice'] . "</td>";
                                $s .= "<td>";
                                $s .= '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                if ($user_role == 'admin') {
                                    $s .= '<a href="edit.php?id=' . $row['id'] . '" class="mr-3" title="Edit Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    $s .= '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                }
                                $s .= "</td>";
                                $s .= "</tr>";
                            }
                            $s .= "</tbody>";
                            $s .= "</table>";


                            echo $s;
                            $result->free();
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>