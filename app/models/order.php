<?php

class Order implements JsonSerializable
{
    private int $order_id;
    private int $user_id;
    private string $user_first_name;
    private string $user_last_name;
    private int $book_id;
    private string $book_title;
    private string $book_author;
    private int $quantity;

    public function __construct(
        int $order_id,
        int $user_id,
        string $user_first_name,
        string $user_last_name,
        int $book_id,
        string $book_title,
        string $book_author,
        int $quantity
    ) {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->user_first_name = $user_first_name;
        $this->user_last_name = $user_last_name;
        $this->book_id = $book_id;
        $this->book_title = $book_title;
        $this->book_author = $book_author;
        $this->quantity = $quantity;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getUserFirstName(): string
    {
        return $this->user_first_name;
    }

    public function setUserFirstName(string $user_first_name): void
    {
        $this->user_first_name = $user_first_name;
    }

    public function getUserLastName(): string
    {
        return $this->user_last_name;
    }

    public function setUserLastName(string $user_last_name): void
    {
        $this->user_last_name = $user_last_name;
    }

    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    public function getBookTitle(): string
    {
        return $this->book_title;
    }

    public function setBookTitle(string $book_title): void
    {
        $this->book_title = $book_title;
    }

    public function getBookAuthor(): string
    {
        return $this->book_author;
    }

    public function setBookAuthor(string $book_author): void
    {
        $this->book_author = $book_author;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'user_first_name' => $this->user_first_name,
            'user_last_name' => $this->user_last_name,
            'book_id' => $this->book_id,
            'book_title' => $this->book_title,
            'book_author' => $this->book_author,
            'quantity' => $this->quantity
        ];
    }
}