<?php

include('../functions/myfunction.php');

if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] != 1) {
        // Redirect to login page for non-admins
        redirect("../login.php", "You are not authorized to access this page");
    }
} else {
    // Redirect to login page if not logged in
    redirect("../login.php", "Login to continue");
}
