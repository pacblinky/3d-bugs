<?php
require_once __DIR__ . "./handler.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation</title>
    <link rel="stylesheet" href="../css/bootstrap-min.css">
</head>

<body class="bg-dark">
    <div class="container-md">
        <div class="d-grid gap-2 d-md-flex justify-content-md-center" style="margin-top: 15vh">
            <div class="card" style="max-width: 100%;">
                <div class="card-header bg-primary text-white text-center">Installation</div>
                <div class="card-body text-center">
                    <h5 class="card-title">Step 2: SQLServer Settings</h5>
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo "<p class='text-danger card-text'>$error</p>";
                        }
                    }
                    ?>
                    <form action="./step2.php" method="POST" role="form" id="form" style="padding-left: 10px;padding-right: 10px;">
                        <div class="form-group row">
                            <label for="db_host" class="row form-label">SQLServer Host:</label>
                            <input type="text" name="db_host" id="db_host" class="form-control" placeholder="Enter the host of the SQL server" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="row form-label" for="db_port">SQLServer Port:</label>
                            <input type="text" name="db_port" id="db_port" class="form-control" placeholder="Enter the port of the SQL server" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="row form-label" for="db_username">SQLServer Username:</label>
                            <input type="text" name="db_username" id="db_username" class="form-control" placeholder="Enter the username of the SQL server account" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="row form-label" for="db_password">SQLServer Password:</label>
                            <input type="password" name="db_password" id="db_password" class="form-control" placeholder="Enter the password of the SQL server account" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="row form-label" for="db_name">SQLServer Database:</label>
                            <input type="text" name="db_name" id="db_name" class="form-control" placeholder="Enter the SQL database name where app's tables will be created" aria-describedby="databaseHelpBlock" required>
                            <small id="databaseHelpBlock" class="form-text text-muted row">The SQL account must have all privileges in this database</small>
                        </div>
                        <br>
                        <button type="submit" name="step2" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap-min.js"></script>
</body>

</html>