<?php
require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../models/book.php';

class BookRepository extends BaseRepository{
    
    function getAllBooks() {
        try {
            $stmt = $this->connection->prepare("SELECT book_id, title, author, genre, stock, price, image FROM book");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $booksArray = $stmt->fetchAll();
    
            $books = [];
            foreach ($booksArray as $bookData) {
                $books[] = new Book(
                    $bookData['book_id'],
                    $bookData['title'],
                    $bookData['author'],
                    $bookData['genre'],
                    $bookData['stock'],
                    $bookData['price'],
                    $bookData['image'] 
                );
            }
            return $books;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
    function getBookById($book_id) {
        try {
            $stmt = $this->connection->prepare("SELECT book_id, title, author, genre, stock, price, image FROM book WHERE book_id = :book_id");
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $bookData = $stmt->fetch();
    
            if ($bookData) {
                return new Book(
                    $bookData['book_id'],
                    $bookData['title'],
                    $bookData['author'],
                    $bookData['genre'],
                    $bookData['stock'],
                    $bookData['price'],
                    $bookData['image']
                );
            }
    
            return null;
        } catch (PDOException $e) {
            echo $e;
            return null;
        }
    }
    function createBook($book){
        try{
            $stmt = $this->connection->prepare(
                "INSERT INTO `book`(`book_id`, `title`, `author`, `genre`, `stock`, `price`, `image`) 
                        VALUES (NULL, :title, :author, :genre, :stock, :price, :img)
            ");

            $title = $book->getTitle();
            $author = $book->getAuthor();
            $genre = $book->getGenre();
            $stock = $book->getStock();
            $price = $book->getPrice();
            $image = $book->getImageUrl();
    
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":genre", $genre);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":img", $image);
    
            $stmt->execute(); 
        } catch (PDOException $e){
            echo $e;
        }
    }

    function editBook($updated_book) {
        try {
            $stmt = $this->connection->prepare(
                "UPDATE `book` 
                SET title = :title, author = :author, genre = :genre, stock = :stock, price = :price, image = :image 
                WHERE book_id = :book_id"
            );

            $book_id = $updated_book->getBookId();
            $title = $updated_book->getTitle();
            $author = $updated_book->getAuthor();
            $genre = $updated_book->getGenre();
            $stock = $updated_book->getStock();
            $price = $updated_book->getPrice();
            $image = $updated_book->getImageUrl();
    
            $stmt->bindParam(":book_id", $book_id);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":genre", $genre);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":image", $image); 
    
            $stmt->execute(); 
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function deleteBook($book_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM `book` WHERE book_id = :book_id");
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

}
