<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Controller\Invoices;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class ShowController extends Controller
{
    public function __construct(private readonly InvoiceFacadeInterface $invoiceFacade)
    {
    }

    public function __invoke(string $invoiceId): JsonResponse
    {
        $invoice = $this->invoiceFacade->getInvoice(Uuid::fromString($invoiceId));

        return response()->json($invoice, Response::HTTP_OK);
    }
}
