<?php
if (file_exists(__DIR__ . "./../config.php")) {
  die(header("Location: ./../"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Requirements</title>
  <link rel="stylesheet" href="../css/bootstrap-min.css">
</head>

<body>

  <body class="bg-dark">
    <div class="container-md">
      <div class="d-grid gap-2 d-md-flex justify-content-md-center" style="margin-top: 20vh">
        <div class="card text-center" style="max-width: 100%">
          <div class="card-header bg-primary text-white">Installation</div>
          <div class="card-body">
            <h5 class="card-title">Step 1: Checking required PHP extensions before installing</h5>
            <br>
            <?php
            if (extension_loaded("pdo_mysql")) {
              echo '<p class="card-text text-success">PDO_MySQL [ENABLED]</p>';
            } else {
              echo '<p class="card-text text-danger">PDO_MySQL [NOT ENABLED]</p>';
            }
            if (extension_loaded("curl")) {
              echo '<p class="card-text text-success">cURL [ENABLED]</p>';
            } else {
              echo '<p class="card-text text-danger">cURL [NOT ENABLED]</p>';
            }
            if (extension_loaded("pdo_mysql") && extension_loaded("curl")) {
              echo '<p class="text-success">You meet all dependencies</p>';
              echo '<small>For linux/unix users please type in your terminal <code style="font-size: 15px;">chown www-data:www-data appliction_directory</code> to avoid permission problems</small><br><br>';
              echo '<a href="./step2.php" style="text-decoration: none;" class="btn-lg btn-success">Continue</a>';
            } else {
              echo '<p class="text-danger">You do not meet all dependencies</p>';
              echo '<p>Please enable/install disabled extensions, google it up if you do not know how';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <script src="../js/bootstrap-min.js"></script>
  </body>

</html>