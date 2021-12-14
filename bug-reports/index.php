<?php
session_start();
$_SESSION['last_visited'] = $_SERVER['REQUEST_URI'];
require __DIR__."./../classes/Report.php";
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
    <?php include __DIR__."./../header.php"; ?>
    <div class="container-md">
    <h5 class="fw-bold">You can find all bug reports down below</h5>
    <hr>
  </div>
  <div class="modal" id="edit" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="edit_menu_title" class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p style="display: none;" class="text-danger fw-bold text-center" id="error"></p>
            <form>
              <div class="mb-3">
                <label for="map_name" class="form-label">Map name</label>
                <input type="text" class="form-control" id="map_name" name="map_name" required>
              </div>
              <div class="mb-3">
                <label for="entity_id" class="form-label">Entity ID</label>
                <input type="text" class="form-control" id="entity_id" name="entity_id" required>
              </div>
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <div class="mb-3">
                <label for="steps" class="form-label">Steps to reproduce</label>
                <textarea class="form-control" id="steps" name="steps" required></textarea>
              </div>
              <div class="mb-3">
                <label for="expected" class="form-label">Excepted Result</label>
                <textarea class="form-control" name="expected" id="expected" required></textarea>
              </div>
              <div class="mb-3">
                <label for="actual" class="form-label">Actual Result</label>
                <textarea class="form-control" id="actual" name="actual" required></textarea>
              </div>
              <div>
                <label for="attachments" class="form-label">Attachments (Optional)</label>
                <textarea class="form-control" id="attachments" name="attachments"></textarea>
              </div>
              <input type="text" id="report_id" hidden readonly>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" onclick="editReport()" class="btn btn-success">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="delete" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="delete_menu_title" class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="card-text text-center fw-bold">Are you sure you want to do this?</p>
            <?php
            if($_SESSION["access_level"] === 3)
            {
              echo'
              <form>
              <div>
                <label for="reason" class="form-label">Reason (Optional)</label>
                <textarea class="form-control" id="reason" name="reason"></textarea>
              </div>
              <input type="text" id="report_id" hidden readonly>
            </form>';
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" onclick="deleteReport()" class="btn btn-success">Confirm</button>
          </div>
        </div>
      </div>
    </div>
<script src="./../js/bootstrap-min.js"></script>
<script src="./../js/jquery-3.6.0.min.js"></script>
<script src="./../js/bugs.js"></script>
</body>
</html>