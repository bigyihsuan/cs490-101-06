<?php
session_start();
if ($_SESSION['is_logged']) {
    $_SESSION['is_logged'] = false;
}

unset($_SESSION['logged_user']);
session_destroy();
header("refresh:0; url=/login.html");