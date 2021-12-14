<?php
session_start();
unset($_SESSION["logged_in"]);
unset($_SESSION["user_id"]);
unset($_SESSION["access_level"]);
if(isset($_SESSION['last_visited'])){exit(header('location: '.$_SESSION['last_visited']));}
else{exit(header('location: ../'));}
