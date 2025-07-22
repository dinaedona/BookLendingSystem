<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Loan\Loan;
use App\Models\Loan\LoanId;
use Illuminate\Support\Facades\DB;

/**
 * Class LoanRepository
 *
 * Handles direct database queries for loans.
 */
class LoanRepository
{
    /**
     * Find a loan by ID.
     *
     * @param int $id
     * @return object
     */
    public function findById(LoanId $id): object
    {
        return Loan::fromArray(DB::table('loans')->where('id', $id)->first()->toArray());
    }

    /**
     * Create a new loan.
     *
     * @param Loan $loan
     * @return LoanId The inserted loan ID.
     */
    public function create(Loan $loan): LoanId
    {
        return LoanId::fromInt(DB::table('loans')->insertGetId([
            'book_id' => $loan->getBookId()->asInt(),
            'member_id' => $loan->getMemberId()->asInt(),
            'loaned_at' => $loan->getLoanedAt(),
            'due_at' => $loan->getDueAt(),
            'created_at' => now(),
            'updated_at' => now(),
        ]));
    }

    /**
     * Mark a loan as returned.
     *
     * @param LoanId $loanId
     * @return void
     */
    public function markAsReturned(LoanId $loanId): void
    {
        DB::table('loans')->where('id', $loanId->asInt())->update([
            'returned_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
