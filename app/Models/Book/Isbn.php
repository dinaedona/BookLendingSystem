<?php

namespace App\Models\Book;

use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class Isbn
{

    /**
     * Isbn constructor.
     *
     * @param string $isbn
     *
     * @throws InvalidArgumentException If ISBN is invalid.
     */
    private function __construct(private readonly string $isbn)
    {
        $isbn = str_replace(['-', ' '], '', $isbn);

        if (!self::isValid($isbn)) {
            throw new InvalidArgumentException("Invalid ISBN: {$isbn}");
        }
    }

    public static function fromString(string $isbn): self
    {
        return new self($isbn);
    }

    /***
     * @return string
     */
    public function asString(): string
    {
        return $this->isbn;
    }

    /**
     *
     * @param string $isbn
     * @return bool
     */
    public static function isValid(string $isbn): bool
    {
        $isbn = str_replace(['-', ' '], '', $isbn);

        if (strlen($isbn) === 10) {
            return self::isValidIsbn10($isbn);
        }


        return false;
    }

    /**
     * @param string $isbn
     * @return bool
     */
    private static function isValidIsbn10(string $isbn): bool
    {
        if (!preg_match('/^\d{9}[\dX]$/', $isbn)) {
            return false;
        }

        return true;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->isbn;
    }

}
