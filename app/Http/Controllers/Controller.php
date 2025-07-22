<?php

namespace App\Http\Controllers;

use App\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class Controller
{
    /**
     * Map exceptions to HTTP status codes.
     *
     * @param Throwable $e
     * @return int
     */
    protected function mapExceptionToStatusCode(Throwable $e): int
    {
        if ($e instanceof OutOfStockException) {
            return 409; // Conflict
        }

        if ($e instanceof ModelNotFoundException) {
            return 404; // Not Found
        }

        if ($e instanceof ValidationException) {
            return 422; // Unprocessable Entity
        }

        return 500; // Internal Server Error
    }
}
