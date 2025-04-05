<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
?>

<section class="container-fluid">
    <div class="container py-5">
        <h1 class="text-center mb-4">Your Shopping Cart</h1>
        
        <div id="cartItemsContainer" class="row">
            <!-- Cart items will be loaded here -->
        </div>
        
        <div class="text-center mt-4">
            <button id="checkoutBtn" class="btn btn-primary btn-lg">Proceed to Checkout</button>
            <button id="clearCartBtn" class="btn btn-danger btn-lg ms-3">Clear Cart</button>
        </div>
    </div>
</section>

<script>
    function loadCartItems() {
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cartItemsContainer');
        
        if (cartItems.length === 0) {
            container.innerHTML = '<p class="text-center">Your cart is empty</p>';
            return;
        }
        
        let html = '';
        let total = 0;
        
        cartItems.forEach(item => {
            total += item.price * item.quantity;
            
            html += `
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="${item.image || '/imgs/empty-book-img.png'}" 
                                     class="img-fluid rounded-start" 
                                     alt="${item.title}"
                                     style="height: 200px; object-fit: contain;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${item.title}</h5>
                                    <p class="card-text">Price: €${item.price.toFixed(2)}</p>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <button class="btn btn-sm btn-outline-secondary decrease-qty" 
                                                data-id="${item.order_item_id}" ${item.quantity <= 1 ? 'disabled' : ''}>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span class="mx-3 quantity-display">${item.quantity}</span>
                                        <button class="btn btn-sm btn-outline-secondary increase-qty" 
                                                data-id="${item.order_item_id}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                    <p class="card-text">Subtotal: €${(item.price * item.quantity).toFixed(2)}</p>
                                    <button class="btn btn-sm btn-danger remove-item" data-id="${item.order_item_id}">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-end">Total: €${total.toFixed(2)}</h3>
                    </div>
                </div>
            </div>
        `;
        
        container.innerHTML = html;
        
        // Add event listeners
        document.querySelectorAll('.increase-qty').forEach(button => {
            button.addEventListener('click', (e) => {
                const itemId = parseInt(e.target.closest('button').getAttribute('data-id'));
                updateQuantity(itemId, 1);
            });
        });
        
        document.querySelectorAll('.decrease-qty').forEach(button => {
            button.addEventListener('click', (e) => {
                const itemId = parseInt(e.target.closest('button').getAttribute('data-id'));
                updateQuantity(itemId, -1);
            });
        });
        
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (e) => {
                const itemId = parseInt(e.target.closest('button').getAttribute('data-id'));
                removeFromCart(itemId);
            });
        });
    }
    
    function updateQuantity(itemId, change) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const itemIndex = cart.findIndex(item => item.order_item_id === itemId);
        
        if (itemIndex !== -1) {
            cart[itemIndex].quantity += change;
            
            // Remove item if quantity reaches 0
            if (cart[itemIndex].quantity <= 0) {
                cart.splice(itemIndex, 1);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCartItems();
            updateCartCount();
        }
    }
    
    function removeFromCart(itemId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(item => item.order_item_id !== itemId);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCartItems();
        updateCartCount();
    }
    
    // Clear cart button
    document.getElementById('clearCartBtn').addEventListener('click', () => {
        if (confirm('Are you sure you want to clear your cart?')) {
            localStorage.removeItem('cart');
            loadCartItems();
            updateCartCount();
        }
    });
    
    // Load cart items when page loads
    loadCartItems();

    // Add this to your shopping-cart view's script section
document.getElementById('checkoutBtn').addEventListener('click', () => {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (cartItems.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    // Prepare the data to send
    const orderData = {
        items: cartItems.map(item => ({
            book_id: item.book_id,
            quantity: item.quantity
        }))
    };

    // Send the order to the server
    fetch('/api/orders/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to create order');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Clear the cart after successful order
            localStorage.removeItem('cart');
            updateCartCount();
            
            // Redirect to a thank you page or orders page
            window.location.href = '/order';
        } else {
            throw new Error('Order creation failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error processing your order. Please try again.');
    });
});
</script>

<!-- Add Font Awesome for the icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .card {
        height: 100%;
    }
    .quantity-display {
        min-width: 30px;
        text-align: center;
    }
    .btn-outline-secondary {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<?php
include __DIR__ . '/footer.php';
?>