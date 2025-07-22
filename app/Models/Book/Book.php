<?php

namespace App\Models\Book;

use App\Utils\Parser;
use Illuminate\Validation\ValidationException;

class Book
{
    private function __construct(
        private readonly BookId $id,
        private readonly Title $title,
        private readonly Author $author,
        private readonly Isbn $isbn,
        private readonly int $availableCopies
    )
    {
    }

    /**
     * @throws ValidationException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            BookId::fromInt(Parser::parseInt($data, 'id')),
            Title::fromString(Parser::parseString($data, 'title')),
            Author::fromString(Parser::parseString($data, 'author')),
            Isbn::fromString(Parser::parseString($data, 'isbn')),
            Parser::parseInt($data, 'available_copies')
        );
    }

    public function getId(): BookId
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getIsbn(): Isbn
    {
        return $this->isbn;
    }

    public function getAvailableCopies(): int
    {
        return $this->availableCopies;
    }

}
