<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Models\Invoice as EloquentInvoice;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Models\Address;
use App\Modules\Invoices\Domain\Models\BilledCompany;
use App\Modules\Invoices\Domain\Models\Company;
use App\Modules\Invoices\Domain\Models\EmailAddress;
use App\Modules\Invoices\Domain\Models\Invoice;
use App\Modules\Invoices\Domain\Models\InvoiceNumber;
use App\Modules\Invoices\Domain\Models\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Models\Money;
use App\Modules\Invoices\Domain\Models\PhoneNumber;
use App\Modules\Invoices\Domain\Models\Product;
use App\Modules\Invoices\Domain\Models\ProductLine;
use App\Modules\Invoices\Infrastructure\Mappers\InvoiceMapper;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

final class InvoiceRepository implements InvoiceRepositoryInterface
{
    private InvoiceMapper $invoiceMapper;

    public function __construct()
    {
        $this->invoiceMapper = new InvoiceMapper();
    }

    /**
     * @throws InvoiceNotFoundException
     */
    public function find(string $invoiceId): Invoice
    {
        // Pobieramy fakturę razem z powiązanymi liniami produktów
        $eloquentInvoice =  EloquentInvoice::with([
            'productLines.product',
            'company',
            ])
            ->where('id', $invoiceId)
            ->first();

        if (!$eloquentInvoice) {
            throw new InvoiceNotFoundException('Invoice not found');
        }

        $productLines = $eloquentInvoice->productLines->map(function ($productLine) {
            return new ProductLine(
                new Product(
                    id: Uuid::fromString($productLine->product()->first()->id),
                    name: $productLine->product()->first()->name,
                    unitPrice: new Money($productLine->product()->first()->price),
                ),
                $productLine->quantity,
            );
        })->toArray();

        try {
            return new Invoice(
                id: Uuid::fromString($eloquentInvoice->id),
                invoiceNumber: new InvoiceNumber(Uuid::fromString($eloquentInvoice->number)),
                invoiceDate: new DateTimeImmutable($eloquentInvoice->date),
                dueDate: new DateTimeImmutable($eloquentInvoice->due_date),
                company: new Company( // Przykładowo: mapowanie firmy
                    id: Uuid::fromString($eloquentInvoice->company->id),
                    name: $eloquentInvoice->company->name,
                    address: new Address(
                        street: $eloquentInvoice->company->street,
                        city: $eloquentInvoice->company->city,
                        zipCode: $eloquentInvoice->company->zip
                    ),
                    phone: new PhoneNumber($eloquentInvoice->company->phone),
                    email: new EmailAddress($eloquentInvoice->company->email)
                ),
                billedCompany: new BilledCompany(),
                productLines: $productLines,
                status: StatusEnum::from($eloquentInvoice->status)
            );
        } catch (Exception $e) {
            throw new InvoiceNotFoundException('Invoice not found');
        }
    }

    public function save(Invoice $invoice): void
    {
        $eloquentInvoiceData = $this->invoiceMapper->mapToEloquent($invoice);

        DB::transaction(function () use ($eloquentInvoiceData, $invoice): void {

//            $eloquentInvoice->save();

            $eloquentInvoice = EloquentInvoice::updateOrCreate(
                ['id' => $eloquentInvoiceData->id],
                $eloquentInvoiceData->getAttributes()
            );

            // Zapisz linie produktów, jeśli masz je w encji Invoice
//            foreach ($invoice->getProductLines() as $productLine) {
//                $line = new ProductLine([
//                    'product_id' => $productLine->getProduct()->getId(), // Zakładam, że Product ma metodę getId()
//                    'quantity' => $productLine->getQuantity(),
////                    'price' => $productLine->getProduct()->getUnitPrice()->getAmount(), // Zakładam, że Money ma metodę getAmount()
//                ]);
//
//                // Zapisz linie produktu z powiązaniem do faktury
//                $eloquentInvoice->productLines()->save($line);
//            }
        });
    }
}
