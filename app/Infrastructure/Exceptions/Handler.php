<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use LogicException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof LogicException) {
            return \response()->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
        }

        if ($e instanceof InvoiceNotFoundException) {
            return \response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof InvoiceInvalidValueException) {
            return \response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);
    }
}
