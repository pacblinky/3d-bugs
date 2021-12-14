<?php
session_start();
if ($_SESSION["access_level"] !== 3) {
  exit(header("Location: ../"));
}
date_default_timezone_set($_SESSION["timezone"]);
require __DIR__ . "./../classes/Logger.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3D# Bugs</title>
  <meta name="apple-mobile-web-app-title" content="3D# Bugs">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="3D# Bugs">
  <link rel="stylesheet" href="../css/bootstrap-min.css">
</head>

<body>
  <?php include __DIR__ . "./../header.php"; ?>
  <div class="container">
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th scope="col">ID #</th>
          <th scope="col">Date</th>
          <th scope="col">Action</th>
          <th scope="col">By</th>
          <th scope="col">Reason</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $logs = Logger::getLogs();
        foreach ($logs as $log) {
          echo '<tr>
      <th scope="row">' . $log->getLog_id() . '</th>
      <td>' . date("Y/m/d h:i A", strtotime($log->getCreation_date())) . '</td>
      <td>' . $log->getAction() . '</td>
      <td>' . htmlentities(Database::getUsername($log->getUser_id())) . '</td>
      <td>' . htmlentities($log->getReason()) . '</td>
    </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="./../js/bootstrap-min.js"></script>
</body>

</html>