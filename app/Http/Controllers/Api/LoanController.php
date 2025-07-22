<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\CreateLoanRequest;
    use App\Models\Book\BookId;
    use App\Models\User\MemberId;
    use App\Services\LoanService;
    use Illuminate\Http\JsonResponse;
    use Throwable;

    /**
     * Class LoanController
     *
     * Handles loan creation and return endpoints.
     */
class LoanController extends Controller
{
    public function __construct(
        private readonly LoanService $loanService
    )
    {
    }

    /**
     * Create a new loan.
     *
     * @param CreateLoanRequest $request
     * @return JsonResponse
     */
    public function store(CreateLoanRequest $request): JsonResponse
    {
        try {
            $loan = $this->loanService->loanBook(
                BookId::fromInt($request->input('book_id')),
                MemberId::fromInt($request->input('member_id'))
            );

            return response()->json([
                'message' => 'Loan created successfully',
                'loan' => $loan,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $this->mapExceptionToStatusCode($e));
        }
    }



}
