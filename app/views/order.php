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
    <h1 class="text-center py-50">My Orders</h1>    
<?php endif; ?>

<?php if ($isUserAdmin): ?>
<section class="container-fluid">
    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row justify-content-between">
        <div class="col-md-6 pt-5">
            <h1>Orders Overview</h1>
        </div>
            <div class="col-md-6">
                <div class="card pt-5 filter-card">
                    <div class="row justify-content-end p-0 m-0 ">
                        <!-- Keyword Search -->
                         
                        <div class="col-md-8">
                            <div class="form-group filtration">
                                <input type="text" id="keywordSearch" class="form-control" 
                                       placeholder="Search Orders By Customer Name">
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
                        <?php if ($isUserAdmin): ?>
                            <th>Customer</th>
                        <?php endif; ?>
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
        <?php if ($isUserAdmin): ?>
            // Admin can see all orders
            fetch('/api/orders')
                .then(response => response.json())
                .then(orders => {
                    allOrders = orders;
                    displayOrders(orders);
                })
                .catch(error => console.error("Error loading orders:", error));
        <?php else: ?>
            // Regular user can only see their own orders
            fetch('/api/orders/<?php echo $userId; ?>')
                .then(response => response.json())
                .then(orders => {
                    allOrders = orders;
                    displayOrders(orders);
                })
                .catch(error => console.error("Error loading user orders:", error));
        <?php endif; ?>
    }

    function displayOrders(orders) {
        const tableBody = document.getElementById("ordersTableBody");
        tableBody.innerHTML = '';
        
        orders.forEach(order => {
            const row = document.createElement("tr");
            <?php if ($isUserAdmin): ?>
                row.innerHTML = `
                    <td>${order.user_first_name} ${order.user_last_name}</td>
                    <td>${order.book_title}</td>
                    <td>${order.book_author}</td>
                    <td>${order.quantity}</td>
                `;
            <?php else: ?>
                row.innerHTML = `
                    <td>${order.book_title}</td>
                    <td>${order.book_author}</td>
                    <td>${order.quantity}</td>
                `;
            <?php endif; ?>
            tableBody.appendChild(row);
        });
    }

    <?php if ($isUserAdmin): ?>
        function filterOrders() {
            const searchTerm = document.getElementById('keywordSearch').value.toLowerCase();
            
            let filteredOrders = allOrders;
            
            if (searchTerm) {
                filteredOrders = allOrders.filter(order => 
                    (order.user_first_name && order.user_first_name.toLowerCase().includes(searchTerm)) || 
                    (order.user_last_name && order.user_last_name.toLowerCase().includes(searchTerm))
                );
            }
            
            displayOrders(filteredOrders);
        }

        // Initialize filter for admin only
        document.getElementById('keywordSearch').addEventListener('input', filterOrders);
        <?php endif; ?>

    // Load orders when page loads
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