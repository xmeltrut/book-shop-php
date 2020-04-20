<?php

namespace App\Helper;

class Basket
{
    private $books;

    public function __construct(array $books = [])
    {
        $this->books = $books;
    }

    public function getTotalPrice()
    {
        return array_reduce($this->books, function($carry, $book) {
            return $carry + $book['price'];
        });
        $totalPrice = 0.0;

        foreach ($this->books as $book) {
            $totalPrice += $book['price'];
        }

        return $totalPrice;
    }

    public function getRawPrice()
    {
        return ($this->getTotalPrice() * 100);
    }

    public function getDescription()
    {
        return implode(', ', array_map(function($book) {
            return $book['title'];
        }, $this->books));
    }
}