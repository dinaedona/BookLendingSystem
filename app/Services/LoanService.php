<?php

namespace App\Services;

use App\Exceptions\OutOfStockException;


use App\Models\Book\BookId;
use App\Models\Loan\Loan;
use App\Models\Loan\LoanId;
use App\Models\User\MemberId;
use App\Repositories\BookRepository;
    use App\Repositories\LoanRepository;
    use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

/**
     * Class LoanService
     *
     * Handles book loaning and returning logic.
     */
class LoanService
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly LoanRepository $loanRepository
    )
    {
    }

    /**
     * Create a new loan.
     *
     * @param bookId $bookId
     * @param MemberId $memberId
     * @return LoanId
     *
     * @throws OutOfStockException
     * @throws ValidationException
     */
    public function loanBook(BookId $bookId, MemberId $memberId): LoanId
    {
        $book = $this->bookRepository->findById($bookId);

        if ($book->hasCopies()) {
            throw new OutOfStockException("Book '{$book->getTitle()->asString()}' is out of stock.");
        }
        $book = $this->bookRepository->decrementAvailableCopies($bookId);

        return $this->loanRepository->create(
            Loan::from($bookId, $memberId, Carbon::now()->toDateTimeString(), Carbon::now()->addDays(7)->toDateTimeString()),
        );
    }
}
