<?php
session_start();
if ($_SESSION['is_logged']) {
    $_SESSION['is_logged'] = false;
}

unset($_SESSION['is_logged']);
unset($_SESSION['logged_user']);
unset($_SESSION['access_level']);
session_destroy();
header("refresh:0; url=/webpages/login.html");