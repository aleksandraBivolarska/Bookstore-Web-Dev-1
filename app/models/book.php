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

    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

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
