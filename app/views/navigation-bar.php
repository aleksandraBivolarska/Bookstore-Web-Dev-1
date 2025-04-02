<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once '../models/user.php';
$isUserAdmin = false;

if (isset($_SESSION['user'])) {
    // Unserialize the session data into an object
    $user = unserialize($_SESSION['user']);
    $userRole = $user['role'];

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
          <li class="nav-item dropdown px-3 bg-zeus">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              My Orders
            </a>
            
            <ul class="dropdown-menu bg-zeus">
              <li><a class="dropdown-item" href="shopping-cart">Shopping Cart</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="order">Past Orders</a></li>
            </ul>
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
    // Clear the cart from localStorage
    localStorage.removeItem('cart');
    // You might also want to update the cart count display if it exists
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
    // Proceed with the normal logout process
    return true; // Allow the link to proceed
  }

  
  
</script>