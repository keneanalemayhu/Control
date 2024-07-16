<?php
session_start();
include('includes/header.php'); ?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                <?php if (isset($_SESSION['auth_user']['name'])) : ?>
                    <h1>Hello, <?= $_SESSION['auth_user']['name']; ?>! <i class="fa fa-user"></i></h1>
                <?php else : ?>
                    <h1>Hello, Guest! <i class="fa fa-user"></i></h1>
                <?php endif; ?>
                <button class="btn btn-primary">test</button>
                <?php if (isset($_SESSION['auth'])) : ?>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>