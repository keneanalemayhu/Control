<?php

session_start();
include("../config/dbcon.php");
include("myfunction.php");

if (isset($_POST["register_btn"])) {
    $firstName = mysqli_real_escape_string($con, $_POST["first_name"]);
    $lastName = mysqli_real_escape_string($con, $_POST["last_name"]);
    $name = $firstName . ' ' . $lastName; // Concatenate first and last name
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $phone = mysqli_real_escape_string($con, $_POST["phone"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $cpassword = mysqli_real_escape_string($con, $_POST["cpassword"]);

    // Store form values in session
    $_SESSION['first_name'] = $firstName;
    $_SESSION['last_name'] = $lastName;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    // Initialize an array to store error messages
    $errors = array();

    // Check if email already registered
    $check_email_query = "SELECT email FROM users WHERE email='$email' ";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    // Check if username already registered
    $check_username_query = "SELECT username FROM users WHERE username='$username' ";
    $check_username_query_run = mysqli_query($con, $check_username_query);

    // Check if phone number already registered
    $check_phone_query = "SELECT phone FROM users WHERE phone='$phone' ";
    $check_phone_query_run = mysqli_query($con, $check_phone_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $errors[] = "Email already registered";
    }

    if (mysqli_num_rows($check_username_query_run) > 0) {
        $errors[] = "Username already registered";
    }

    if (mysqli_num_rows($check_phone_query_run) > 0) {
        $errors[] = "Phone number already registered";
    }

    if ($password != $cpassword) {
        $errors[] = "Passwords do not match";
    }

    // If there are any errors, redirect back to registration page with error messages
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../register.php');
    } else {
        // Insert user data
        $insert_query = "INSERT INTO users (name, username, email, phone, password) VALUES ('$name', '$username', '$email', '$phone', '$password')";
        $insert_query_run = mysqli_query($con, $insert_query);

        if ($insert_query_run) {
            $_SESSION['message'] = "Registered Successfully";
            header('Location: ../login.php');
        } else {
            $_SESSION['message'] = "Something went wrong!";
            header('Location: ../register.php');
        }
    }
} else if (isset($_POST['login_btn'])) {
    $login_identifier = mysqli_real_escape_string($con, $_POST['login_identifier']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check if login identifier matches username, email, or phone number
    $login_query = "SELECT * FROM users WHERE (username='$login_identifier' OR email='$login_identifier' OR phone='$login_identifier') AND password='$password' ";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $user_id = $userdata['id'];
        $user_name = $userdata['name'];
        $user_email = $userdata['email'];
        $role_as = $userdata['role_as'];

        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'name' => $user_name,
            'email' => $user_email,
        ];

        $_SESSION['role_as'] = $role_as;

        if ($role_as == 1) {
            redirect("../admin/index.php", "Welcome To Control");
        } else {
            redirect("../index.php", "Logged In Successfully!");
        }
    } else {
        redirect("../login.php", "Invalid Credentials");
    }
}
