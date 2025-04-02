<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/header.php';
include __DIR__ . '/navigation-bar.php';
?>

<section class="container-fluid">
    <div class="container text-center py-50">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="text-start m-0 flex-grow-1">Book Catalogue</h1>
    <a href="/createBook" class="button-green" role="button">Create Book</a>
</div>
        <div class="table-responsive">
            <table class="table table-striped text-center">
                <thead class="custom-header">
                    <tr>
                        <th class="color-white" scope="col">ID</th>
                        <th class="color-white" scope="col">Title</th>
                        <th class="color-white" scope="col">Author</th>
                        <th class="color-white" scope="col">Genre</th>
                        <th class="color-white" scope="col">Availability</th>
                        <th class="color-white" scope="col">Price</th>
                        <th class="color-white" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="bookTable">
                </tbody>
            </table>
        </div>
    </div>
</section>

<style>
    .custom-header {
        background-color: #5D4037 !important; /* Dark brown */
    }

    .table tbody tr {
        padding-top: 40px;
        padding-bottom: 30px;
    }

    .table tbody tr td, 
    .table tbody tr th {
        vertical-align: middle !important; /* Align text in the middle */
    }
</style>



<script>
    function loadBooks() {
        fetch('/api/books') // Ensure this endpoint returns JSON
            .then(response => response.json())
            .then(books => {
                books.forEach(book => {
                    appendBook(book);
                });
            })
            .catch(error => console.error("Error loading books:", error));
    }

    function appendBook(book) {
        const newRow = document.createElement("tr");

        // Create the cells for each column
        const idCol = document.createElement("th");
        const titleCol = document.createElement("td");
        const authorCol = document.createElement("td");
        const genreCol = document.createElement("td");
        const availabilityCol = document.createElement("td");
        const priceCol = document.createElement("td");

        // Set the content for each column
        idCol.scope = "row";
        idCol.innerText = `${book.book_id}`;
        titleCol.innerText = book.title;
        authorCol.innerText = book.author;
        genreCol.innerText = book.genre;
        availabilityCol.innerText = `${book.stock}`; // Assuming 'availability' is a boolean
        priceCol.innerText = `$${book.price}`;

        // Create the Actions column and apply styles
        const actionsCol = document.createElement("td");
        actionsCol.style.display = "flex";
        actionsCol.style.alignItems = "stretch";
        actionsCol.style.justifyContent = "center";
        actionsCol.style.gap = "15px"; // Add some spacing between buttons

        // Create Edit button
        // Update the edit button creation in appendBook()
        const editButton = document.createElement("a");
        editButton.classList.add("btn", "btn-primary", "mr-2");
        editButton.style.flex = "1";
        editButton.style.width = "20px";
        editButton.href = `/editBook/${book.book_id}`; // Link to edit page with ID
        editButton.innerHTML = ` 
            <svg class="feather feather-edit" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        `;

        editButton.href = `/editBook/${book.book_id}`;


        // In your appendBook function, modify the delete button creation:
        const deleteButton = document.createElement("button");
        deleteButton.classList.add("btn", "btn-danger");
        deleteButton.style.flex = "1";
        deleteButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
                <path d="M 10 2 L 9 3 L 5 3 C 4.4 3 4 3.4 4 4 C 4 4.6 4.4 5 5 5 L 7 5 L 17 5 L 19 5 C 19.6 5 20 4.6 20 4 C 20 3.4 19.6 3 19 3 L 15 3 L 14 2 L 10 2 z M 5 7 L 5 20 C 5 21.1 5.9 22 7 22 L 17 22 C 18.1 22 19 21.1 19 20 L 19 7 L 5 7 z M 9 9 C 9.6 9 10 9.4 10 10 L 10 19 C 10 19.6 9.6 20 9 20 C 8.4 20 8 19.6 8 19 L 8 10 C 8 9.4 8.4 9 9 9 z M 15 9 C 15.6 9 16 9.4 16 10 L 16 19 C 16 19.6 15.6 20 15 20 C 14.4 20 14 19.6 14 19 L 14 10 C 14 9.4 14.4 9 15 9 z"></path>
            </svg>
        `;

        // Add click event handler
        deleteButton.addEventListener('click', async () => {
                try {
                    
                    const response = await fetch(`/api/books/deleteBook/${book.book_id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        newRow.remove(); // Remove the row from the table
                    } else {
                        console.error('Failed to delete book');
                    }
                } catch (error) {
                    console.error('Error deleting book:', error);
                }
            
        });


        // Append the buttons to the Actions column
        actionsCol.appendChild(editButton);
        actionsCol.appendChild(deleteButton);

        // Append all columns to the row
        newRow.appendChild(idCol);
        newRow.appendChild(titleCol);
        newRow.appendChild(authorCol);
        newRow.appendChild(genreCol);
        newRow.appendChild(availabilityCol);
        newRow.appendChild(priceCol);
        newRow.appendChild(actionsCol);  // Append the actions column with buttons

        // Append the row to the table body
        document.getElementById("bookTable").appendChild(newRow);
    }

    loadBooks();
</script>

<?php
include __DIR__ . '/footer.php';
?>
