<?php
session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already logged in";
    header('Location: index.php');
    exit();
}

include('includes/header.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
                    foreach ($_SESSION['errors'] as $error) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                    }
                    unset($_SESSION['errors']);
                }
                ?>
                <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['message']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Registration form</h4>
                    </div>
                    <div class="card-body">
                        <form action="functions/authcode.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your First name" id="firstNameInput" name="first_name" oninput="generateUsername()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your Last name" id="lastNameInput" name="last_name" oninput="generateUsername()">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="username-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Enter a username" id="usernameInput" name="username" aria-describedby="username-addon">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" placeholder="Enter your email" id="emailInput" name="email" aria-describedby="emailHelp" oninput="generateUsername()">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone number</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+251</span>
                                    <input type="tel" class="form-control" placeholder="Enter your Phone Number" name="phone" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Enter your password" name="password" id="exampleInputPassword1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Repeat Password</label>
                                <input type="password" class="form-control" placeholder="Repeat your password" name="cpassword">
                            </div>
                            <button type="submit" class="btn btn-primary" name="register_btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="assets/js/generateUsername.js"></script>