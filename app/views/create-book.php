<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
?>

<section class="container-fluid">
    <div class="container text-center py-50">
    <form action="/api/books/addBook" method="post" class="book-management-form">
    <h1>Book Management</h1>
    
    <div class="form-group">
        <label for="title"><b>Book Title</b></label>
        <input type="text" placeholder="Enter Book Title" name="title" required>
    </div>

    <div class="form-group">
        <label for="author"><b>Author</b></label>
        <input type="text" placeholder="Enter Author Name" name="author" required>
    </div>

    <div class="form-group">
        <label for="genre"><b>Genre</b></label>
        <select name="genre" required class="mt-2 mb-3">
            <option value="" disabled selected>Select Genre</option>
            <option value="Fiction">Fiction</option>
            <option value="Non-Fiction">Non-Fiction</option>
            <option value="Science Fiction">Science Fiction</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Mystery">Mystery</option>
            <option value="Romance">Romance</option>
            <option value="Biography">Biography</option>
            <option value="History">History</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="stock"><b>Stock</b></label>
        <input type="number" class="mt-2 mb-3" placeholder="Enter Stock Quantity" name="stock" min="0" required>
    </div>

    <div class="form-group">
        <label for="price"><b>Price</b></label>
        <input type="number" class="mt-2 mb-3" placeholder="Enter Price" name="price" min="0" step="0.01" required>
    </div>

    <div class="form-group ">
        <label for="imageUrl"><b>Image</b></label>
        <input type="textbox" class="mt-2 mb-3" placeholder="Enter Image" name="imageUrl" min="0" step="0.01" >
    </div>
    
    
    <button type="submit" class="button-green">Submit</button>
</form>
    </div>
</section>

<?php
include __DIR__ . '/footer.php';
?>