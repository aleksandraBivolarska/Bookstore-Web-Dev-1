function updateCartItemQuantity(itemId, newQuantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const itemIndex = cart.findIndex(item => item.order_item_id === itemId);
    
    if (itemIndex !== -1) {
        if (newQuantity <= 0) {
            cart.splice(itemIndex, 1); // Remove if quantity is 0 or less
        } else {
            cart[itemIndex].quantity = newQuantity;
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        return true;
    }
    return false;
}

function addToCart(book) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Check if book already exists in cart
    const existingItem = cart.find(item => item.book_id === book.book_id);
    
    if (existingItem) {
        // Don't exceed available stock
        if (existingItem.quantity >= book.stock) {
            alert(`Only ${book.stock} available in stock!`);
            return;
        }
        existingItem.quantity += 1;
    } else {
        cart.push({
            order_item_id: Date.now(), // temporary unique ID
            book_id: book.book_id,
            title: book.title,
            price: book.price,
            image: book.image,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert(`${book.title} added to cart!`);
}