<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
?>



<?php if (!$isUserAdmin): ?>
    <section class="container-fluid order-background image-headers">
    <div class="container text-center">
        
    </div>
</section>        
<?php endif; ?>

<?php if (!$isUserAdmin): ?>
    <h1 class="text-center py-50">Previous Orders</h1>    
<?php endif; ?>

<?php if ($isUserAdmin): ?>
<section class="container-fluid">
    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card p-3 filter-card">
                    <div class="row">
                        <!-- Keyword Search -->
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group filtration">
                                <label for="keywordSearch"><b>Search Orders</b></label>
                                <input type="text" id="keywordSearch" class="form-control" 
                                       placeholder="Customer name, book title...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<section class="container-fluid">
    <div class="container">
        
        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-striped" id="ordersTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Customer</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <!-- Orders will be inserted here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    let allOrders = []; // Store all orders for filtering
    
    function loadOrders() {
        fetch('/api/orders')
            .then(response => response.json())
            .then(orders => {
                allOrders = orders; // Store all orders
                displayOrders(orders); // Display all orders initially
            })
            .catch(error => console.error("Error loading orders:", error));
    }

    function displayOrders(orders) {
        const tableBody = document.getElementById("ordersTableBody");
        tableBody.innerHTML = '';
        
        // Display each order
        orders.forEach(order => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${order.user_first_name} ${order.user_last_name}</td>
                <td>${order.book_title}</td>
                <td>${order.book_author}</td>
                <td>${order.quantity}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    function filterOrders() {
        const searchTerm = document.getElementById('keywordSearch').value.toLowerCase();
        
        let filteredOrders = allOrders;
        
        if (searchTerm) {
            filteredOrders = allOrders.filter(order => 
                order.first_name.toLowerCase().includes(searchTerm) || 
                order.title.toLowerCase().includes(searchTerm) ||
                order.author.toLowerCase().includes(searchTerm)
            );
        }
        
        displayOrders(filteredOrders);
    }

    // Initialize
    document.getElementById('keywordSearch').addEventListener('input', filterOrders);
    loadOrders();
</script>

<style>
    /* Style for the filter section */
    .filter-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    
    #keywordSearch {
        border: 2px solid #5D4037;
        padding: 10px;
    }
    
    .form-group label {
        color: #5D4037;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    /* Table styles */
    .table {
        margin-top: 20px;
    }
    
    .thead-dark th {
        background-color: #5D4037;
        color: white;
    }
</style>

<?php
include __DIR__ . '/footer.php';
?>