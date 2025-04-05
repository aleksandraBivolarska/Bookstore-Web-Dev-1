<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once __DIR__ . '/../services/OrderService.php';
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';

// Handle form submission for adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user'])) {
        echo "<script>alert('You must be logged in to add items to cart');</script>";
    } else {
        try {
            $bookId = (int)$_POST['book_id'];
            $user = unserialize($_SESSION['user']);
            $userId = (int)$user['user_id'];
            
            $orderService = new OrderService();
            $order = new Order(0, $userId, '', '', $bookId, '', '', 1);
            
            $result = $orderService->createOrder($order);
            
            if ($result) {
                echo "<script>alert('Book added to cart successfully!');</script>";
                $_SESSION['cart_count'] = ($_SESSION['cart_count'] ?? 0) + 1;
                
                // Reload books to reflect stock changes
                echo "<script>loadBooks();</script>";
            } else {
                echo "<script>alert('Failed to add book to cart - may be out of stock');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}
?>

<section class="container-fluid store-background image-headers">
    <div class="container text-center">
        
    </div>
</section>

<section class="container-fluid">
    <div class="container text-center">
        <!-- Search and Filter Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="p-3 filter-card">
                    <div class="row">
                        <!-- Keyword Search -->
                        <div class="col-md-6 pe-4">
                            <div class="form-group filtration">
                                <label for="keywordSearch"><b>Search Books</b></label>
                                <input type="text" id="keywordSearch" class="form-control" 
                                       placeholder="Title, author, etc...">
                            </div>
                        </div>
                        
                        <!-- Genre Filter -->
                        <div class="col-md-6 ps-4">
                            <div class="form-group filtration">
                                <label for="genreFilter"><b>Filter by Genre</b></label>
                                <select id="genreFilter" class="form-control">
                                    <option value="all">All Genres</option>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cards will be dynamically inserted here -->
        <div class="row" id="bookCardsContainer">
            <!-- Book cards will be added here by JavaScript -->
        </div>
    </div>
</section>

<script>
    let allBooks = []; // Store all books for filtering
    
    function loadBooks() {
        fetch('/api/books')
            .then(response => response.json())
            .then(books => {
                allBooks = books; // Store all books
                displayBooks(books); // Display all books initially
            })
            .catch(error => console.error("Error loading books:", error));
    }

    function displayBooks(books) {
        // Clear current books
        document.getElementById("bookCardsContainer").innerHTML = '';
        
        // Display each book
        books.forEach(book => {
            appendBook(book);
        });
    }

    function appendBook(book) {
        const bookCard = document.createElement("div");
        bookCard.classList.add("col-6", "col-md-6", "col-lg-3", "col-xl-2", "my-5");
        bookCard.setAttribute('data-genre', book.genre);
        bookCard.setAttribute('data-title', book.title.toLowerCase());
        bookCard.setAttribute('data-author', book.author.toLowerCase());

        // Display with Add to cart button when available
        let actionHtml = '';
        if (book.stock <= 0) {
            actionHtml = `<div class="text-muted mt-2 out-of-stock">Out of Stock</div>`;
        } else {
            actionHtml = `
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="book_id" value="${book.book_id}">
                    <button type="submit" name="add_to_cart" class="btn btn-add-to-cart mt-2">
                        Order book
                    </button>
                </form>
            `;
        }

        bookCard.innerHTML = `
            <div class="card text-center">
                <img src="${book.image || '/imgs/empty-book-img.png'}" 
                     class="img-fluid card-image" 
                     alt="${book.title}"
                     onerror="this.onerror=null;this.src='https://pngimg.com/d/book_PNG51088.png'">
                <div class="card-body p-2">
                    <h5 class="card-title mb-0">${book.title}</h5>
                    <p class="card-author mb-0 px-2">by ${book.author}</p>
                    <h3 class="card-price mb-0">€${book.price}</h3>
                    ${actionHtml}
                </div>
            </div>
        `;

        document.getElementById("bookCardsContainer").appendChild(bookCard);
    }

    function filterBooks() {
        const selectedGenre = document.getElementById('genreFilter').value;
        const searchTerm = document.getElementById('keywordSearch').value.toLowerCase();
        
        let filteredBooks = allBooks;
        
        if (selectedGenre !== 'all') {
            filteredBooks = filteredBooks.filter(book => book.genre === selectedGenre);
        }
        
        if (searchTerm) {
            filteredBooks = filteredBooks.filter(book => 
                book.title.toLowerCase().includes(searchTerm) || 
                book.author.toLowerCase().includes(searchTerm)
            );
        }
        
        displayBooks(filteredBooks);
    }

    // Initialize
    document.getElementById('genreFilter').addEventListener('change', filterBooks);
    document.getElementById('keywordSearch').addEventListener('input', filterBooks);
    loadBooks();
</script>

<style>
    /* Style for the filter section */
    .filter-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    
    #genreFilter, #keywordSearch {
        border: 2px solid #5D4037;
        padding: 10px;
        margin: 0px;
    }
    
    .form-group label {
        color: #5D4037;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .card-image {
        height: 200px;
        object-fit: contain;
        padding: 10px;
    }
    
    .card-title {
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 40px;
    }
    
    .card-author {
        font-size: 0.9rem;
        /* color: #6c757d; */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .card-price {
        color: #5D4037;
        font-weight: bold;
        font-size: 1.2rem;
    }
</style>

<?php
include __DIR__ . '/footer.php';
?>