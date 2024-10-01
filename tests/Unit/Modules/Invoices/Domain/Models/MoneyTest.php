<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Exceptions\InvoiceInvalidValueException;
use App\Modules\Invoices\Domain\Models\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @dataProvider moneyAdditionProvider
     */
    public function testAddMoney($amount1, $currency1, $amount2, $currency2, $expectedAmount, $expectException): void
    {
        $money1 = new Money($amount1, $currency1);
        $money2 = new Money($amount2, $currency2);

        if ($expectException) {
            $this->expectException(InvoiceInvalidValueException::class);
        }

        $result = $money1->add($money2);

        if (!$expectException) {
            $this->assertEquals($expectedAmount, $result->getAmount());
            $this->assertEquals($currency1, $result->getCurrency());
        }
    }

    public function moneyAdditionProvider()
    {
        return [
            [1000, 'USD', 500, 'USD', 1500, false],
            [1000, 'USD', 500, 'EUR', null, true],
        ];
    }

    /**
     * @dataProvider moneyMultiplicationProvider
     */
    public function testMultiplyMoney($amount, $currency, $multiplier, $expectedAmount): void
    {
        $money = new Money($amount, $currency);
        $result = $money->multiply($multiplier);
        $this->assertEquals($expectedAmount, $result->getAmount());
        $this->assertEquals($currency, $result->getCurrency());
    }

    public function moneyMultiplicationProvider()
    {
        return [
            [1000, 'USD', 3, 3000],
            [1000, 'USD', 0, 0],
            [1000, 'USD', -5, -5000],
        ];
    }
}
