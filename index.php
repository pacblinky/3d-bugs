<?php
if (!file_exists("./classes/Config.php")) {
  exit(header("Location: ./install/"));
}
session_start();
if (isset($_SESSION["timezone"])) {
  date_default_timezone_set($_SESSION["timezone"]);
}
$_SESSION['last_visited'] = $_SERVER['REQUEST_URI'];
require __DIR__ . "./classes/Report.php";
$reports = Report::getReports(0);
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
  <link rel="stylesheet" href="./css/bootstrap-min.css">
</head>

<body>
  <?php include __DIR__ . "./header.php"; ?>
  <div class="container-md">
    <h5 class="fw-bold">You can find all pending reports down below</h5>
    <small>or you can report a new bug from <a class="text-decoration-none" href="./report/">here</a></small>
    <hr>
    <?php
    if($reports != false):
      foreach($reports as $report):
    ?>
    <div class="card w-100 bg-dark" id="<?php echo $report->getReport_id() ?>" style="margin-bottom: 1.5rem;">
      <div style="background-color: #6C757D; font-size: large;" class="card-header text-white text-center">Map: <span data-target="map"><?php echo htmlentities($report->getMap_name()) . ' #' . htmlentities($report->getEntity_id()) ?></span></div>
      <div class="card-body">
        <h5 data-target="title" class="card-title text-center text-white"><?php echo htmlentities($report->getTitle()) ?></h4>
          <br>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <p class="card-text fw-bold col">Steps:<br><span data-target="steps" style="white-space: pre-wrap" class="fw-light fs-6 col"><?php echo htmlentities($report->getSteps()) ?></span></p>
            </li>
            <li class="list-group-item">
              <p class="card-text fw-bold col">Expected Results:<br><span data-target="expected" style="white-space: pre-wrap" class="fw-light fs-6 col"><?php echo htmlentities($report->getExpected()) ?></span></p>
            </li>
            <li class="list-group-item">
              <p class="card-text fw-bold col">Actual Results:<br><span data-target="actual" style="white-space: pre-wrap" class="fw-light fs-6 col"><?php echo htmlentities($report->getActual()) ?></span></p>
            </li>
            <li id="attachment" style="<?php if(!is_array($report->getAttachments())){echo "display: none;";}?>" class="list-group-item"><p class="card-text fw-bold col">Attachments:<br><span data-target="attachments" style="white-space: pre-wrap" class="fw-light fs-6 col"><?php if(is_array($report->getAttachments())){$report->anchors();}?></span></p>
        </li>    
            </ul>
            <br>
            <p class="text-white card-text col">Status: <span style="color: #D3D3D3">Pending</span></p>
            <p class="card-text col text-white">Report ID: #<?php echo $report->getReport_id() . ' - ' . date("Y/m/d h:i A", strtotime($report->getCreation_date())) ?></p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
              <?php
              if ($_SESSION["user_id"] == $report->getUser_id() && $_SESSION["logged_in"] === true) {
                echo '<button id="edit_modal" onclick="editMenu(' . $report->getReport_id() . ')" class="btn btn-primary">Edit</button>';
              }
              echo '<a href="./reports/?report='.$report->getReport_id().'" class="btn btn-success">View</a>';
              if ($_SESSION["logged_in"] === true && $_SESSION["user_id"] == $report->getUser_id() || $_SESSION["access_level"] === 3) {
                echo '<button onclick="deleteMenu(' . $report->getReport_id() . ')" class="btn btn-danger">Delete</button>';
              }
              ?>
            </div>
      </div>
    </div>
  <?php endforeach; endif?>
  </div>
  <div class="modal" id="edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-white bg-dark">
        <div class="modal-header">
          <h5 id="edit_title" class="modal-title"></h5>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p style="display: none" class="text-danger fw-bold text-center" id="message"></p>
          <form id="edit_report" method="post">
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
            <input type="text" id="id" name="report_id" hidden readonly>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save changes</button>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-white bg-dark">
        <div class="modal-header">
          <h5 id="delete_title" class="modal-title"></h5>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="card-text text-center fw-bold">Are you sure you want to do this?</p>
          <form id="delete_report" method="post">
            <?php
            if ($_SESSION["access_level"] === 3) {
              echo '
              <div>
                <label for="reason" class="form-label">Reason (Optional)</label>
                <textarea class="form-control" id="reason" name="reason"></textarea>
              </div>';
            }
            ?>
            <input type="text" id="report_id" name="report_id" hidden readonly>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Confirm</button>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <script src="./js/bootstrap-min.js"></script>
  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/bugs.js"></script>
</body>

</html>