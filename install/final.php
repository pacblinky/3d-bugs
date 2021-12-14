<?php
require_once __DIR__."./handler.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="../../css/bootstrap-min.css">
</head>
<body class="bg-dark">
<div class="container-md">
<div class="d-grid gap-2 d-md-flex justify-content-md-center" style="margin-top: 15vh">
    <div class="card text-center" style="max-width: 100%;">
        <div class="card-header bg-primary text-white">Installation</div>
        <div class="card-body">
        <h5 class="card-title">Final Step: Confirmation</h5>
        <?php if(isset($error)){echo $error;}?>
        <br>
        <?php
        if($_SESSION["step2"] === true)
        {
            echo "<p class='text-success card-text'>Step 2: SQLServer Settings [SUBMITTED]</p>";
        }
        else
        {
            echo "<p class='text-danger card-text'>Step 2: SQLServer Settings [NOT SUBMITTED]</p>";
        }
        if($_SESSION["step3"] === true)
        {
            echo "<p class='text-success card-text'>Step 3: XenForo API [SUBMITTED]</p>";
        }
        else
        {
            echo "<p class='text-danger card-text'>Step 3: XenForo API [NOT SUBMITTED]</p>";
        }
        if($_SESSION["step2"] === true && $_SESSION["step3"] === true)
        {
        echo "<p class='card-text'><span class='fw-bold'>reports, comments, attachments and logs</span> tables will be created at <span class='fw-bold'>".$_SESSION["db_name"]."</span> database </p>";
        echo "<p class='card-text'><span class='fw-bold'>config.php</span> file will be created at the application directory in classes folder, you can change the settings from the file or delete the file to uninstall the application</p>";
        echo "<p class='card-text fw-bold text-primary'>Are you sure you want to proccess?</p>";
        echo "<form action='./final.php' method='post' id='form' role='form'>";
        echo "<button type='submit' name='final' class='btn btn-success' form='form'>Install</button>";
        }
        else
        {
        echo "<p class='card-text'>Please finish the missing required steps</p>";
        }
        ?>
        <a href='./step3.php' class='btn btn-primary' title='Go to the previous step'>Return</a>
        </div>
    </div>
    </div>
    </div>
    <script src="../../js/bootstrap-min.js"></script>
</body>
</html>
