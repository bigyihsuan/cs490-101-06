<?php
if ($_SESSION['is_logged']) {
    $_SESSION['is_logged'] = false;
}

unset($_SESSION['logged_user']);