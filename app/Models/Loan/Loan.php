<?php

namespace App\Models\Loan;

use App\Models\Book\BookId;
use App\Models\User\MemberId;
use App\Utils\Parser;

class Loan
{

    private function __construct(
        private readonly ?LoanId $id,
        private readonly BookId $bookId,
        private readonly MemberId $memberId,
        private readonly string $loanedAt,
        private readonly string $dueAt,
        private readonly ?string $returnedAt,
    )
    {
    }

    /**
     * @param mixed[] $data
     * @return self
     * create loan model from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            LoanId::fromNullableInt(Parser::parseNullableInt($data, 'id')),
            BookId::fromInt(Parser::parseInt($data, 'book_id')),
            MemberId::fromInt(Parser::parseInt($data, 'member_id')),
            Parser::parseString($data, 'loaned_at'),
            Parser::parseString($data, 'due_at'),
            Parser::parseString($data, 'returned_at'),
        );
    }

    /**
     * @param BookId $bookId
     * @param MemberId $memberId
     * @param $loanedAt
     * @param $dueAt
     * @param $returnedAt
     * @return self
     */
    public static function from(
         BookId $bookId,
         MemberId $memberId,
         $loanedAt,
         $dueAt,
         $returnedAt = null,
    ): self
    {
        return new self(
            null,
            $bookId,
            $memberId,
            $loanedAt,
            $dueAt,
            $returnedAt,
        );
    }

    public function getId(): ?LoanId
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
