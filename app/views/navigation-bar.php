<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once '../models/user.php';
$isUserAdmin = false;

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $userRole = $user['role'];
    $userId = $user['user_id'];

    if($userRole === 'admin'){
      $isUserAdmin = true;
    }else{
      $isUserAdmin = false;
    }
}
?>

<nav class="navbar navbar-expand-lg bg-zeus">
  <div class="container-fluid">
    <a class="navbar-brand color-white" href="dashboard">
      <img src="/imgs/book-favicon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-center">
      Bookstore
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-3">
          <a class="nav-link active" aria-current="page" href="dashboard">Home</a>
        </li>

        <?php if (!$isUserAdmin): ?>
        <li class="nav-item px-3">
          <a class="nav-link active" aria-current="page" href="store">Books</a>
        </li>
        <?php endif; ?>

        <?php if ($isUserAdmin): ?>
        <li class="nav-item px-3">
          <a class="nav-link active" aria-current="page" href="book-management">Manage Books</a>
        </li>
        <?php endif; ?>

       
        <?php if (!$isUserAdmin): ?>
            <li class="nav-item px-3">
              <a class="nav-link active" aria-current="page" href="order">My Orders</a>
            </li>
        <?php endif; ?>

          <?php if ($isUserAdmin): ?>
            <li class="nav-item px-3">
              <a class="nav-link active" aria-current="page" href="order">All Orders</a>
            </li>
        <?php endif; ?>

        <li class="nav-item px-3">
          <a class="nav-link" href="logout" onclick="return handleLogout()">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function handleLogout() {
    localStorage.removeItem('cart');
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
    return true;
  }

</script>