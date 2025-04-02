<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
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
                <div class="card p-3 filter-card">
                    <div class="row">
                        <!-- Keyword Search -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group filtration">
                                <label for="keywordSearch"><b>Search Books</b></label>
                                <input type="text" id="keywordSearch" class="form-control" 
                                       placeholder="Title, author, etc...">
                            </div>
                        </div>
                        
                        <!-- Genre Filter -->
                        <div class="col-md-6">
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

        // Check if book is in cart
        const cart = getCartItems();
        const cartItem = cart.find(item => item.book_id === book.book_id);
        const inCart = cartItem ? cartItem.quantity : 0;

        // Determine button HTML based on stock and cart status
        let buttonHtml;
        if (book.stock <= 0) {
            buttonHtml = `<button class="btn btn-out-of-stock mt-3" disabled>Out of Stock</button>`;
        } else if (inCart > 0) {
            buttonHtml = `
                <div class="quantity-controls d-flex justify-content-center align-items-center">
                    <button class="btn btn-sm btn-outline-secondary decrease-qty" 
                            data-book-id="${book.book_id}" ${inCart <= 1 ? 'disabled' : ''}>
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="mx-2 quantity-display">${inCart}</span>
                    <button class="btn btn-sm btn-outline-secondary increase-qty" 
                            data-book-id="${book.book_id}" ${inCart >= book.stock ? 'disabled' : ''}>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            `;
        } else {
            buttonHtml = `
                <button class="btn btn-add-to-cart mt-3" data-book-id="${book.book_id}">
                    Add to cart <i class="fas fa-shopping-cart"></i>
                </button>
            `;
        }

        bookCard.innerHTML = `
            <div class="card text-center">
                <img src="${book.image || '/imgs/empty-book-img.png'}" 
                     class="img-fluid card-image" 
                     alt="${book.title}"
                     onerror="this.onerror=null;this.src='https://pngimg.com/d/book_PNG51088.png'">
                <div class="card-body">
                    <h5 class="card-title">${book.title}</h5>
                    <p class="card-author px-3">by ${book.author}</p>
                    <h3 class="card-price">€${book.price}</h3>
                    ${buttonHtml}
                </div>
            </div>
        `;

        document.getElementById("bookCardsContainer").appendChild(bookCard);
        
        // Add event listeners
        if (book.stock > 0) {
            if (inCart > 0) {
                bookCard.querySelector('.decrease-qty').addEventListener('click', () => updateCartQuantity(book, -1));
                bookCard.querySelector('.increase-qty').addEventListener('click', () => updateCartQuantity(book, 1));
            } else {
                bookCard.querySelector('.btn-add-to-cart').addEventListener('click', () => addToCart(book));
            }
        }
    }

    function updateCartQuantity(book, change) {
        let cart = getCartItems();
        const itemIndex = cart.findIndex(item => item.book_id === book.book_id);
        
        if (itemIndex !== -1) {
            const newQuantity = cart[itemIndex].quantity + change;
            
            if (newQuantity <= 0) {
                cart.splice(itemIndex, 1);
            } else {
                cart[itemIndex].quantity = newQuantity;
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            displayBooks(allBooks); // Refresh display
        }
    }

    function addToCart(book) {
        let cart = getCartItems();
        const existingItem = cart.find(item => item.book_id === book.book_id);
        
        if (existingItem) {
            if (existingItem.quantity >= book.stock) {
                alert(`Only ${book.stock} available in stock!`);
                return;
            }
            existingItem.quantity += 1;
        } else {
            cart.push({
                order_item_id: Date.now(),
                book_id: book.book_id,
                title: book.title,
                price: book.price,
                image: book.image,
                quantity: 1
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        displayBooks(allBooks); // Refresh display to show quantity controls
    }

    function getCartItems() {
        return JSON.parse(localStorage.getItem('cart')) || [];
    }

    function updateCartCount() {
        const cart = getCartItems();
        const count = cart.reduce((total, item) => total + item.quantity, 0);
        const cartCountElement = document.getElementById('cartCount');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
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
    updateCartCount(); // Initialize cart count
</script>

<style>
    /* Style for the filter section */
    .filter-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    
    #genreFilter, #keywordSearch {
        border: 2px solid #5D4037;
        padding: 10px;
    }
    
    .form-group label {
        color: #5D4037;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    /* Quantity controls */
    .quantity-controls {
        margin-top: 1rem;
    }
    
    .quantity-display {
        min-width: 30px;
        text-align: center;
        font-weight: bold;
    }
    
    .btn-outline-secondary {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    .btn-add-to-cart {
        background-color: #5D4037;
        color: white;
    }
    
    .btn-add-to-cart:hover {
        background-color: #4a332b;
        color: white;
    }
    
    .btn-out-of-stock {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #6c757d;
        cursor: not-allowed;
    }
</style>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php
include __DIR__ . '/footer.php';
?>