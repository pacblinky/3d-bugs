<?php
session_start();
if (isset($_SESSION["logged_in"])) {
    exit(header("Location: ../"));
} else {
    require __DIR__ . "./../classes/XenAPI.php";
    if (empty($_POST["login"]) || empty($_POST["password"])) {
        $error = "Fill out empty fields";
    } else {
        $user = XenApi::authenticate($_POST["login"], $_POST["password"]);
        if ($user !== false && sizeof($user) > 0) {
            $medium_access = array("8", "10");
            $high_access = array("7", "5", "6", "9");
            $low_access = array("8", "10", "11");
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user["member_id"];
            $_SESSION["timezone"] = $user["timezone"];
            if (in_array($user["member_group_id"], $low_access)) {
                $_SESSION["access_level"] = 1;
            } elseif (in_array($user["member_group_id"], $medium_access)) {
                $_SESSION["access_level"] = 2;
            } elseif (in_array($user["member_group_id"], $high_access)) {
                $_SESSION["access_level"] = 3;
            } else {
                $_SESSION["access_level"] = 0;
            }
            if (isset($_SESSION['last_visited'])) {
                header('location: ' . $_SESSION['last_visited']);
            } else {
                header('location: ../');
            }
        } else {
            $error = "You have entered an invalid username/email or password";
        }
    }
}
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
        <h4 class="text-center fw-bold">Log in with your 3D# Community account</h4>
        <br>
        <div class="mb-4">
            <form method="post" id="form" action="./" role="form">
                <label for="login" class="form-label">Username / Email</label>
                <input type="text" class="form-control" id="login" placeholder="Your account username or email" name="login" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Your account password" name="password" required>
        </div>
        <?php
        if (isset($_POST["action"]) && isset($error)) {
            echo '<div class="container">';
            echo '<div class="alert alert-danger alert-dismissible" role="alert">' . $error . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>';
        }
        ?>
        <div class="d-grid gap-1">
            <button class="btn btn-success" name="action" value="login" type="submit">Submit</button>
        </div>
        </form>
    </div>
    <script src="./../js/bootstrap-min.js"></script>
</body>

</html>