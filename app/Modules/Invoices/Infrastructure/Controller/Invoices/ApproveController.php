<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Controller\Invoices;

use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class ApproveController
{
    public function __construct(private readonly InvoiceFacadeInterface $invoiceFacade)
    {
    }

    public function __invoke(string $invoiceId): JsonResponse
    {
         $this->invoiceFacade->approve(Uuid::fromString($invoiceId));

        return response()->json('Approved', Response::HTTP_OK);
    }
}
