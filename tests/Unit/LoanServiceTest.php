<?php

declare(strict_types=1);

namespace Tests\Unit;

    use App\Exceptions\OutOfStockException;
    use App\Models\Book\Book;
    use App\Models\Book\BookId;
    use App\Models\Loan\Loan;
    use App\Models\User\MemberId;
    use App\Repositories\BookRepository;
    use App\Repositories\LoanRepository;
    use App\Services\LoanService;
    use Carbon\Carbon;
    use PHPUnit\Framework\MockObject\MockObject;
    use Tests\TestCase;
    use stdClass;

    /**
     * Class LoanServiceTest
     *
     * Unit tests for LoanService.
     */
class LoanServiceTest extends TestCase
{
    private LoanService $loanService;
    private MockObject $bookRepository;
    private MockObject $loanRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->loanRepository = $this->createMock(LoanRepository::class);

        $this->loanService = new LoanService(
            $this->bookRepository,
            $this->loanRepository
        );
    }

    /** @test */
    public function testAvailableBookToLoan(): void
    {
        $bookId = BookId::fromInt(1);
        $memberId = 1;


       $book = Book::fromArray([
            'id' => $bookId->asInt(),
            'available_copies' => 3,
            'title' => 'test book title',
            'author' => 'Test Author',
            'isbn' =>'0-306-40615-2'
        ]);

        $this->bookRepository->expects($this->once())
            ->method('findById')
            ->with($bookId)
            ->willReturn($book);

        $this->bookRepository->expects($this->once())
            ->method('decrementAvailableCopies')
            ->with($bookId);


        $loan = Loan::fromArray([
            'book_id' => $bookId->asInt(),
            'member_id' => $memberId,
            'loaned_at' => Carbon::now()->toDateTimeString(),
            'due_at' => Carbon::now()->addDays(7)->toDateTimeString(),
        ]);

        $this->loanRepository->expects($this->once())
            ->method('createLoan')
            ->with($bookId, $memberId, $this->anything(), $this->anything())
            ->willReturn($loan);

        $this->loanService->loanBook($bookId, MemberId::fromInt($memberId));
        $this->assertDatabaseHas('loans', [
            'book_id' => $bookId->asInt(),
            'member_id' => $memberId,
        ]);
    }

    /** @test */
    public function testNotAvailableBookToLoan(): void
    {
        $bookId = BookId::fromInt(1);
        $memberId = 1;

        $book = Book::fromArray([
            'id' => $bookId->asInt(),
            'available_copies' => 3,
            'title' => 'test book title',
            'author' => 'Test Author',
            'isbn' =>'0-306-40615-2'
        ]);

        $this->bookRepository->expects($this->once())
            ->method('findById')
            ->with($bookId)
            ->willReturn($book);

        $this->expectException(OutOfStockException::class);
        $this->expectExceptionMessage("Book 'test book title' is out of stock.");

        $this->loanService->loanBook($bookId, MemberId::fromInt($memberId));
    }

}
