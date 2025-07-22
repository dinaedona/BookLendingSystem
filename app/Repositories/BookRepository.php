<?php


declare(strict_types=1);

namespace App\Repositories;

use App\Models\Book\Book;
use App\Models\Book\BookId;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class BookRepository
 *
 * Handles direct database queries for books.
 */
class BookRepository
{
    /**
     * Find a book by ID.
     *
     * @param BookId $id
     * @return Book
     * @throws ValidationException
     */
    public function findById(BookId $id): Book
    {
        return Book::fromArray(DB::table('books')->where('id', $id->asInt())->first()->toArray());
    }


    /**
     * Decrement available copies atomically.
     *
     * @param BookId $bookId
     * @return int Number of affected rows.
     */
    public function decrementAvailableCopies(BookId $bookId): int
    {
        return DB::table('books')
            ->where('id', $bookId->asInt())
            ->where('available_copies', '>', 0)
            ->decrement('available_copies');
    }
}
