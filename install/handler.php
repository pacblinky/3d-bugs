<?php
if (file_exists(__DIR__ . "./../config.php")) {
  die(header("Location: ./../"));
}
session_start();

function step2()
{
  global $errors;
  $errors = array();
  $db_host = trim($_POST["db_host"]);
  $db_port = trim($_POST["db_port"]);
  $db_username = $_POST["db_username"];
  $db_password = $_POST["db_password"];
  $db_name = $_POST["db_name"];
  if (empty($db_host) || empty($db_port) || empty($db_username) || empty($db_password) || empty($db_name)) {
    $errors[] = "Please fill out empty fields";
  } else {
    try {
      $db_host = $db_host . ":" . $db_port;
      $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $errors[] = "Connection failed: " . $e->getMessage();
      return;
    }
    $_SESSION["db_host"] = $db_host;
    $_SESSION["db_port"] = $db_port;
    $_SESSION["db_username"] = $db_username;
    $_SESSION["db_password"] = $db_password;
    $_SESSION["db_name"] = $db_name;
    $_SESSION["step2"] = true;
    header("Location: ./step3.php");
  }
}
if (isset($_POST["step2"])) {
  step2();
}

function step3()
{
  global $errors;
  $errors = array();
  $XF_KEY = $_POST["XF_KEY"];
  $XF_URL = $_POST["XF_URL"];
  $XF_username = $_POST["XF_username"];
  $XF_password = $_POST["XF_password"];
  $XF_database = $_POST["XF_database"];
  if (empty($XF_KEY) || empty($XF_URL) || empty($XF_username) || empty($XF_password) || empty($XF_database)) {
    $errors[] = "Please fill out empty fields";
  } else {
    if (strpos($XF_URL, "http://") !== false || (strpos($XF_URL, "https://") !== false)) {
      $_SESSION["XF_KEY"] = $XF_KEY;
      $_SESSION["XF_URL"] = $XF_URL;
      $_SESSION["XF_username"] = $XF_username;
      $_SESSION["XF_password"] = $XF_password;
      $_SESSION["XF_database"] = $XF_database;
      $_SESSION["step3"] = true;
      header("Location: ./final.php");
    } else {
      $errors[] = "Invalid URL: Please enter the full URL";
    }
  }
}
if (isset($_POST["step3"])) {
  step3();
}

function install($db_host, $db_username, $db_password, $db_name, $XF_KEY, $XF_URL, $XF_username, $XF_password, $XF_database)
{
  global $error;
  $db = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name, $db_username, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $tables =
    [
      "CREATE TABLE reports (
    report_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER,
    map_name VARCHAR(20) NOT NULL,
    entity_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    steps TEXT NOT NULL,
    expected TEXT NOT NULL,
    actual TEXT NOT NULL,
    status TINYINT NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)",

      "CREATE TABLE comments (
    comment_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    report_id INTEGER NOT NULL,
    action TINYINT NOT NULL,
    message TEXT NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)",

      "CREATE TABLE logs (
    log_id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    action TEXT NOT NULL,
    reason TEXT,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)",

      "CREATE TABLE attachments (
    report_id INTEGER NOT NULL,
    link TEXT NOT NULL)"
    ];
  try {
    foreach ($tables as $table) {
      $db->query($table);
    }
  } catch (PDOException $e) {
    $error = $e->getMessage();
  }
  $config_file = fopen("./../classes/Config.php", "w");
  $text = ("<?php\nclass Config\n{\nprotected static \$db_host = \"" . $db_host . "\";\n" . "protected static \$db_username = \"" . $db_username . "\";\n" . "protected static \$db_password = \"" . $db_password . "\";\n" . "protected static \$db_name = \"" . $db_name . "\";\n" . "protected static \$XF_API_KEY = \"" . $XF_KEY . "\";\n" . "protected static \$XF_API_URL = \"" . $XF_URL . "\";\n" . "protected static \$XF_SQLusername = \"" . $XF_username . "\";\n" . "protected static \$XF_SQLpassword = \"" . $XF_password . "\";\n" . "protected static \$XF_SQLdatabase = \"" . $XF_database . "\";\n" . "}\n?>");
  fwrite($config_file, $text);
  return true;
}
if (isset($_POST["final"])) {
  if (install($_SESSION["db_host"], $_SESSION["db_username"], $_SESSION["db_password"], $_SESSION["db_name"], $_SESSION["XF_KEY"], $_SESSION["XF_URL"], $_SESSION["XF_username"], $_SESSION["XF_password"], $_SESSION["XF_database"]) === true) {
    session_destroy();
    exit(header("Location: ./../"));
  }
}
