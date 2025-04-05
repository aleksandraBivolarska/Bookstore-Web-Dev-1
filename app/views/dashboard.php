<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
require_once '../models/user.php';


if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $userName = $user['first_name'];
}
?>

<section class="container-fluid dahsboard-header image-headers">
    <div class ="container">
    </div>
</section>

<section class="container-fluid py-100">
    <div class ="container text-center">
        <div class="row justify-content-center">
        <h1>Welcome back <?= isset($user) ? htmlspecialchars($userName) : 'User' ?>!</h1>        
        <p class="col-8 pt-4">
            Your Next Great Read is Just a Click Away! Dive into a world of books with new releases, and top-rated titles. 
            Stay on top of upcoming events, manage your reading lists, and enjoy a seamless browsing experience.
        </p>
        </div>
    </div>
</section>

<section class="container-fluid pb-5">
        <div class="row">
        <img src="/imgs/intro-book-1.jpg" class="img-fluid pb-3 pb-md-0 col-12 col-md-4 dashboard-images">
        <img src="/imgs/intro-book-2.jpg" class="img-fluid pb-3 pb-md-0 col-12 col-md-4 dashboard-images">
        <img src="/imgs/intro-book-3.jpg" class="img-fluid pb-3 pb-md-0 col-12 col-md-4 dashboard-images">
        </div>
</section>

<?
include __DIR__ . '/footer.php';