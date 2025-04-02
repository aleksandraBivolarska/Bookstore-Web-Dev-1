<?php

class Book implements JsonSerializable
{
    private int $book_id;
    private string $title;
    private string $author;
    private string $genre;
    private int $stock;
    private float $price;
    private string $image;

    public function __construct(
        int $book_id,
        string $title,
        string $author,
        string $genre,
        int $stock,
        float $price,
        string $image
    ) {
        $this->book_id = $book_id;
        $this->title = $title;
        $this->author = $author;
        $this->genre = $genre;
        $this->stock = $stock;
        $this->price = $price;
        $this->image = $image;
    }

    // Getter and Setter for book_id
    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    // Getter and Setter for title
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    // Getter and Setter for author
    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    // Getter and Setter for genre
    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    

    // Getter and Setter for stock
    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    // Getter and Setter for price
    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getImageUrl(): string {
        return $this->image;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
