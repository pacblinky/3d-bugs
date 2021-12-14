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
        <div class="d-grid gap-2 d-md-flex justify-content-md-center" style="margin-top: 10vh">
            <div class="card" style="max-width: 100%;">
                <div class="card-header bg-primary text-white text-center">Installation</div>
                <div class="card-body bg-white text-center">
                    <h5 class="card-title">Step 3: XenForo Settings</h5>
                    <?php
                    if (isset($errors)) {
                        foreach ($errors as $error) {
                            echo "<small class='text-danger card-text fw-bold'>$error</small><br>";
                        }
                    }
                    ?>
                    <form action="./step3.php" method="POST" role="form" id="form" style="padding-left: 5px;padding-right: 5px">
                        <div class="form-group row">
                            <label for="XF_KEY" class="row form-label">API Key:</label>
                            <input type="text" class="form-control" id="XF_KEY" name="XF_KEY" aria-describedby="APIHelpBlock" placeholder="Enter the XenForo API key" required>
                            <small id="APIHelpBlock" class="form-text text-muted row">The API key must be super-user key and have access to auth scope</small>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="XF_URL" class="form-label row">Forum URL:</label>
                            <input type="text" class="form-control" id="XF_URL" name="XF_URL" placeholder="Enter the XenForo forum URL" aria-describedby="APIHelpBlock2" required>
                            <small id="APIHelpBlock2" class="form-text text-muted row">You must enter the full URL, for example: https://forums.3d-sof2.com or http://ip:port</small>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="XF_username" class="form-label row">SQLServer Username:</label>
                            <input type="text" class="form-control" id="XF_username" name="XF_username" placeholder="Enter the SQL account username" aria-describedby="APIHelpBlock2" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="XF_password" class="form-label row">SQLServer Password:</label>
                            <input type="password" class="form-control" id="XF_password" name="XF_password" placeholder="Enter the SQL account password" aria-describedby="APIHelpBlock2" required>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="XF_database" class="form-label row">SQLServer Database:</label>
                            <input type="text" class="form-control" id="XF_database" name="XF_database" placeholder="Enter the database name where XenForo is stored" aria-describedby="APIHelpBlock2" required>
                        </div>
                        <br>
                        <button type="submit" name="step3" class="btn-success btn">Submit</button>
                        <a href="./step2.php" style="text-decoration: none;" title="Go to the previous step" class="btn btn-primary">Return</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap-min.js"></script>
</body>

</html>