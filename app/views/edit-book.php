<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';

?>

<section class="container-fluid">
    <div class="container text-center py-50">
    <form action="/api/books/updateBook" method="post" class="book-management-form">
    <h1>Edit Book</h1>
    
    <input type="hidden" name="book_id" value="<?php echo $book->getBookId(); ?>">
    
    <div class="form-group">
        <label for="title"><b>Book Title</b></label>
        <input type="text" placeholder="Enter Book Title" name="title" value="<?php echo htmlspecialchars($book->getTitle()); ?>" required>
    </div>

    <div class="form-group">
        <label for="author"><b>Author</b></label>
        <input type="text" placeholder="Enter Author Name" name="author" value="<?php echo htmlspecialchars($book->getAuthor()); ?>" required>
    </div>

    <div class="form-group">
        <label for="genre"><b>Genre</b></label>
        <select name="genre" required class="mt-2 mb-3">
            <option value="" disabled>Select Genre</option>
            <option value="Fiction" <?php echo ($book->getGenre() == 'Fiction') ? 'selected' : ''; ?>>Fiction</option>
            <option value="Non-Fiction" <?php echo ($book->getGenre() == 'Non-Fiction') ? 'selected' : ''; ?>>Non-Fiction</option>
            <option value="Science Fiction" <?php echo ($book->getGenre() == 'Science Fiction') ? 'selected' : ''; ?>>Science Fiction</option>
            <option value="Fantasy" <?php echo ($book->getGenre() == 'Fantasy') ? 'selected' : ''; ?>>Fantasy</option>
            <option value="Mystery" <?php echo ($book->getGenre() == 'Mystery') ? 'selected' : ''; ?>>Mystery</option>
            <option value="Romance" <?php echo ($book->getGenre() == 'Romance') ? 'selected' : ''; ?>>Romance</option>
            <option value="Biography" <?php echo ($book->getGenre() == 'Biography') ? 'selected' : ''; ?>>Biography</option>
            <option value="History" <?php echo ($book->getGenre() == 'History') ? 'selected' : ''; ?>>History</option>
            <option value="Other" <?php echo ($book->getGenre() == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="stock"><b>Stock</b></label>
        <input type="number" class="mt-2 mb-3" placeholder="Enter Stock Quantity" name="stock" min="0" value="<?php echo $book->getStock(); ?>" required>
    </div>

    <div class="form-group">
        <label for="price"><b>Price</b></label>
        <input type="number" class="mt-2 mb-3" placeholder="Enter Price" name="price" min="0" step="0.01" value="<?php echo $book->getPrice(); ?>" required>
    </div>

    <div class="form-group ">
        <label for="imageUrl"><b>Image</b></label>
        <input type="textbox" class="mt-2 mb-3" placeholder="Enter Image" name="imageUrl" min="0" step="0.01" value="<?php echo $book->getImageUrl(); ?>" >
    </div>
    
    <button type="submit" class="button-green">Update Book</button>
</form>
    </div>
</section>

<?php
include __DIR__ . '/footer.php';
?>