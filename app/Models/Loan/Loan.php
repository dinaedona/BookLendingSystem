<?php

namespace App\Models\Loan;

use App\Models\Book\BookId;
use App\Models\User\MemberId;

class Loan
{

    public function __construct(
        private readonly LoanId $id,
        private readonly BookId $bookId,
        private readonly MemberId $memberId,
        private readonly string $loanedAt,
        private readonly string $dueAt,
        private readonly ?string $returnedAt,
    )
    {
    }

    public function getId(): LoanId
    {
        return $this->id;
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }

    public function getMemberId(): MemberId
    {
        return $this->memberId;
    }

    public function getLoanedAt(): string
    {
        return $this->loanedAt;
    }

    public function getDueAt(): string
    {
        return $this->dueAt;
    }

    public function getReturnedAt(): ?string
    {
        return $this->returnedAt;
    }
}
