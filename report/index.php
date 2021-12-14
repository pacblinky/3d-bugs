<?php
session_start();
$_SESSION['last_visited'] = $_SERVER['REQUEST_URI'];
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
    <div id="message" class="alert" style="display: none;" role="alert"></div>
    <form method="post" id="new_report">
      <div class="mb-4">
        <label for="map_name" class="form-label">Map name</label>
        <input type="text" class="form-control" id="map_name" name="map_name" required>
      </div>
      <div class="mb-4">
        <label for="entity_id" class="form-label">Entity ID</label>
        <input type="text" class="form-control" id="entity_id" name="entity_id" required>
        <small id="entity_id" class="form-text text-muted">The map/entity unique id from maps page <a target="_blank" class="text-decoration-none" href="https://maps.3d-sof2.com/maps/entities">https://maps.3d-sof2.com/maps/entities</a></small>
      </div>
      <div class="mb-4">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
        <small id="title" class="form-text text-muted">In a few sentences describe what is your bug</small>
      </div>
      <div class="mb-4">
        <label for="steps" class="form-label">Steps to reproduce</label>
        <textarea class="form-control" id="steps" name="steps" required></textarea>
        <small id="steps" class="form-text text-muted">Step by step how to make the bug happen</small>
      </div>
      <div class="mb-4">
        <label for="expected" class="form-label">Excepted Result</label>
        <textarea class="form-control" name="expected" id="expected" required></textarea>
        <small id="expected" class="form-text text-muted">Describe what should happen if the bug didn't exist</small>
      </div>
      <div class="mb-4">
        <label for="actual" class="form-label">Actual Result</label>
        <textarea class="form-control" id="actual" name="actual" required></textarea>
        <small id="actual" class="form-text text-muted">Describe what actually happens if you follow your reproduction steps
        </small>
      </div>
      <div class="mb-4">
        <label for="attachments" class="form-label">Attachments (Optional)</label>
        <textarea class="form-control" id="attachments" name="attachments"></textarea>
        <small id="attachments_help" class="form-text text-muted">Add links to images/videos that describe the bug, seperate them by one space or new line</small>
      </div>
      <div class="d-grid gap-1">
        <button class="btn btn-success" type="submit">Submit</button>
        <br>
      </div>
    </form>
  </div>
  <script src="./../js/bootstrap-min.js"></script>
  <script src="./../js/jquery-3.6.0.min.js"></script>
  <script src="./../js/bugs.js"></script>
</body>

</html>